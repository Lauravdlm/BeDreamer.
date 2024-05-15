<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Blog;
use App\Models\Hotel;
use App\Models\Place;
use App\Models\Restaurant;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Clase que se encarga de manejar todas las operaciones de la página de inicio.
 * @author Laura Valera de los Mozos
 * @package App\Controllers
 */
class HomeController extends Controller
{
    /**
     * Obtener la vista principal del proyecto con los datos necesarios
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application Vista inicio
     */
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $places = Place::latest()->take(10)->get(); // Últimos 10 destinos almacenados en base de datos
        $blogs = Blog::latest()->take(10)->get(); // Últimos 10 blogs almacenados en base de datos

        return view('pages.index', compact('places', 'blogs'));
    }

    /**
     * Obtener la vista de la página a la que redirigen los links del footer
     *
     * @return mixed Vista página en construcción
     */
    public function loadingPage(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view('partials.coming-soon-page');
    }

    /**
     * Mostrar una lista de destinos, hoteles, actividades o restaurantes a través de un buscador dinámico en el header
     *
     * @param Request $request Valor del input
     *
     * @return JsonResponse JSON con datos que coincidan con el valor del input entrante | JSON con el error en caso de ocurrir
     *
     */
    public function search(Request $request): JsonResponse
    {

        // Valor de input que nos llega
        $query = $request->input('query');
        // Array donde almacenaremos los resultados
        $searchResults = [];

        // Intentar realizar la búsqueda
        try {
            // Cuando hayamos escrito más de tres caracteres buscaremos en dichas tablas si hay valores que coinciden con el valor del input
            if (strlen($query) >= 3) {
                $places = Place::where('name', 'like', "%$query%")->pluck('name', 'id')->map(function ($name, $id) {
                    return ['name' => $name, 'id' => 'place-' . $id];
                });
                $activities = Activity::where('name', 'like', "%$query%")->pluck('name', 'id')->map(function ($name, $id) {
                    return ['name' => $name, 'id' => 'activity-' . $id];
                });
                $hotels = Hotel::where('name', 'like', "%$query%")->pluck('name', 'id')->map(function ($name, $id) {
                    return ['name' => $name, 'id' => 'hotel-' . $id];
                });
                $restaurants = Restaurant::where('name', 'like', "%$query%")->pluck('name', 'id')->map(function ($name, $id) {
                    return ['name' => $name, 'id' => 'restaurant-' . $id];
                });

                // Unir los resultados y añadirlos al array con nombre e ID
                $searchResults = $places->merge($activities)->merge($hotels)->merge($restaurants)->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name']
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Se produjo un error al realizar la búsqueda: ' . $e->getMessage()], 500);
        }

        // Devolver el resultado en formato JSON
        return response()->json($searchResults);
    }

}
