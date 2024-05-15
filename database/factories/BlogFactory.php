<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * El nombre del modelo asociado en el factory
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define el estado por defecto en el factory
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'photo' => $this->faker->imageUrl(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'place_id' => function () {
                return Place::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
