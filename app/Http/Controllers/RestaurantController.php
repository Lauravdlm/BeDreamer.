<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Restaurant;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Clase que representa un restaurante.
 * @package App\Controllers
 */
class RestaurantController extends Controller
{

    /**
     * Función privada para validar datos recibidos por formulario.
     *
     * @param array $data Array de valores a validar
     *
     * @return array|RedirectResponse Array de destinos con la validación realizada en caso de éxito| Redirección HTTP en caso de un error en la validación
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    private function validateData(array $data): array | RedirectResponse
    {
        try {
            return request()->validate([
                'name' => 'required|string|max:50',
                'description' => 'nullable|string',
                'type' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'], // Solo letras
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => ['required', 'string', 'regex:/^[A-Za-z0-9\'\.\-\s\,]+$/'], //  Sólo letras, números, coma, punto, guión, apóstrofe, espacios en blanco
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'place_id' => 'required|exists:places,id',
            ]);
        } catch (ValidationException $e) {
            session()->flash('error', 'Error de validación: ' . $e->getMessage(), 422);
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los restaurantes en el panel de Administración.
     *
     * @param Request $request Restaurantes a obtener (con posibles filtros aplicados)
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Vista de la tabla de restaurantes | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function restaurantsTable(Request $request): Factory | View | Application | \Illuminate\Contracts\Foundation\Application  | RedirectResponse
    {
        try {
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todos los restaurantes con la posibilidad de aplicar filtros
            $restaurantsQuery = Restaurant::query();
            if ($searchQuery) {
                $restaurantsQuery->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('description', 'LIKE', "%$searchQuery%")
                    ->orWhere('type', 'LIKE', "%$searchQuery%")
                    ->orWhere('address', 'LIKE', "%$searchQuery%")
                    ->orWhere('latitude', 'LIKE', "%$searchQuery%")
                    ->orWhere('longitude', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('place', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    });
            }

            // Ordenar por fecha de creación (en orden descendente por defecto)
            $restaurantsQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $restaurants = $restaurantsQuery->paginate(5);

            // Obtener todos los destinos
            $places = Place::all();
            // Devolver la vista con los usuarios
            return view('admin.pages.restaurants-table', compact('places', 'restaurants', 'searchQuery'));

        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los restaurantes: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar una lista de restaurantes para un determinado destino.
     *
     * @param Request $request Valor de la búsqueda
     *
     * @return JsonResponse|RedirectResponse Redirección con datos JSON de los restaurantes que coincidan con la búsqueda en caso de éxito | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse | RedirectResponse
    {
        try {
            $placeId = $request->input('place_id');
            $restaurants = Restaurant::where('place_id', $placeId)->get();

            $options = '<option value="">Selecciona un restaurante</option>';
            foreach ($restaurants as $restaurant) {
                $options .= "<option value='{$restaurant->id}'>{$restaurant->name}</option>";
            }

            return response()->json($options);

        } catch (Exception $e) {
            session()->flash('error', 'Error al realizar la búsqueda: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear nuevo restaurante desde el panel de Administración.
     *
     * @param Request $request Datos con la información del restaurante
     *
     * @return RedirectResponse Redireccionamos en caso de éxito con el restaurante creado en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $this->validateData($request->all());

            // Procesar la imagen de perfil si se ha proporcionado
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('public/restaurants_photos', $filename);
                $validatedData['photo'] = $filename;
            }

            // Crear el restaurante
            Restaurant::create($validatedData);

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Restaurante añadido satisfactoriamente');
            // Redireccionar después de agregar el usuario
            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Error al crear el restaurante.');
            return redirect()->back();
        }
    }

    /**
     * Obtener un determinado restaurante por su ID.
     *
     * @param int $id ID del restaurante
     *
     * @return Application|Factory|View|RedirectResponse Redirección a la vista con un determinado restaurante | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function show(int $id): Application | View | Factory | RedirectResponse
    {
        try {
            // Recuperar el hotel por su ID con sus relaciones de destino cargadas
            $restaurant = Restaurant::with('place.city.country')->findOrFail($id);

            // Cargar solo las reseñas relacionadas con este hotel
            $reviews = $restaurant->reviews()->with('user')->get();
            // Calcular la media de las puntuaciones de las reseñas
            $totalScore = $reviews->sum('score');
            $averageScore = $reviews->count() > 0 ? $totalScore / $reviews->count() : 0;

            // Pasar los datos necesarios a la vista
            return view('pages.restaurant-resume', compact('restaurant', 'reviews', 'averageScore'));

        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar al restaurante: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los restaurantes de un determinado destino.
     *
     * @param Request $request Filtros a aplicar a dichos restaurantes
     *
     * @param int $place_id ID del restaurante
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void Redirección a la vista con unos determinados restaurantes (filtradas o no) | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function restaurantsByPlace(Request $request, int $place_id)
    {
        try {
            // Obtener el lugar asociado al ID proporcionado
            $place = Place::findOrFail($place_id);

            // Obtener todos los restaurantes para un destino específico
            $restaurantsQuery = Restaurant::where('place_id', $place_id);

            if ($request->has('type')) {
                $typeFilter = $request->input('type');
                $restaurantsQuery->where('type', $typeFilter);
            }

            // Aplicar filtro de puntuación de usuarios
            if ($request->has('score')) {
                // $scoreFilter = $request->input('score');
                // $restaurantsQuery->whereHas('reviews', function ($query) use ($scoreFilter) {
                //     $query->where('score', $scoreFilter);
                // });

                $scoreFilter = $request->input('score');
                $scoreFilterInt = floor($scoreFilter);
                $restaurantsQuery->whereHas('reviews', function ($query) use ($scoreFilterInt) {
                    $query->where('score', $scoreFilterInt);
                });

            }

            // Ordenar por restaurantes más recientes
            $restaurantsQuery->orderBy('created_at', 'desc');
            // Obtener restaurantes paginados
            $restaurants = $restaurantsQuery->paginate(12);

            // Obtener los tipos de restaurantes que hay diferentes sin repetir
            $types = Restaurant::where('place_id', $place_id)->distinct()->pluck('type');

            return view('pages.restaurants-index', compact('place', 'restaurants', 'types'));
        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al mostrar datos de restaurantes: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un determinado restaurante desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del restaurante
     * @param int $id ID del hotel
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Validación de los datos del formulario
            $this->validateData($request->all());

            // Buscar el restaurante
            $restaurant = Restaurant::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $restaurant->$column = $value;

            //Guardar en base de datos
            $restaurant->save();

            // Devolver una respuesta
            session()->flash('success', 'Restaurante actualizado correctamente.');

        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar el restaurante: ' . $e->getMessage());

        }
    }

    /**
     * Actualizar la foto desde el panel de Administración.
     *
     * @param Request $request Foto del restaurante
     * @param int $id ID del restaurante
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

            $restaurant = Restaurant::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/restaurants_photos', $fileName);
                $restaurant->photo = $fileName;
                $restaurant->save();
            }

            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Ha ocurrido un error al actualizar la foto del restaurante: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Eliminar un determinado restaurante desde el panel de Administración.
     *
     * @param int $id ID del restaurante
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar restaurante por su ID
            $restaurant = Restaurant::find($id);
            // Si no encontramos ese ID
            if (!$restaurant) {
                session()->flash('error', 'Restaurante no encontrado.');
                // return redirect()->route('admin.restaurants-management.index');
                return redirect()->back();
            }
            // Eliminamos el restaurante
            $restaurant->delete();

            session()->flash('success', 'Restaurante eliminado satisfactoriamente.');
            // return redirect()->route('admin.restaurants-management.index');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el restaurante: ' . $e->getMessage());
            // return redirect()->route('admin.restaurants-management.index');
            return redirect()->back();
        }
    }
}
