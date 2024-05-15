<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    /**
     * El nombre del modelo asociado en el factory.
     *
     * @var string
     */
    protected $model = Place::class;

    /**
     * Define el estado por defecto en el factory.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'description' => $this->faker->sentence,
            'photo' => $this->faker->imageUrl(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'city_id' => function () {
                return City::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
