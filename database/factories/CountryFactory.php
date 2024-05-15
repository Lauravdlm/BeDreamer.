<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * El nombre del modelo en el factory correspondiente.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
