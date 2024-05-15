<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Clase que representa un país.
 * @package App\Controllers
 */
class CountryController extends Controller
{

    /**
     * Obtener todos los países en el panel de Administración.
     *
     * @param Request $request Países a obtener (con posibles filtros aplicados)
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse  Vista de la tabla de paises | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function countriesTable(Request $request): Factory|View|\Illuminate\Foundation\Application|Application|RedirectResponse
    {
        try {
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todos los países con la posibilidad de aplicar filtros
            $countriesQuery = Country::query();
            if ($searchQuery) {
                $countriesQuery->where('name', 'LIKE', "%$searchQuery%");
            }

            // Ordenar por fecha de creación
            $countriesQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $countries = $countriesQuery->paginate(5);

            // Devolver la vista con los países
            return view('admin.pages.countries-table', compact('countries', 'searchQuery'));
        } catch (\Exception $e) {
            session()->flash('error', 'Error al obtener los paises: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Mostrar una lista de ciudades que coincidan con el valor de la búsqueda.
     *
     * @param Request $request Valor de la búsqueda
     *
     * @return JsonResponse|RedirectResponse Redirección con datos JSON de los países que coincidan con la búsqueda en caso de éxito | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function search(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $query = $request->input('query');
            // Realiza la búsqueda de países que coincidan con la consulta
            $countries = Country::where('name', 'like', '%' . $query . '%')->pluck('name', 'id');

            $options = '<option value="" class="option-item">Selecciona un país</option>';
            foreach ($countries as $id => $name) {
                $options .= "<option value='{$id}'>{$name}</option>";
            }

            // Devolvemos una respuesta de tipo JSON con los datos de los países que coincidan con nuesta búsqueda
            return response()->json($options);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al mostrar la lista de países: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear un nuevo país desde el panel de Administración.
     *
     * @param Request $request Datos del país
     *
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector Redireccionamos en caso de éxito con el país creado en base de datos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function create(Request $request): \Illuminate\Foundation\Application|Redirector|Application|RedirectResponse
    {
        try {
            // Validación de los datos del formulario
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑçÇ\s]+$/'],
            ]);

            // Crear el pais
            Country::create($validatedData);
            // Redireccionar después de agregar el pais
            session()->flash('success', 'País añadido satisfactoriamente.');
            return redirect()->back();
            //return redirect('admin-panel/countries-management')->with('success', 'Pais añadido satisfactoriamente');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el país: ' . $e->getMessage());
            return redirect()->back();
            //return redirect()->back()->with('error', 'Error al crear el pais.');
        }
    }

    /**
     * Actualizar un determinado país desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del país
     * @param int $id ID del país
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el país
            $country = Country::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $country->$column = $value;

            $country->save();

            // Devolver una respuesta
            // return response()->json(['message' => 'Pais actualizado correctamente']);
            session()->flash('success', 'Pais actualizado correctamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            // return response()->json(['error' => 'Ha ocurrido un error al actualizar el pais: ' . $e->getMessage()], 500);
            session()->flash('error', 'Ha ocurrido un error al actualizar el pais: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un determinado país desde el panel de Administración.
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
            // Buscar país por su ID
            $country = Country::find($id);
            // Si no encontramos ese ID
            if (!$country) {
                session()->flash('error', 'Pais no encontrado.');
                // return redirect()->route('admin.countries-management.index');
                return redirect()->back();
            }
            // Eliminamos el pais
            $country->delete();

            session()->flash('success', 'Pais eliminado satisfactoriamente.');
            // return redirect()->route('admin.countries-management.index');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el pais: ' . $e->getMessage());
            // return redirect()->route('admin.countries-management.index');
            return redirect()->back();
        }
    }
}
