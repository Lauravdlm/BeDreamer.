<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Place;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Clase que representa un blog.
 * @package App\Controllers
 */
class BlogController extends Controller
{

    /**
     * Obtener la vista principal de todos los Blogs paginados.
     *
     * @param Request $request Blogs a obtener (con posibles filtros aplicados)
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse  Vista con los datos necesarios de los Blogs | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function index(Request $request): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Obtenemos los blogs aplicando filtros
            $query = $this->filterBlogs($request);

            // Ordenar los resultados por los más nuevos y paginarlos
            $blogs = $query->orderBy('created_at', 'desc')->paginate(8);

            return view('pages.blogs-index', compact('blogs'));
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los blogs en el panel de Administración.
     *
     * @param Request $request Blogs a obtener (con posibles filtros aplicados)
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Vista de la tabla de Blogs | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function blogsTable(Request $request): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {

            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todos los blogs con la posibilidad de aplicar filtros
            $blogsQuery = Blog::query();
            if ($searchQuery) {
                $blogsQuery->where('title', 'LIKE', "%$searchQuery%")
                    ->orWhere('content', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    })
                    ->orWhereHas('place', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $blogsQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $blogs = $blogsQuery->paginate(5);

            //Obtener todos los usuarios
            $users = User::all();
            //Obtener todos los destinos
            $places = Place::all();

            // Devolver la vista
            return view('admin.pages.blogs-table', compact('blogs', 'users', 'places', 'searchQuery'));

        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los blogs: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Función privada para aplicar filtros a los blogs.
     *
     * @param Request $request Valor con los datos de filtrado
     *
     * @return Builder|RedirectResponse Blogs con los filtros aplicados | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    private function filterBlogs(Request $request): Builder | RedirectResponse
    {
        try {
            $query = Blog::query();

            // Si recibimos filtrar por el ID del destino
            if ($request->has('place_id')) {
                // Devolvemos todos los blogs que pertenecen a ese Destino
                $query->where('place_id', $request->place_id);
            }
            // Por ID de la ciudad
            if ($request->has('city_id')) {
                $query->whereHas('place', function ($query) use ($request) {
                    $query->where('city_id', $request->city_id);
                });
            }
            // Por ID del país
            if ($request->has('country_id')) {
                $query->whereHas('place.city.country', function ($query) use ($request) {
                    $query->where('id', $request->country_id);
                });
            }
            // Devolver Blogs con los filtros aplicados
            return $query;
        } catch (Exception $e) {
            session()->flash('error', 'Error al realizar el filtrado: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar el formulario de creación de un Blog.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Redirección HTTP a la vista de creación del Blog | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Obtener la lista de destinos para mostrar en el formulario
            $places = Place::pluck('name', 'id');

            return view('pages.blog-post-create', compact('places'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar el formulario de creación del blog.');
            return redirect()->back();
        }
    }

    /**
     * Almacenar en base de datos un nuevo Blog creado.
     *
     * @param Request $request Datos del nuevo Blog
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito a la vista del Blog creado | Redirección HTTP en caso de error a la vista del panel de creación del Blog
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'title' => 'required|string|max:50',
                'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'content' => 'required|string',
                'place_id' => 'required|max:50|exists:places,id', // Validar que el ID del destino exista en la tabla places
            ]);

            // Obtener el usuario autenticado
            $user = Auth::user();

            // Subir la nueva foto
            if ($request->has('photo')) {
                $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/blog_photos', $photoName);
            }

            // Crear una nueva instancia de Blog
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->photo = $photoName;
            $blog->content = $request->content;
            $blog->place_id = $request->place_id;
            $blog->user_id = $user->id;

            // Guardar el blog en la base de datos
            $blog->save();

            // Redirigir a la vista del blog recién creado
            session()->flash('success', 'Blog creado satisfactoriamente.');
            return redirect()->route('blog.show', ['id' => $blog->id]);
            // return redirect()->route('blog.show', ['id' => $blog->id])->with('success', 'Blog creado satisfactoriamente.');
        } catch (Exception $e) {
            session()->flash('error', 'Error al crear el blog: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener la vista de un determinado Blog con todos sus datos.
     *
     * @param int $id ID del Blog
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Redirección HTTP a la vista del Blog | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function show(int $id): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Recuperar el blog por su ID
            $blog = Blog::findOrFail($id);

            // Acceder a los comentarios del blog
            $comments = $blog->comments;
            // Acceder a los comentarios del blog ordenados por la fecha de creación descendente
            $comments = $blog->comments()->with('user')->latest()->get();
            // Modificar la fecha de los comentarios para transformarla en formato: diferencia de tiempo
            $comments->transform(function ($comment) {
                $comment->creat_at_diff = $comment->created_at->diffForHumans();
                return $comment;
            });

            // Pasar el blog a la vista
            return view('pages.blog-post', compact('blog', 'comments'));

        } catch (\Exception $e) {
            session()->flash('error', 'Error al mostrar el blog: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar el formulario para la edición de un determinado Blog.
     *
     * @param int $id ID del Blog
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Redirección HTTP a la vista de edición del Blog | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function edit(int $id): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Recuperar el blog por su ID
            $blog = Blog::findOrFail($id);

            // Obtener el ID del usuario autenticado
            $user = auth()->user()->id;
            // Obtener el ID del usuario asociado a ese favorito
            $userBlogID = $blog->user_id;
            // Medida de seguridad para comprobar que el usuario autenticado es el usuario asociado a ese blog
            if ($user != $userBlogID) {
                session()->flash('error', 'Este usuario no coincide con el usuario asociado.');
                Log::error("Este usuario no coincide con el usuario asociado.");
                return redirect()->back();
            }

            // Obtener todas las ciudades
            $places = Place::all();
            // Pasar el blog a la vista
            return view('pages.blog-post-edit', compact('blog', 'places'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar el formulario de edición del blog.');
            return redirect()->back();
        }
    }

    /**
     * Actualizar un determinado Blog desde el panel de usuario.
     *
     * @param Request $request Información con los datos del Blog
     * @param int $id ID del Blog
     *
     * @return RedirectResponse|void  Redirección HTTP a la vista del Blog con los datos actualizados
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id)
    {
        try {
            // Recuperar el blog por su ID
            $blog = Blog::findOrFail($id);

            // Obtener el ID del usuario autenticado
            $user = auth()->user()->id;
            // Obtener el ID del usuario asociado a ese favorito
            $userBlogID = $blog->user_id;
            // Medida de seguridad para comprobar que el usuario autenticado es el usuario asociado a ese blog
            if ($user != $userBlogID) {
                session()->flash('error', 'Este usuario no coincide con el usuario asociado.');
                Log::error("Este usuario no coincide con el usuario asociado.");
                return redirect()->back();
            }

            // Validar los datos del formulario
            $request->validate([
                'title' => 'sometimes|string|max:50',
                'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'content' => 'sometimes',
                'place_name' => 'sometimes|string|max:50',
            ]);

            // Actualizar los datos del blog
            $blog->title = $request->input('title');

            // Actualizar la foto de perfil si se proporciona
            if ($request->hasFile('photo')) {
                // Eliminar la foto anterior si existe
                if ($blog->photo) {
                    Storage::delete('blogphotos/' . $blog->photo);
                }
                // Establecer nombre a la foto
                $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
                // Almacenar en Storage
                $request->file('photo')->storeAs('public/blog_photos', $photoName);
                // Guardar el nombre de la foto en la base de datos
                $blog->photo = $photoName;
            }

            $blog->content = $request->input('content');

            // Actualizar el destino solo si se proporciona un nuevo nombre de destino
            if ($request->has('place_name')) {

                // Buscar el destino por su nombre
                $place = Place::where('name', $request->input('place_name'))->first();
                // Verificar si el destino existe
                if (!$place) {
                    // Si el destino no existe
                    return redirect()->back()->with('error', 'El destino proporcionado no existe');
                }
                $blog->place_id = $place->id;
            }

            // Actualizar el lugar solo si se proporciona un nuevo place_id
            if ($request->has('place_id')) {
                $blog->place_id = $request->input('place_id');
            }

            $blog->save();

            // Redireccionar
            return redirect()->route('blog.show', ['id' => $blog->id])->with('success', '¡Datos actualizados correctamente!');
            // Devolver una respuesta JSON
            // return response()->json(['message' => 'Blog actualizado correctamente']);
        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al actualizar el blog: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un determinado Blog desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del blog
     * @param int $id ID del Blog
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function updateAdmin(Request $request, int $id): void
    {
        try {
            // Buscar la ciudad
            $blog = Blog::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            // $blog->$column = $value;

            // $blog->save();

            // Verificar que exite el atributo en la tabla del blog
            if ($blog->getAttribute($column)) {
                //Asignar el valor
                $blog->$column = $value;
                $blog->save();

                // Devolver una respuesta
                session()->flash('success', 'Blog actualizado correctamente.');
            } else {
                // Manejar el caso en que el atributo no exista en el modelo
                session()->flash('error', 'El atributo especificado no existe en el modelo.');
            }

            // Devolver una respuesta
            session()->flash('success', 'Blog actualizado correctamente.');
        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar el blog: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar la foto de un determinado Blog desde el panel de Administración.
     *
     * @param Request $request Datos de la foto a actualizar
     * @param int $id ID del Blog
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function updatePhoto(Request $request, int $id): RedirectResponse
    {
        try {
            // Validar la foto
            $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $blog = Blog::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/blog_photos', $fileName);
                $blog->photo = $fileName;
                $blog->save();
            }

            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Ha ocurrido un error al actualizar la foto del blog: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Eliminar un determinado Blog (desde el panel de usuario o el panel de Administración).
     *
     * @param int $id ID del Blog
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            //Buscar blog por su ID
            $blog = Blog::find($id);

            // Obtener el ID del usuario autenticado
            $user = auth()->user()->id;
            // Obtener el ID del usuario asociado a ese favorito
            $userBlogID = $blog->user_id;

            // Medida de seguridad para comprobar que el usuario autenticado es el usuario asociado a ese blog antes de visualizarlo
            // En este caso comprobaremos también si el usuario autenticado es administrador (ya que reutilizamos la función en el BackOffice)
            if (Auth::user()->role_id !== 1 && Auth::user()->role->name !== "Administrador") {
                if ($user != $userBlogID) {
                    session()->flash('error', 'Este usuario no coincide con el usuario asociado.');
                    Log::error("Este usuario no coincide con el usuario asociado.");
                    return redirect()->back();
                } else {
                    // Si no encontramos ese ID
                    if (!$blog) {
                        session()->flash('error', 'Blog no encontrado.');
                        return redirect()->back(); // Redireccionar
                    }
                    // Eliminamos el blog
                    $blog->delete();
                    session()->flash('success', 'Blog eliminado satisfactoriamente.');
                    return redirect()->back(); // Redireccionar
                }
            } else {
                // Si no encontramos ese ID
                if (!$blog) {
                    session()->flash('error', 'Blog no encontrado.');
                    return redirect()->back(); // Redireccionar
                }
                // Eliminamos el blog
                $blog->delete();

                session()->flash('success', 'Blog eliminado satisfactoriamente.');
                return redirect()->back(); // Redireccionar
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el blog: ' . $e->getMessage());
            return redirect()->back(); // Redireccionar
        }
    }
}
