<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Clase que representa un comentario.
 * @package App\Controllers
 */
class CommentController extends Controller
{

   /**
     * Muestra los datos de todos los comentarios en una tabla en el panel de Administración.
     *
     * @param Request $request Solicitud HTTP entrante con los datos de todos los comentarios
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse Vista con todos los datos de los comentarios | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function commentsTable(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            // Validaciones
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);
            // Almacenar en una variable la búsqueda
            $searchQuery = $request->input('search');

            // Obtener todos los comentarios con la posibilidad de aplicar filtros
            $commentsQuery = Comment::query();
            // Si hubiese búsqueda
            if ($searchQuery) {
                $commentsQuery->where('content', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    })
                    ->orWhereHas('blog', function ($query) use ($searchQuery) {
                        $query->where('title', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $commentsQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $comments = $commentsQuery->paginate(5);
            // Obtener todos los usuarios
            $users = User::all();
            // Obtener todos los blogs
            $blogs = Blog::all();
            // Devolver la vista con los comentarios
            return view('admin.pages.comments-table', compact('comments', 'users', 'blogs', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los comentarios: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Almacenar en base de datos un nuevo comentario creado.
     *
     * @param Request $request Datos del comentario
     * @param Blog $blog ID del Blog al que se le va a asignar ese comentario
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito a la vista del Blog donde se ha almacenado el comentario | Redirección HTTP en caso de error a la vista del panel de creación del Blog
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function store(Request $request, Blog $blog): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'content' => 'required|string',
            ]);

            // Obtenemos el ID del Blog que enviaremos por solicitud
            $requestBlogID = $request->input('blog_id');
            // Obtenemos el ID del Blog que hemos recuperado (actual)
            $actualBlogID = $blog->id;
            // dd($requestBlogID . " = ". $actualBlogID);
            // Medida de seguridad para comprobar que el ID del blog que enviaremos coincide con el ID del blog actual
            if ($requestBlogID != $actualBlogID) {
                session()->flash('error', 'El ID del Blog no coincide.');
                return redirect()->back();
            }

            // Crear el comentario
            $comment = new Comment();
            $comment->content = $request->input('content');
            $comment->user_id = $request->user()->id;
            $comment->blog_id = $blog->id;
            $comment->save();

            // Redireccionar a la página del blog con un mensaje de éxito
            session()->flash('success', 'Comentario agregado correctamente.');
            return redirect()->route('blog.show', ['id' => $blog->id]);
            //return redirect()->route('blog.show', ['id' => $blog->id])->with('success', 'Comentario agregado correctamente');
        } catch (\Exception $ex) {
            return back()->withInput()->with('error', 'Ocurrió un error inesperado: ' . $ex->getMessage());
        }
    }

    /**
     * Actualizar un determinado comentario desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del comentario
     * @param int $id ID del comentario
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el comentario
            $comment = Comment::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $comment->$column = $value;

            //Guardar en base de datos
            $comment->save();

            // Devolver una respuesta
            session()->flash('success', 'Comentario actualizado correctamente.');

        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar el comentario: ' . $e->getMessage());

        }
    }

    /**
     * Eliminar un determinado comentario desde el panel de Administración | siendo usuario Administrador drectamente en la página donde se visualizan..
     *
     * @param int $id ID del comentario
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar comentario por su ID
            $comment = Comment::find($id);
            // Si no encontramos ese ID
            if (!$comment) {
                session()->flash('error', 'Comentario no encontrada.');
                // return redirect()->route('admin.comments-management.index');
                return redirect()->back();
            }
            // Eliminamos comentario
            $comment->delete();

            session()->flash('success', 'Comentario eliminado satisfactoriamente.');
            // return redirect()->route('admin.comments-management.index');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el comentario: ' . $e->getMessage());
            // return redirect()->route('admin.comments-management.index');
            return redirect()->back();
        }
    }
}
