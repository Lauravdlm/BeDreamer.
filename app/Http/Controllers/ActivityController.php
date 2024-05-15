<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Place;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Clase que representa una actividad.
 * @package App\Controllers
 */
class ActivityController extends Controller
{

    /**
     * Muestra los datos de todos las actividades en una tabla en el panel de Administración.
     *
     * @param Request $request Solicitud HTTP entrante con los datos de todas las actividades.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Vista con todos los datos de las actividades | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function activitiesTable(Request $request): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Validaciones
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);
            // Almacenar en una variable la búsqueda
            $searchQuery = $request->input('search');

            // Obtener todas las actividades con la posibilidad de aplicar filtros
            $activitiesQuery = Activity::query();
            // Si hubiese búsqueda
            if ($searchQuery) {
                $activitiesQuery->where('name', 'LIKE', "%$searchQuery%") // coincidir el input con el valor que hay en base de datos
                    ->orWhere('description', 'LIKE', "%$searchQuery%")
                    ->orWhere('type', 'LIKE', "%$searchQuery%")
                    ->orWhere('price', 'LIKE', "%$searchQuery%")
                    ->orWhere('address', 'LIKE', "%$searchQuery%")
                    ->orWhere('latitude', 'LIKE', "%$searchQuery%")
                    ->orWhere('longitude', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('place', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $activitiesQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $activities = $activitiesQuery->paginate(5);
            // Obtener todos los destinos
            $places = Place::all();
            // Devolver la vista con las actividades
            return view('admin.pages.activities-table', compact('places', 'activities', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener las actividades: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     *  Mostrar una lista de actividades de un determinado destino.
     *
     * @param Request $request Destino
     *
     * @return JsonResponse|RedirectResponse Datos en formato JSON de las actividades de un determinado destino | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse | RedirectResponse
    {
        try {
            // Obtener ID del destino
            $placeId = $request->input('place_id');
            // Obtener todas las actividades que están asociadas a ese ID
            $activities = Activity::where('place_id', $placeId)->get();

            // Montar las opciones
            $options = '<option value="">Selecciona una actividad</option>';
            foreach ($activities as $activity) {
                $options .= "<option value='{$activity->id}'>{$activity->name}</option>";
            }
            // Devolver en formato JSON
            return response()->json($options);
        } catch (Exception $e) {
            session()->flash('error', 'Error al realizar la búsqueda: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear nueva actividad desde el panel de Administración.
     *
     * @param Request $request Datos con la información de la actividad
     *
     * @return \Illuminate\Foundation\Application|Redirector|Application|RedirectResponse Redireccionamos en caso de éxito con la actividad creada en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): \Illuminate\Foundation\Application  | Redirector | Application | RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'nullable|string',
                'type' => 'nullable|string',
                'price' => 'nullable|numeric',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'place_id' => 'required|exists:places,id',
            ]);

            // Procesar la imagen de perfil si se ha proporcionado
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('public/activities_photos', $filename);
                $validatedData['photo'] = $filename;
            }

            // Crear actividad
            Activity::create($validatedData);

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Actividad añadida satisfactoriamente');
            // Redireccionar después de agregar el usuario
            return redirect()->back();
            // return redirect('admin-panel/activities-management')->with('success', 'Actividad añadida satisfactoriamente');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear  la actividad.');
        }
    }

    /**
     * Obtener una determinada actividad por su ID.
     *
     * @param int $id ID de la actividad
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Redirección a la vista con una determinada actividad | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function show(int $id): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Recuperar la actividad por su ID con sus relaciones de destino cargadas
            $activity = Activity::with('place.city.country')->findOrFail($id);

            // Acceder a las reseñas del blog
            $reviews = $activity->reviews()->with('user')->get();

            // Calcular la media de las puntuaciones de las reseñas
            $totalScore = $reviews->sum('score');
            $averageScore = $reviews->count() > 0 ? $totalScore / $reviews->count() : 0;

            // Pasar los datos necesarios a la vista
            return view('pages.activity-resume', compact('activity', 'reviews', 'averageScore'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar la actividad: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todas las actividades de un determinado destino.
     *
     * @param Request $request Filtros a aplicar a dichas actividades
     * @param int $place_id ID del destino
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|void Redirección a la vista con unas determinadas actividades (filtradas o no) | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function activitiesByPlace(Request $request, int $place_id)
    {
        try {
            // Obtener un determinado destino dependiendo del ID que nos llegue
            $place = Place::findOrFail($place_id);
            // Actividades que pertenecen a ese ID
            $activitiesQuery = Activity::where('place_id', $place_id);

            // Filtro por precio
            if ($request->has('price')) {
                $priceFilter = $request->input('price');
                if ($priceFilter == 'free') {
                    $activitiesQuery->where('price', 0);
                } elseif ($priceFilter == 'paid') {
                    $activitiesQuery->where('price', '>', 0);
                }
            }

            // Filtro por tipo
            if ($request->has('type')) {
                $typeFilter = $request->input('type');
                $activitiesQuery->where('type', $typeFilter);
            }

            // Filtro por puntuación de usuarios
            if ($request->has('score')) {
                // $score = (float) $request->input('score'); // Convertir a float
                // $activitiesQuery->whereHas('reviews', function ($query) use ($score) {
                //     // Calcular el promedio de puntuaciones de las reseñas
                //     $query->selectRaw('avg(score) as average_score')->groupBy('activity_id');
                //     $query->having('average_score', '>=', $score);
                // });
                // $stars = (int) $request->input('score');
                // $minScore = $stars - 1;
                // $maxScore = $stars;
                // $activitiesQuery->whereHas('reviews', function ($query) use ($minScore, $maxScore) {
                //     $query->selectRaw('avg(score) as average_score, activity_id');
                //     $query->groupBy('activity_id');
                //     $query->having('average_score', '>=', $minScore);
                //     $query->having('average_score', '<=', $maxScore);
                // });
                // $scoreFilter = $request->input('score');

                $scoreFilter = $request->input('score');
                $scoreFilterInt = floor($scoreFilter);
                $activitiesQuery->whereHas('reviews', function ($query) use ($scoreFilterInt) {
                    $query->where('score', $scoreFilterInt);
                });
            }

            // Ordenar por actividades más recientes
            $activitiesQuery->orderBy('created_at', 'desc');
            // Obtener las actividades paginadas
            $activities = $activitiesQuery->paginate(12);
            // Obtener los tipos de actividades que hay sin repetir
            $types = Activity::where('place_id', $place_id)->distinct()->pluck('type');

            return view('pages.activities-index', compact('place', 'activities', 'types'));
        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al mostrar datos de actividades: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar una determinada actividad desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor de la actividad
     * @param int $id ID de la actividad
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el hotel
            $activity = Activity::findOrFail($id);

            // Obtener la columna de la tabla
            $column = $request->input('column');
            // Obtener su valor
            $value = $request->input('value');
            // Actualizar el valor de la columna
            $activity->$column = $value;

            //Guardar en base de datos
            $activity->save();

            // Devolver una respuesta
            session()->flash('success', 'Actividad actualizada correctamente.');

        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al actualizar la actividad: ' . $e->getMessage());

        }
    }

    /**
     * Actualizar la foto desde el panel de Administración.
     *
     * @param Request $request Foto de la actividad
     *
     * @param int $id ID de la actividad
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function updatePhoto(Request $request, int $id): RedirectResponse
    {
        try {
            // Validar foto
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Obtener ID de la actividad
            $activity = Activity::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                // Establecer nombre a la foto
                $fileName = time() . '_' . $photo->getClientOriginalName();
                // Almacenar en Storage
                $photo->storeAs('public/activities_photos', $fileName);
                // Actualizar su valor en base de datos
                $activity->photo = $fileName;
                $activity->save();
            }
            // Redirección a la misma página desde donde se realiza la petición
            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Error al actualizar la foto de la actividad: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Eliminar una determinada actividad desde el panel de Administración.
     *
     * @param int $id ID de la actividad
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar actividad por su ID
            $activity = Activity::find($id);
            // Si no encontramos ese ID
            if (!$activity) {
                session()->flash('error', 'Actividad no encontrada.');
                return redirect()->back();
                // return redirect()->route('admin.activities-management.index');
            }
            // Eliminamos actividad
            $activity->delete();

            session()->flash('success', 'Actividad eliminada satisfactoriamente.');
            // return redirect()->route('admin.activities-management.index');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar la actividad: ' . $e->getMessage());
            // return redirect()->route('admin.activities-management.index');
            return redirect()->back();
        }
    }
}
