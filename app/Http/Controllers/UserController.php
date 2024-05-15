<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Clase que representa un usuario (registrado o no).
 * @package App\Controllers
 */
class UserController extends Controller
{
    /**
     * Función privada para validar datos recibidos por formulario.
     *
     * @param array $data Array de valores a validar
     *
     * @return array|RedirectResponse Array de usuarios con la validación realizada en caso de éxito| Redirección HTTP en caso de un error en la validación
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    private function validateData(array $data): array|RedirectResponse
    {
        try {
        return request()->validate([
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
            'surname' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
            'username' => 'required|string|unique:users',
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users', 'regex:/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i'],
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram' => 'nullable|string|max:50',
            'webpage' => 'nullable|string|max:100',
            'city_id' => 'nullable|exists:cities,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        } catch (ValidationException $e) {
            session()->flash('error', 'Error de validación: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener todos los usuarios en el panel de Administración.
     *
     * @param Request $request Usuarios a obtener (con posibles filtros aplicados)
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse Vista de la tabla de usuarios | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function usersTable(Request $request): Factory|View|Application|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {

            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');

            // Obtener todos los usuarios con la posibilidad de aplicar filtros
            $usersQuery = User::query();
            if ($searchQuery) {
                $usersQuery->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('surname', 'LIKE', "%$searchQuery%")
                    ->orWhere('username', 'LIKE', "%$searchQuery%")
                    ->orWhere('email', 'LIKE', "%$searchQuery%")
                    ->orWhere('instagram', 'LIKE', "%$searchQuery%")
                    ->orWhere('webpage', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('city', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    })
                    ->orWhereHas('role', function ($query) use ($searchQuery) {
                        $query->where('name', 'LIKE', "%$searchQuery%");
                    });
            }

            // Ordenar por fecha de creación
            $usersQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $users = $usersQuery->paginate(5);

            // Obtener ciudades y roles
            $cities = City::all();
            $roles = Role::all();

            // Devolver la vista con los usuarios
            return view('admin.pages.users-table', compact('users', 'cities', 'roles', 'searchQuery'));

        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los usuarios: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Actualizar un determinado usuario desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del usuario
     * @param int $id ID del usuario
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar el usuario
            $user = User::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $user->$column = $value;

            $user->save();

            // Devolver una respuesta
            session()->flash('success', 'Usuario actualizado correctamente.');

        } catch (Exception $e) {
            session()->flash('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar la foto desde el panel de Administración.
     *
     * @param Request $request Foto del usuario
     * @param int $id ID del usuario
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

            $user = User::findOrFail($id);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/profile_photos', $fileName);
                $user->photo = $fileName;
                $user->save();
            }

            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Error al actualizar la foto del usuario: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear nuevo usuario desde el panel de Administración
     *
     * @param Request $request Datos con la información del usuario
     *
     * @return Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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
                $photo->storeAs('public/profile_photos', $filename);
                $validatedData['photo'] = $filename;
            }

            // Hashear la contraseña antes de guardarla
            $validatedData['password'] = Hash::make($validatedData['password']);
            // Crear el usuario
            $user = User::create($validatedData);

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Usuario añadido satisfactoriamente');
            // Redireccionar después de agregar el usuario
            return redirect('admin-panel/users-management')->with('success', 'Usuario añadido satisfactoriamente');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario.');
        }
    }

    /**
     * Eliminar un determinado usuario desde el panel de Administración.
     *
     * @param int $id ID del usuario
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar usuario por su ID
            $user = User::find($id);
            // Si no encontramos ese ID
            if (!$user) {
                session()->flash('error', 'Usuario no encontrado.');
                // return redirect()->route('admin.users-management.index');
                return redirect()->back();
            }
            // Eliminamos el usuario
            $user->delete();

            session()->flash('success', 'Usuario eliminado satisfactoriamente.');
            // return redirect()->route('admin.users-management.index');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el usuario: ' . $e->getMessage());
            // return redirect()->route('admin.users-management.index');
            return redirect()->back();
        }
    }

}
