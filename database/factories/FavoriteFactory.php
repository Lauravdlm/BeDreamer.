<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * El nombre del modelo asociado en el factory.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define el estado por defecto en el factory.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'type' => $this->faker->randomElement(['Restaurante', 'Hotel', 'Actividad']),
            'place_id' => null,
            'restaurant_id' => null,
            'hotel_id' => null,
            'activity_id' => null,
        ];
    }

    /**
     * Indica que el favorito está asociado a un restaurante.
     *
     * @param int $restaurantId ID del restaurante
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forRestaurant($restaurantId)
    {
        return $this->state(function (array $attributes) use ($restaurantId) {
            return [
                'type' => 'Restaurante',
                'restaurant_id' => $restaurantId,
            ];
        });
    }

    /**
     * Indica que el favorito está asociado a un hotel.
     *
     * @param int $hotelId ID del hotel
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forHotel($hotelId)
    {
        return $this->state(function (array $attributes) use ($hotelId) {
            return [
                'type' => 'Hotel',
                'hotel_id' => $hotelId,
            ];
        });
    }

    /**
     * Indica que el favorito está asociado a una actividad.
     *
     * @param int $activityId ID de la actividad
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forActivity($activityId)
    {
        return $this->state(function (array $attributes) use ($activityId) {
            return [
                'type' => 'Actividad',
                'activity_id' => $activityId,
            ];
        });
    }
}

