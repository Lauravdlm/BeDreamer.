<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Place;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

/**
 * Clase que representa un destino.
 * @package App\Controllers
 */
class PlaceController extends Controller
{
    /**
     * Obtener la vista principal de todos los Destinos paginados.
     *
     * @param Request $request Destinos a obtener (con posibles filtros aplicados)
     *
     * @return Factory|View|Application|\Illuminate\Contracts\Foundation\Application|RedirectResponse Vista con los datos necesarios de los Destinos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function index(Request $request): Factory|View|Application|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            // Obtenemos los destinos aplicando filtros
            $query = $this->filterPlaces($request);

            // Ordenar los resultados por los más nuevos y paginarlos
            $places = $query->orderBy('created_at', 'desc')->paginate(8);

            return view('pages.places-index', compact('places'));

        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Función privada para validar datos recibidos por formulario.
     *
     * @param array $data Array de valores a validar
     *
     * @return array|RedirectResponse Array de destinos con la validación realizada en caso de éxito| Redirección HTTP en caso de un error en la validación
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */

    private function validateData(array $data): array|RedirectResponse
    {
        try {
            return request()->validate([
                'name' => 'required|string|max:50',
                'description' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'city_id' => 'required|exists:cities,id',
            ]);
        } catch (ValidationException $e) {
             session()->flash('error', 'Error de validación: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los destinos en el panel de Administración.
     *
     * @param Request $request Destinos a obtener (con posibles filtros aplicados)
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Vista de la tabla de Destinos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function placesTable(Request $request): Factory|View|Application|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todos los destinos con la posibilidad de aplicar filtros
            $placesQuery = Place::query();
            if ($searchQuery) {
                $placesQuery->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('description', 'LIKE', "%$searchQuery%")
                    ->orWhere('latitude', 'LIKE', "%$searchQuery%")
                    ->orWhere('longitude', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('city', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    });
            }

            // Ordenar por fecha de creación
            $placesQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $places = $placesQuery->paginate(5);

            //Obtener todas las ciudades
            $cities = City::all();
            // Devolver la vista con los destinos
            return view('admin.pages.places-table', compact('places', 'cities', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los destinos: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Función privada para aplicar filtros a los destinos.
     *
     * @param Request $request Valor con los datos de filtrado
     *
     * @return Builder|RedirectResponse Destinos con los filtros aplicados | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    private function filterPlaces(Request $request): Builder|RedirectResponse
    {
        try {
            $query = Place::query();

            // Filtrar por ciudad
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }

            // Filtrar por país
            if ($request->has('country_id')) {
                $query->whereHas('city', function ($query) use ($request) {
                    $query->where('country_id', $request->country_id);
                });
            }
            return $query;

        } catch (Exception $e) {
            session()->flash('error', 'Error al realizar el filtrado: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar una lista de destinos que coincidan con el valor de la búsqueda.
     *
     * @param Request $request Valor de la búsqueda
     *
     * @return JsonResponse|RedirectResponse Redirección con datos JSON de los destinos que coincidan con la búsqueda en caso de éxito | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $query = $request->input('query');
            $places = Place::where('name', 'LIKE', "%$query%")->get();

            $options = '<option value="">Selecciona un destino</option>';
            foreach ($places as $place) {
                $options .= "<option value='{$place->id}'>{$place->name}</option>";
            }

            return response()->json($options);
        } catch (Exception $e) {
            session()->flash('error', 'Error al realizar la búsqueda: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear un nuevo destino desde el panel de Administración.
     *
     * @param Request $request Datos del destino
     *
     * @return \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector Redireccionamos en caso de éxito con el destino creado en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $this->validateData($request->all());

            // Procesar la imagen de perfil si se ha proporcionado
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('public/places_photos', $filename);
                $validatedData['photo'] = $filename;
            }

            // Crear el destino
            $place = Place::create($validatedData);
            // Redireccionar después de agregar el destino
            session()->flash('success', 'Destino añadido satisfactoriamente.');
            return redirect()->back();
            //return redirect('admin-panel/places-management')->with('success', 'Destino añadido satisfactoriamente');

        } catch (Exception $e) {
            session()->flash('error', 'Error al crear el destino.');
            return redirect()->back();
            // return redirect()->back()->with('error', 'Error al crear el destino.');
        }
    }

    /**
     * Obtener la vista de un determinado destino con todos sus datos.
     *
     * @param int $id ID del destino
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Redirección HTTP a la vista del destino | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución     *
     */
    public function show(int $id)
    {
        try {
            // Recuperar el destino por su ID con sus relaciones de ciudad y país cargadas
            $place = Place::with('city.country')->findOrFail($id);

            // Obtener la ciudad y país del destino
            $city_name = $place->city->name;
            $country_name = $place->city->country->name;

            // Pasar el nombre del destino a la vista
            return view('pages.place-resume', compact('place', 'city_name', 'country_name'));

        } catch (Exception $e) {
            session()->flash('error', 'Error al mostrar el destino: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Actualizar un determinado destino desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del destno
     * @param int $id ID del destino
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el destino
            $place = Place::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $place->$column = $value;

            $place->save();

            // Devolver una respuesta
            session()->flash('success', 'Destino actualizado correctamente.');
        } catch (Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al actualizar el destino: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar la foto de un determinado destino desde el panel de Administración.
     *
     * @param Request $request Datos de la foto a actualizar
     * @param int $id ID del destino
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

            $place = Place::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/places_photos', $fileName);
                $place->photo = $fileName;
                $place->save();
            }

            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al actualizar la foto del destino: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Eliminar un determinado destino desde el panel de Administración.
     *
     * @param  int  $id
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar destino por su ID
            $place = Place::find($id);
            // Si no encontramos ese ID
            if (!$place) {
                session()->flash('error', 'Destino no encontrado.');
                // return redirect()->route('admin.places-management.index');
                return redirect()->back();
            }
            // Eliminamos el destino
            $place->delete();

            session()->flash('success', 'Destino eliminado satisfactoriamente.');
            // return redirect()->route('admin.places-management.index');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el destino: ' . $e->getMessage());
            // return redirect()->route('admin.places-management.index');
            return redirect()->back();
        }
    }
}
