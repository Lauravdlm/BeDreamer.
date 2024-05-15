<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
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
 * Clase que representa una ciudad.
 * @package App\Controllers
 */
class CityController extends Controller
{

    /**
     * Obtener todas las ciudades en el panel de Administración.
     *
     * @param Request $request Ciudades a obtener (con posibles filtros aplicados)
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse Vista de la tabla de ciudades | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function citiesTable(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todas las ciudades con la posibilidad de aplicar filtros
            $citiesQuery = City::query();
            if ($searchQuery) {
                $citiesQuery->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('country', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $citiesQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $cities = $citiesQuery->paginate(5);

            // Obtener todas las ciudades
            $countries = Country::all();
            // Devolver la vista con las ciudades
            return view('admin.pages.cities-table', compact('cities', 'countries', 'searchQuery'));
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener las ciudades: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Mostrar una lista de ciudades que coincidan con el valor de la búsqueda.
     *
     * @param Request $request Valor de la búsqueda
     *
     * @return JsonResponse|RedirectResponse Redirección con datos JSON de las ciudades que coincidan con la búsqueda en caso de éxito | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse|RedirectResponse
    {
        try {
            // Obtener el valor de la búsqueda
            $query = $request->input('query');
            // Obtener las ciudades que coincidan con la búsqueda
            $cities = City::where('name', 'like', '%' . $query . '%')->pluck('name', 'id');

            // Montar las opciones
            $options = '<option value="" class="option-item">Selecciona una ciudad</option>';
            foreach ($cities as $id => $name) {
                $options .= "<option value='{$id}'>{$name}</option>";
            }

            return response()->json($options);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al mostrar la lista de ciudades: ' . $e->getMessage());
            return redirect()->back();
        }
    }

   /**
     * Crear una nueva ciudad desde el panel de Administración.
     *
     * @param Request $request Datos de la ciudad
     *
     * @return \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector Redireccionamos en caso de éxito con la ciudad creada en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'country_id' => 'required|exists:countries,id',
            ]);

            // Crear la ciudad
            City::create($validatedData);

            session()->flash('success', 'Destino añadido satisfactoriamente.');
            return redirect()->back();
            // Redireccionar después de agregar el destino
            //return redirect('admin-panel/cities-management')->with('success', 'Destino añadido satisfactoriamente.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la ciudad: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Actualizar una determinada ciudad desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor de la ciudad
     * @param int $id ID de la ciudad
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar la ciudad
            $city = City::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $city->$column = $value;

            $city->save();

            // Devolver una respuesta
            // return response()->json(['message' => 'Ciudad actualizada correctamente']);
            session()->flash('success', 'Ciudad actualizada correctamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar la ciudad: ' . $e->getMessage());
            // return response()->json(['error' => 'Ha ocurrido un error al actualizar la ciudad: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar una determinada ciudad desde el panel de Administración.
     *
     * @param int $id ID de la ciudad
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar ciudad por su ID
            $city = City::find($id);
            // Si no encontramos ese ID
            if (!$city) {
                session()->flash('error', 'Ciudad no encontrada.');
                return redirect()->back();
                // return redirect()->route('admin.cities-management.index')->with('error', 'Ciudad no encontrada');
            }

            // Verificar si la ciudad tiene lugares asociados
            if (Place::where('city_id', $id)->exists()) {
                session()->flash('error', 'No se puede eliminar la ciudad porque tiene lugares asociados.');
                // dd(session());
                return redirect()->back();
                // return redirect()->route('admin.cities-management.index')->with('error', 'No se puede eliminar la ciudad porque tiene lugares asociados');
            }
            // Eliminamos la ciudad
            $city->delete();

            session()->flash('success', 'Ciudad eliminada satisfactoriamente.');
            return redirect()->back();
            // return redirect()->route('admin.cities-management.index')->with('success', 'Ciudad eliminada satisfactoriamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la ciudad: ' . $e->getMessage());
            return redirect()->back();
            // return redirect()->route('admin.cities-management.index')->with('error', 'Error al eliminar la ciudad.');
        }
    }
}
