<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Clase que se encarga de gestionar la visualización de mapas en la página.
 * @package App\Controllers
 */
class MapController extends Controller
{

    /**
     * Mostrar una determinada longitud y latitud en formato JSON
     *
     * @param float $latitude latitud
     * @param float $longitude longitud
     *
     * @return JsonResponse|void JSON de la longitud y latitud
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function show(float $latitude, float $longitude)
    {
        try {
            return response()->json([
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

        } catch (\Exception $e) {
            // Manejar la excepción
            session()->flash('error', 'Error al obtener la longitud y/o latitud: ' . $e->getMessage());
        }
    }

}
