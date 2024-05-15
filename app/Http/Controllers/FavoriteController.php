<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Place;
use App\Models\Restaurant;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Clase que representa un favorito.
 * @package App\Controllers
 */
class FavoriteController extends Controller
{
    /**
     * Mostrar una lista de favoritos de un determinado usuario.
     *
     * @param Request $request Información de los favoritos
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     *
     * @throws Exception Por si ocurre algún error durante la ejecución Vista con los datos de los favoritos de un determinado usuario | Redirección HTTP en caso de un registro fallido
     */
    public function index(Request $request): Factory | View | \Illuminate\Foundation\Application  | Application | RedirectResponse
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario está autenticado antes de continuar
        if (!$user) {
            // El usuario no está autenticado, redirigir al home
            return redirect()->route('home');
        }

        // Obtener todos los favoritos del usuario
        $favorites = Favorite::where('user_id', $user->id)->get();
        // Agrupar favoritos por destino
        $favoritesByPlace = $favorites->groupBy('place_id');

        return view('users.users_favorites', compact('favorites', 'favoritesByPlace'));
    }

    /**
     * Obtener todos los favoritos en el panel de Administración.
     *
     * @param Request $request Favoritos a obtener (con posibles filtros aplicados)
     *
     * @return Factory|\Illuminate\Foundation\Application|View|Application|RedirectResponse Vista de la tabla de favoritos | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function favoritesTable(Request $request): Factory | \Illuminate\Foundation\Application  | View | Application | RedirectResponse
    {
        try {
            $request->validate([
                'search' => 'sometimes|min:1',
            ]);
            $searchQuery = $request->input('search');

            // Obtener todos los favoritos con la posibilidad de aplicar filtros
            $favoritesQuery = Favorite::query();
            if ($searchQuery) {
                $favoritesQuery->where('type', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('place', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('restaurant', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('hotel', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('activity', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    });
            }

            // Ordenar por fecha de creación
            $favoritesQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $favorites = $favoritesQuery->paginate(5);

            // Obtener todos los usuarios
            $users = User::all();
            // Obtener todas las actividades
            $activities = Activity::all();
            // Obtener todos los hoteles
            $hotels = Hotel::all();
            // Obtener todos los restaurantes
            $restaurants = Restaurant::all();
            // Obtener todos los destinos
            $places = Place::all();

            // Devolver la vista
            return view('admin.pages.favorites-table', compact('favorites', 'users', 'activities', 'hotels', 'restaurants', 'places', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener los favoritos: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Almacenar en base de datos un nuevo favorito creado desde el panel de favoritos de un determinado usuario.
     *
     * @param Request $request Datos del favorito
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito al panel de favoritos donde se ha creado el favorito | Redirección HTTP en caso de error a la vista del panel de favoritos de un determinado usuario
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'], // Solo letras
                'place_id' => 'required',
                'restaurant_id' => 'nullable|required_if:type,Restaurante',
                'hotel_id' => 'nullable|required_if:type,Hotel',
                'activity_id' => 'nullable|required_if:type,Actividad',
            ]);

            // Verificar si ya existe un favorito con las mismas características
            $existingFavorite = Favorite::where([
                'type' => $request->type,
                'user_id' => auth()->user()->id,
                'place_id' => $request->place_id,
            ])->first();

            if ($existingFavorite) {
                session()->flash('error', 'Este favorito ya ha sido añadido.');
                return redirect()->route('user.favorites');
            }

            Favorite::create([
                'type' => $request->type,
                'user_id' => auth()->user()->id,
                'place_id' => $request->place_id,
                'restaurant_id' => $request->restaurant_id,
                'hotel_id' => $request->hotel_id,
                'activity_id' => $request->activity_id,
            ]);

            session()->flash('success', 'Favorito agregado satisfactoriamente.');
            return redirect()->route('user.favorites');
        } catch (Exception $e) {
            session()->flash('error', 'Error al agregar el favorito: ' . $e->getMessage());
            return redirect()->route('user.favorites');
        }
    }

    /**
     * Eliminar un determinado comentario desde el panel de favoritos de un determinado usuario.
     *
     * @param int $id ID del favorito
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            //Buscar favorito por su ID
            $favorite = Favorite::find($id);
            // Obtener el ID del usuario autenticado
            $user = auth()->user()->id;
            // Obtener el ID del usuario asociado a ese favorito
            $userFavID = $favorite->user_id;
            // dd($user . " = ". $userFavID);

            // Medida de seguridad para comprobar que el usuario autenticado es el usuario asociado a ese favorito antes de eliminarlo
            if ($user != $userFavID) {
                session()->flash('error', 'Este usuario no coincide con el usuario asociado.');
                Log::error("Este usuario no coincide con el usuario asociado.");
                return redirect()->back();
            }

            // Si no encontramos el ID del favorito
            if (!$favorite) {
                session()->flash('error', 'Favorito no encontrado.');
                return redirect()->back();
            }
            // Eliminamos dicho favorito
            $favorite->delete();

            session()->flash('success', 'Favorito eliminado satisfactoriamente.');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar el favorito');
            Log::error('Error al eliminar el favorito: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Añadir una determinada actividad a favoritos de un determinado usuario
     *
     * @param Request $request Datos del usuario autenticado
     * @param Activity $activity Datos de la actividad
     *
     * @return RedirectResponse|void En caso de éxito el favorito va a ser creado con la información de la actividad y añadido a la lista de favoritos de un usuario | Redirección HTTP en caso de error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function addActivity(Request $request, Activity $activity)
    {

        try {
            // Obtener el usuario asociado
            $user = $request->user();
            // Verifica si la actividad ya está en favoritos del usuario
            $isFavorite = $user->favorites()->where('activity_id', $activity->id)->exists();

            if ($isFavorite) {
                // Si la actividad ya está en favoritos, elimínala
                // $user->favorites()->where('activity_id', $activity->id)->delete();
                // session()->flash('success', 'Favorito eliminado satisfactoriamente.');
                $user->favorites()->where('activity_id', $activity->id)->delete();
                session()->flash('success', 'Favorito eliminado satisfactoriamente.');
                // Error, redirección
                // session()->flash('error', 'Favorito ya agregado.');
                // redirect()->back();
            } else {
                // Si la actividad no está en favoritos se creará
                $user->favorites()->create([
                    'type' => 'Actividad',
                    'activity_id' => $activity->id,
                    'place_id' => $activity->place_id,
                ]);
                session()->flash('success', 'Favorito agregado satisfactoriamente.');
            }

            // Redirige de vuelta a la página anterior
            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Error al añadir el favorito: ' . $e->getMessage());
        }
    }

    /**
     * Añadir un determinado restaurante a favoritos de un determinado usuario
     *
     * @param Request $request Datos del usuario autenticado
     * @param Restaurant $restaurant Datos del restaurante
     *
     * @return RedirectResponse|void En caso de éxito el favorito va a ser creado con la información del restaurante y añadido a la lista de favoritos de un usuario | Redirección HTTP en caso de error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function addRestaurant(Request $request, Restaurant $restaurant)
    {
        try {
            $user = $request->user();

            // Verifica si el restaurante ya está en favoritos del usuario
            $isFavorite = $user->favorites()->where('restaurant_id', $restaurant->id)->exists();

            if ($isFavorite) {
                $user->favorites()->where('restaurant_id', $restaurant->id)->delete();
                session()->flash('success', 'Favorito eliminado satisfactoriamente.');
                // session()->flash('error', 'Favorito ya agregado.');
                // redirect()->back();
            } else {
                $user->favorites()->create([
                    'type' => 'Restaurante',
                    'restaurant_id' => $restaurant->id,
                    'place_id' => $restaurant->place_id,
                ]);
                session()->flash('success', 'Favorito agregado satisfactoriamente.');
            }

            // Redirige de vuelta a la página anterior
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al añadir el favorito: ' . $e->getMessage());
        }
    }

    /**
     * Añadir un determinado hotel a favoritos de un determinado usuario
     *
     * @param Request $request Datos del usuario autenticado
     * @param Hotel $hotel Datos del hotel
     *
     * @return RedirectResponse|void En caso de éxito el favorito va a ser creado con la información del hotel y añadido a la lista de favoritos de un usuario | Redirección HTTP en caso de error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function addHotel(Request $request, Hotel $hotel)
    {
        try {
            $user = $request->user();

            // Verifica si la actividad ya está en favoritos del usuario
            $isFavorite = $user->favorites()->where('hotel_id', $hotel->id)->exists();

            if ($isFavorite) {
                // session()->flash('error', 'Favorito ya agregado.');
                // redirect()->back();
                $user->favorites()->where('hotel_id', $hotel->id)->delete();
                session()->flash('success', 'Favorito eliminado satisfactoriamente.');
            } else {
                $user->favorites()->create([
                    'type' => 'Hotel',
                    'hotel_id' => $hotel->id,
                    'place_id' => $hotel->place_id,
                ]);
                session()->flash('success', 'Favorito agregado satisfactoriamente.');
            }

            // Redirige de vuelta a la página anterior
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al agregar el favorito: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un determinado favorito desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor del favorito
     * @param int $id ID del favorito
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {
            // Buscar favorito
            $favorite = Favorite::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $favorite->$column = $value;

            //Guardar en base de datos
            $favorite->save();

            // Devolver una respuesta
            session()->flash('success', 'Favorito actualizado correctamente.');

        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Ha ocurrido un error al actualizar favorito: ' . $e->getMessage());

        }
    }

    /**
     * Eliminar un determinado favorito desde el panel de Administración.
     *
     * @param int $id ID del favorito
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            // Buscar favorito por su ID
            $favorite = Favorite::find($id);
            // Si no encontramos ese ID
            if (!$favorite) {
                session()->flash('error', 'Favorito no encontrada.');
                // return redirect()->route('admin.favorites-management.index');
                return redirect()->back();
            }
            // Eliminamos favoritos
            $favorite->delete();

            session()->flash('success', 'Favorito eliminada satisfactoriamente.');
            // return redirect()->route('admin.favorites-management.index');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar favorito: ' . $e->getMessage());
            // return redirect()->route('admin.favorites-management.index');
            return redirect()->back();
        }
    }

}
