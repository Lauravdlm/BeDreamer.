<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Clase que representa una reseña.
 * @package App\Controllers
 */
class ReviewController extends Controller
{

    /**
     * Muestra los datos de todos las reseñas en una tabla en el panel de Administración.
     *
     * @param Request $request Solicitud HTTP entrante con los datos de todas las reseñas
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Vista con todos los datos de las reseñas | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function reviewsTable(Request $request): Factory|View|\Illuminate\Foundation\Application|Application|RedirectResponse
    {
        try {

            $request->validate([
                'search' => 'sometimes|min:1',
            ]);

            $searchQuery = $request->input('search');
            // Obtener todas las reseñas con la posibilidad de aplicar filtros
            $reviewsQuery = Review::query();
            // Si hubiese búsqueda
            if ($searchQuery) {
                $reviewsQuery->where('type', 'LIKE', "%$searchQuery%")
                    ->orWhere('content', 'LIKE', "%$searchQuery%")
                    ->orWhere('score', 'LIKE', "%$searchQuery%")
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
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
            $reviewsQuery->orderBy('created_at', 'desc');
            // Paginar los resultados
            $reviews = $reviewsQuery->paginate(5);

            // Obtener todos los usuarios
            $users = User::all();
            // Obtener todas las actividades
            $activities = Activity::all();
            // Obtener todos los hoteles
            $hotels = Hotel::all();
            // Obtener todos los restaurantes
            $restaurants = Restaurant::all();

            // Devolver la vista con los usuarios
            return view('admin.pages.reviews-table', compact('reviews', 'users', 'activities', 'hotels', 'restaurants', 'searchQuery'));
        } catch (Exception $e) {
            session()->flash('error', 'Error al obtener las reseñas: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Almacenar en base de datos una nueva reseña creada de una determinada actividad.
     *
     * @param Request $request Datos de la reseña
     * @param Activity $activity Actividad
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito a la vista de la actividad donde se ha almacenado la reseña | Redirección HTTP en caso de error a la vista de la actividad
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function storeActivity(Request $request, Activity $activity): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'content' => 'required|string',
                'score' => 'required|integer|between:1,5',
            ]);

            // Obtenemos el ID de la Actividad que enviaremos por solicitud
            $requestActivityID = $request->input('entity_id');
            // Obtenemos el ID de la Actividad que hemos recuperado (actual)
            $actualActivityID = $activity->id;
            // dd($requestActivityID . " = ". $actualActivityID);
            // Medida de seguridad para comprobar que el ID de la actividad que enviaremos coincide con el ID del blog actual
            if ($requestActivityID != $actualActivityID) {
                session()->flash('error', 'El ID de la actividad no coincide.');
                return redirect()->back();
            }

            // Crear la reseña
            $review = new Review();
            $review->content = $request->input('content');
            $review->score = $request->input('score');
            $review->user_id = $request->user()->id;
            $review->activity_id = $activity->id;
            $review->type = 'Actividad';
            $review->save();

            // Redireccionar a la página de la actividad con un mensaje de éxito
            session()->flash('success', 'Reseña añadida correctamente');
            return redirect()->route('activity.show', ['id' => $activity->id]);
        } catch (QueryException $ex) {
            session()->flash('error', 'Error al guardar la reseña: ' . $ex->getMessage());
            return redirect()->route('activity.show', ['id' => $activity->id]);
        } catch (Exception $ex) {
            session()->flash('error', 'Ocurrió un error inesperado: ' . $ex->getMessage());
            return redirect()->route('activity.show', ['id' => $activity->id]);
        }
    }

    /**
     * Almacenar en base de datos una nueva reseña creada de un determinado hotel.
     *
     * @param Request $request Datos de la reseña
     * @param Hotel $hotel Hotel
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito a la vista del hotel donde se ha almacenado la reseña | Redirección HTTP en caso de error a la vista del hotel
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function storeHotel(Request $request, Hotel $hotel): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'content' => 'required|string',
                'score' => 'required|integer|between:1,5',
            ]);

            // Obtenemos el ID del hotel que enviaremos por solicitud
            $requestHotelID = $request->input('entity_id');
            // Obtenemos el ID del hotel que hemos recuperado (actual)
            $actualHotelID = $hotel->id;
            // Medida de seguridad para comprobar que el ID del hotel que enviaremos coincide con el ID del blog actual
            if ($requestHotelID != $actualHotelID) {
                session()->flash('error', 'El ID del hotel no coincide.');
                return redirect()->back();
            }

            // Crear la reseña
            $review = new Review();
            $review->content = $request->input('content');
            $review->score = $request->input('score');
            $review->user_id = $request->user()->id;
            $review->hotel_id = $hotel->id;
            $review->type = 'Hotel';
            $review->save();

            // Redireccionar a la página del hotel con un mensaje de éxito
            session()->flash('success', 'Reseña añadida correctamente');
            return redirect()->route('hotel.show', ['id' => $hotel->id]);
        } catch (QueryException $ex) {
            session()->flash('error', 'Error al guardar la reseña: ' . $ex->getMessage());
            return redirect()->route('hotel.show', ['id' => $hotel->id]);
        } catch (Exception $ex) {
            session()->flash('error', 'Ocurrió un error inesperado: ' . $ex->getMessage());
            return redirect()->route('hotel.show', ['id' => $hotel->id]);
        }
    }

    /**
     * Almacenar en base de datos una nueva reseña creada de un determinado restaurante.
     *
     * @param Request $request Datos de la reseña
     * @param Restaurant $restaurant Restaurante
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito a la vista del restaurante donde se ha almacenado la reseña | Redirección HTTP en caso de error a la vista del restaurante
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function storeRestaurant(Request $request, Restaurant $restaurant): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'content' => 'required|string',
                'score' => 'required|integer|between:1,5',
            ]);

             // Obtenemos el ID del restaurante que enviaremos por solicitud
             $requestRestaurantID = $request->input('entity_id');
             // Obtenemos el ID del restaurante que hemos recuperado (actual)
             $actualRestaurantID = $restaurant->id;
             // Medida de seguridad para comprobar que el ID del restaurante que enviaremos coincide con el ID del blog actual
             if ($requestRestaurantID != $actualRestaurantID) {
                 session()->flash('error', 'El ID del restaurante no coincide.');
                 return redirect()->back();
             }

            // Crear la reseña
            $review = new Review();
            $review->content = $request->input('content');
            $review->score = $request->input('score');
            $review->user_id = $request->user()->id;
            $review->restaurant_id = $restaurant->id;
            $review->type = 'Restaurante';
            $review->save();

            // Redireccionar a la página del restaurante con un mensaje de éxito
            session()->flash('success', 'Reseña añadida correctamente');
            return redirect()->route('restaurant.show', ['id' => $restaurant->id]);
        } catch (QueryException $ex) {
            session()->flash('error', 'Error al guardar la reseña: ' . $ex->getMessage());
            return redirect()->route('restaurant.show', ['id' => $restaurant->id]);
        } catch (Exception $ex) {
            session()->flash('error', 'Ocurrió un error inesperado: ' . $ex->getMessage());
            return redirect()->route('restaurant.show', ['id' => $restaurant->id]);
        }
    }

    /**
     * Actualizar una determinada reseña desde el panel de Administración.
     *
     * @param Request $request Celda a actualizar que contiene un determinado valor de la reseña
     * @param int $id ID de la reseña
     *
     * @return void Valor actualizado
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function update(Request $request, int $id): void
    {
        try {

            // Buscar reseña
            $review = Review::findOrFail($id);

            // Actualizar el valor de la columna
            $column = $request->input('column');
            $value = $request->input('value');
            $review->$column = $value;

            //Guardar en base de datos
            $review->save();

            // Devolver una respuesta
            session()->flash('success', 'Reseña actualizado correctamente.');

        } catch (Exception $e) {
            session()->flash('error', 'Ha ocurrido un error al actualizar la reseña: ' . $e->getMessage());
        }

    }

    /**
     * Eliminar una determinada reseña desde el panel de Administración | siendo usuario Administrador drectamente en la página donde se visualizan.
     *
     * @param int $id ID de la reseña
     *
     * @return RedirectResponse Redirección HTTP en caso de éxito u error
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscar reseña por su ID
            $review = Review::find($id);

            // Si no encontramos ese ID
            if (!$review) {
                session()->flash('error', 'Reseña no encontrada.');
                return redirect()->back();

            }
            // Eliminamos reseña
            $review->delete();

            session()->flash('success', 'Reseña eliminada satisfactoriamente.');
            return redirect()->back();

        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar la reseña: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
