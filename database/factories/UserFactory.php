<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * El nombre del modelo de fábrica correspondiente.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition()
    {

         // Obtener el nombre del rol aleatorio entre "Administrador" y "Registrado"
         $roleName = $this->faker->randomElement(['Administrador', 'Registrado']);

         // Obtener el ID del rol según el nombre
         $roleId = Role::firstOrCreate(['name' => $roleName])->id;

        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->safeEmail,
            'password' => Hash::make('password'),
            'photo' => null,
            'instagram' => $this->faker->userName,
            'webpage' => $this->faker->url,
            'role_id' => $roleId,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
