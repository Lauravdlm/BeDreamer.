<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Clase que representa un usuario autenticado.
 * @package App\Controllers
 */
class AuthController extends Controller
{
    /**
     * Constructor que aplica el middleware de autenticación a todos los métodos del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    /**
     * Obtener la vista del panel de usuario autenticado.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Vista que contiene el panel del usuario con los datos del usuario
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function index(): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        try {
            // Obtener el usuario autenticado
            $user = auth()->user();

            // Obtener los blogs asociados a este usuario
            $blogs = $user->blogs;

            // Pasar los blogs a la vista
            return view('users.users_panel', ['blogs' => $blogs]);
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Maneja la autenticación del usuario y devuelve un token de autenticación en caso de éxito.
     *
     * @param Request $request Solicitud HTTP entrante con los datos del formulario de inicio sesión
     *
     * @return JsonResponse|RedirectResponse Token de autenticación en formato json | Redirección en caso de fallo en la autenticación
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function login(Request $request): JsonResponse | RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Verificar si la validación falla
            if ($validator->fails()) {
                // Almacenar el mensaje de error en la sesión
                session()->flash('error', 'Error validación de datos');
                // Redireccionar de vuelta al formulario de inicio de sesión
                return redirect()->route('home');
            }

            // Intentar autenticar al usuario
            if (Auth::attempt($validator->validated())) {
                // Si la autenticación es exitosa, generar y devolver el token de autenticación
                // $user = Auth::user();
                $token = $request->user()->createToken('token')->plainTextToken;

                // Registra un mensaje en el archivo de registro
                // Log::info('Se recibieron datos de inicio de sesión: ' . json_encode($request->all()));
                // Almacenamos en la sesión un mensaje de éxito
                session()->flash('success', 'Has iniciado sesión con éxito.');
                // dd(session()->all());
                return response()->json(['token' => $token]);
            } else {
                // Si la autenticación falla, almacenar el mensaje de error en la sesión
                session()->flash('error', 'Credenciales incorrectas. Por favor, inténtelo de nuevo.');
                // Redireccionar de vuelta al formulario de inicio de sesión
                return redirect()->route('home');
            }

        } catch (Exception $e) {
            session()->flash('error', 'Error al iniciar sesión: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Obtener los datos del usuario autenticado.
     *
     * @param Request $request Solicitud HTTP entrante con el usuario que ha iniciado sesión
     *
     * @return JsonResponse|RedirectResponse Datos del usuario en formato JSON en caso de una autenticación satisfactoria | Redirección HTTP en caso de una autenticación fallida
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function getUserData(Request $request): JsonResponse | RedirectResponse
    {
        try {
            // Obtener el usuario autenticado
            $user = $request->user();

            // Verificar si el usuario tiene una foto
            if ($user->photo) {
                // Obtener la URL completa de la foto utilizando el método definido en el modelo User
                $photo = $user->getPhotoUrlAttribute();
            } else {
                // Si el usuario no tiene una foto, asignamos una foto predeterminada
                $photo = asset('storage/profile_photos/no-avatar.png');
            }

            // Datos del usuario en formato JSON
            return response()->json([
                'name' => $user->name,
                'surname' => $user->surname,
                'photo' => $photo,
                'username' => $user->username,
                'email' => $user->email,
                'instagram' => $user->instagram,
                'webpage' => $user->webpage,
                'city_id' => $user->city_id,
                'role_id' => $user->role_id,
            ]);

            // return $request->user();
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los datos del usuario: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Crear un nuevo usuario.
     *
     * @param Request $request Solicitud HTTP entrante con los datos del nuevo usuario
     *
     * @return JsonResponse|RedirectResponse Datos del usuario en formato JSON en caso de un registro satisfactorio | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function register(Request $request): JsonResponse | RedirectResponse
    {
        try {
            // Validar los datos del formulario usando la clase Validator de Laravel
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:50',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:5',
            ]);

            // Verificar si la validación falla
            if ($validator->fails()) {
                // Almacenamos un mensje de error
                session()->flash('error', 'Credenciales incorrectas.');
                // return response()->json(['error' => $validator->errors()->first()], 422);
                return redirect()->back();
            }

            // Verificar si la contraseña está presente
            if (empty($request->password)) {
                session()->flash('error', 'La contraseña es obligatoria.');
                // return response()->json(['error' => 'La contraseña es obligatoria.'], 422);
                return redirect()->back();
            }

            // Agregar logs de depuración
            // Log::info('Datos de registro: ' . json_encode($request->all()));

            // Crear un nuevo usuario en la base de datos
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Utilizar Hash::make para cifrar la contraseña
                'role_id' => 2, // Rol de registrado
            ]);

            // Generar y devolver el token de autenticación
            $token = $user->createToken('token')->plainTextToken;

            session()->flash('success', 'Usuario creado con éxito.');
            return response()->json(['token' => $token], 201);
        } catch (Exception $e) {
            session()->flash('error', 'Error al crear al usuario: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Cerrar sesión.
     *
     * @param  Request $request Solicitud HTTP entrante con los datos del usuario
     *
     * @return RedirectResponse Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function logout(Request $request)
    {
        try {
            // Verificar si el usuario está autenticado
            if ($request->user()) {
                // Eliminar el token de autenticación del usuario actual
                $request->user()->tokens()->delete();
                // Eliminar los datos de sesión
                Session::flush();
                session()->flash('success', 'Sesión cerrada correctamente.');
                // Redirigir al usuario al home
                return redirect()->back();
            } else {
                session()->flash('error', 'Usuario no está autenticado.');
                return redirect()->back();
            }

        } catch (Exception $e) {
            session()->flash('error', 'Error al cerrar sesión: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Actualiza los datos del usuario autenticado desde el propio panel de usuario.
     *
     * @param  Request $request Solicitud HTTP entrante con la información del usuario a actualizar en base de datos
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            // Obtener el usuario autenticado
            $user = User::find(auth()->id());
            // Verificar si el usuario existe
            if (!$user) {
                // return redirect()->route('login')->with('error', 'Usuario no autenticado');
                session()->flash('error', 'Usuario no autenticado');
                return redirect()->back();
            }

            // Validar los datos del formulario
            $request->validate([
                'name' => ['sometimes', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
                'surname' => ['sometimes', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
                'email' => ['sometimes', 'string', 'email', 'max:50', 'unique:users', 'regex:/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i'],
                'city_id' => 'sometimes|integer|exists:cities,id',
                'instagram' => 'sometimes|string|max:50',
                'webpage' => 'sometimes|string|max:100',
                'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Actualizar cada campo si se proporciona en el formulario
            if ($request->filled('name')) {
                $user->name = $request->input('name');
            }
            if ($request->filled('surname')) {
                $user->surname = $request->input('surname');
            }
            if ($request->filled('email')) {
                $user->email = $request->input('email');
            }
            if ($request->filled('instagram')) {
                $user->instagram = $request->input('instagram');
            }
            if ($request->filled('webpage')) {
                $user->webpage = $request->input('webpage');
            }

            // Actualizar la ciudad si se proporciona en el formulario
            if ($request->filled('city_name')) {
                // Buscar la ciudad por su nombre
                $city = City::where('name', $request->input('city_name'))->first();
                // Verificar si la ciudad existe
                if (!$city) {
                    // Si la ciudad no existe
                    return redirect()->back()->with('error', 'La ciudad proporcionada no existe');
                }
                // Actualizar el ID de la ciudad del usuario
                $user->city_id = $city->id;
            }

            // Actualizar la foto de perfil si se proporciona en el formulario
            if ($request->hasFile('photo')) {
                // Eliminar la foto anterior si existe
                if ($user->photo) {
                    Storage::delete('profile_photos/' . $user->photo);
                }
                // Subir la nueva foto
                // $photoName = Storage::putFile('profile_photos', $request->file('photo'));
                $photoName = time() . '_' . $request->file('photo')->getClientOriginalName(); // creamos el nombre de la foto
                $request->file('photo')->storeAs('public/profile_photos', $photoName); // lo almacenamos
                // Guardar el nombre de la foto en la base de datos
                $user->photo = $photoName;
            }

            // Actualizar la contraseña si se proporciona en el formulario
            if ($request->filled('old_password') && $request->filled('new_password') && $request->filled('confirm_new_password')) {
                // Verificar y validar la contraseña solo si los campos relacionados están presentes
                $request->validate([
                    'new_password' => 'sometimes|string|min:8',
                    'confirm_new_password' => 'sometimes|string|same:new_password',
                ]);

                // Verificar que la contraseña actual sea correcta quitandole el hash y comparandola con la recibida
                if (!Hash::check($request->input('old_password'), $user->password)) {
                    return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
                }

                // Verificar si la nueva contraseña y su confirmación coinciden
                if ($request->input('new_password') !== $request->input('confirm_new_password')) {
                    return redirect()->back()->with('error', 'La confirmación de la nueva contraseña no coincide');
                }

                // Actualizar la contraseña del usuario
                $user->password = Hash::make($request->input('new_password'));
            }

            // Guardar los cambios en la base de datos
            $user->save();

            session()->flash('success', '¡Datos actualizados correctamente!');
            // session()->save();
            // dd(session()->all());

            // Redirigir al usuario a su panel de usuario
            return redirect()->back();
            // return redirect()->route('user.panel')->with('success', '¡Datos actualizados correctamente!');

        } catch (Exception $e) {
            session()->flash('error', 'Error al actualizar los datos del usuario: ' . $e->getMessage());
            return redirect()->back();
        }
    }

}
