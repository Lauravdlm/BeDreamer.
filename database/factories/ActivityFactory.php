<?php
namespace Database\Factories;

use App\Models\Activity;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * El nombre del modelo asociado en el factory
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define el estado por defecto en el factory
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['Turismo', 'Monumento', 'Cultural', 'Naturaleza']),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'photo' => $this->faker->imageUrl(),
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'place_id' => function () {
                return Place::factory()->create()->id;
            },
        ];
    }
}
