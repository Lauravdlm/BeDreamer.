<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Place;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Clase que representa un hotel.
 * @package App\Controllers
 */
class HotelController extends Controller
{

    /**
     * Muestra los datos de todos los hoteles en una tabla en el panel de Administración.
     *
     * @param Request $request Solicitud HTTP entrante con los datos de todas los hoteles
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Vista con todos los datos de los hoteles | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function hotelsTable(Request $request): Factory | View | Application | \Illuminate\Contracts\Foundation\Application  | RedirectResponse
    {
        try {
            // Validaciones
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);
            // Almacenar en una variable la búsqueda
            $searchQuery = $request->input('search');

            // Obtener todos los hoteles con la posibilidad de aplicar filtros
            $hotelsQuery = Hotel::query();
            if ($searchQuery) {
                $hotelsQuery->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('description', 'LIKE', "%$searchQuery%")
                    ->orWhere('services', 'LIKE', "%$searchQuery%")
                    ->orWhere('classification', 'LIKE', "%$searchQuery%")
                    ->orWhere('address', 'LIKE', "%$searchQuery%")
                    ->orWhere('latitude', 'LIKE', "%$searchQuery%")
                    ->orWhere('longitude', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('place', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $hotelsQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $hotels = $hotelsQuery->paginate(5);
            // Obtener todos los destinos
            $places = Place::all();
            // Devolver la vista con los usuarios
            return view('admin.pages.hotels-table', compact('places', 'hotels', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los hoteles: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar una lista de hoteles de un determinado destino.
     *
     * @param Request $request Destino
     *
     * @return JsonResponse|RedirectResponse Datos en formato JSON de los hoteles de un determinado destino | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse | RedirectResponse
    {
        try {
            // Obtener ID del destino
            $placeId = $request->input('place_id');
            // Obtener todos los hoteles que están asociadas a ese ID
            $hotels = Hotel::where('place_id', $placeId)->get();

            // Montar las opciones
            $options = '<option value="">Selecciona un hotel</option>';
            foreach ($hotels as $hotel) {
                $options .= "<option value='{$hotel->id}'>{$hotel->name}</option>";
            }
            // Devolver en formato JSON
            return response()->json($options);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al realizar la búsqueda: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear nuevo hotel desde el panel de Administración.
     *
     * @param Request $request Datos con la información del hotel
     *
     * @return \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector Redireccionamos en caso de éxito con la actividad creada en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): Application | Redirector | \Illuminate\Contracts\Foundation\Application  | RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'nullable|string',
                'services' => 'nullable|string',
                'classification' => 'nullable|integer|between:1,5',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'place_id' => 'required|exists:places,id',
            ]);

            // Procesar la imagen de perfil si se ha proporcionado
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('public/hotels_photos', $filename);
                $validatedData['photo'] = $filename;
            }

            // Crear el hotel
            $hotel = Hotel::create($validatedData);

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Hotel añadido satisfactoriamente');
            // Redireccionar después de agregar el usuario
            return redirect('admin-panel/hotels-management')->with('success', 'Hotel añadido satisfactoriamente');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el hotel.');
        }
    }

    /**
     * Obtener un determinado hotel por su ID.
     *
     * @param int $id ID del hotel
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Redirección a la vista con un determinado hotel | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function show(int $id): Factory | View | Application | \Illuminate\Contracts\Foundation\Application  | RedirectResponse
    {
        try {
            // Recuperar el hotel por su ID con sus relaciones de destino cargadas
            $hotel = Hotel::with('place.city.country')->findOrFail($id);

            // Cargar solo las reseñas relacionadas con este hotel
            $reviews = $hotel->reviews()->with('user')->get();

            // Calcular la media de las puntuaciones de las reseñas
            $totalScore = $reviews->sum('score');
            $averageScore = $reviews->count() > 0 ? $totalScore / $reviews->count() : 0;

            return view('pages.hotel-resume', compact('hotel', 'reviews', 'averageScore'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar el hotel: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los hoteles de un determinado destino.
     *
     * @param Request $request Filtros a aplicar a dichos hoteles
     * @param int $place_id ID del destino
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void Redirección a la vista con unos determinados hoteles (filtradas o no) | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function hotelsByPlace(Request $request, int $place_id)
    {
        try {
            // Obtener el lugar asociado al ID proporcionado
            $place = Place::findOrFail($place_id);

            // Obtener todos los hoteles para un destino específico
            $hotelsQuery = Hotel::where('place_id', $place_id);

            // Aplicar filtro de clasificación
            if ($request->has('classification')) {
                $classification = (array) $request->input('classification'); // Convertir a array si no lo es
                $hotelsQuery->whereIn('classification', $classification);
            }

            // Aplicar filtro de puntuación de usuarios
            if ($request->has('score')) {
                // $score = (float) $request->input('score'); // Convertir a float
                // $hotelsQuery->whereHas('reviews', function ($query) use ($score) {
                //     // Calcular el promedio de puntuaciones de las reseñas
                //     $query->selectRaw('avg(score) as average_score')->groupBy('hotel_id');
                //     $query->having('average_score', '>=', $score);
                // });
                // $stars = (int) $request->input('score');
                // $minScore = $stars - 1;
                // $maxScore = $stars;
                // $hotelsQuery->whereHas('reviews', function ($query) use ($minScore, $maxScore) {
                //     $query->selectRaw('avg(score) as average_score, hotel_id');
                //     $query->groupBy('hotel_id');
                //     $query->having('average_score', '>=', $minScore);
                //     $query->having('average_score', '<=', $maxScore);
                // });

                // $scoreFilter = $request->input('score');
                // $hotelsQuery->whereHas('reviews', function ($query) use ($scoreFilter) {
                //     $query->where('score', $scoreFilter);
                // });

                $scoreFilter = $request->input('score');
                $scoreFilterInt = floor($scoreFilter);
                $hotelsQuery->whereHas('reviews', function ($query) use ($scoreFilterInt) {
                    $query->where('score', $scoreFilterInt);
                });
            }

            // Ordenar por hoteles más recientes
            $hotelsQuery->orderBy('created_at', 'desc');
            // Obtener hoteles paginados
            $hotels = $hotelsQuery->paginate(12);

            // Pasar los datos necesarios a la vista
            return view('pages.hotels-index', compact('place', 'hotels'));
        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al mostrar datos de hoteles: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un determinado hotel desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del hotel
     * @param int $id ID del hotel
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el hotel
            $hotel = Hotel::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $hotel->$column = $value;

            //Guardar en base de datos
            $hotel->save();

            // Devolver una respuesta
            session()->flash('success', 'Hotel actualizado correctamente.');

        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar el hotel: ' . $e->getMessage());

        }
    }

    /**
     * Actualizar la foto desde el panel de Administración.
     *
     * @param Request $request Foto del hotel
     * @param int $id ID de la actividad
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

            // Obtener ID del hotel
            $hotel = Hotel::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/hotels_photos', $fileName);
                $hotel->photo = $fileName;
                $hotel->save();
            }

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la foto del hotel: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Eliminar un determinado hotel desde el panel de Administración.
     *
     * @param int $id ID del hotel
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar hoteles por su ID
            $hotel = Hotel::find($id);
            // Si no encontramos ese ID
            if (!$hotel) {
                session()->flash('error', 'Hotel no encontrado.');
                // return redirect()->route('admin.hotels-management.index');
                return redirect()->back();
            }
            // Eliminamos el hotel
            $hotel->delete();

            session()->flash('success', 'Hotel eliminado satisfactoriamente.');
            // return redirect()->route('admin.hotels-management.index');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el hotel: ' . $e->getMessage());
            // return redirect()->route('admin.hotels-management.index');
            return redirect()->back();
        }
    }
}
