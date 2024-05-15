<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * El nombre del modelo asociado en el factory.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define el estado por defecto en el factory.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'type' => $this->faker->randomElement(['Activity', 'Restaurant', 'Hotel']),
            'content' => $this->faker->paragraph,
            'score' => $this->faker->numberBetween(1, 5),
            'activity_id' => null,
            'restaurant_id' => null,
            'hotel_id' => null,
        ];
    }

    /**
     * Indica que la reseña está asociada a una actividad.
     *
     * @param int $activityId ID de la actividad
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forActivity($activityId)
    {
        return $this->state(function (array $attributes) use ($activityId) {
            return [
                'type' => 'Activity',
                'activity_id' => $activityId,
            ];
        });
    }

    /**
     * Indica que la reseña está asociada a un restaurante.
     *
     * @param int $restaurantId ID del restaurante
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forRestaurant($restaurantId)
    {
        return $this->state(function (array $attributes) use ($restaurantId) {
            return [
                'type' => 'Restaurant',
                'restaurant_id' => $restaurantId,
            ];
        });
    }

    /**
     * Indica que la reseña está asociada a un hotel.
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
}
