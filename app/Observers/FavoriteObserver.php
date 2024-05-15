<?php

namespace App\Observers;

use App\Models\Favorite;

/**
 * Observador para el modelo Favorito.
 *
 * Observador encargado de comprobar si hay ciertos valores en la clase Favorito antes de guardar un favorito en la base de datos.
 * @package App\Observers
 */
class FavoriteObserver
{

    /**
     * Asignar un destino (place_id) a un determinado favorito antes de añadirlo.
     *
     * @param Favorite $favorite Favorito a guardar
     *
     * @return void Asignación del ID del destino
     */
    public function saving(Favorite $favorite): void
    {

        if ($favorite->restaurant_id) {
            $relatedModel = $favorite->restaurant;
            $favorite->place_id = $relatedModel->place_id;
        } elseif ($favorite->hotel_id) {
            $relatedModel = $favorite->hotel;
            $favorite->place_id = $relatedModel->place_id;
        } elseif ($favorite->activity_id) {
            $relatedModel = $favorite->activity;
            $favorite->place_id = $relatedModel->place_id;
        }
    }
}
