<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Usuario',
                'surname' => 'Administrador',
                'username' => 'admin_user',
                'email' => 'admin_user@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 5,
                'role_id' => 1, // Administrador
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'name' => 'Usuario',
                'surname' => 'Registrado',
                'username' => 'basic_user',
                'email' => 'basic_user@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 9,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laura',
                'surname' => 'Valera de los Mozos',
                'username' => 'laura_valera',
                'email' => 'laura_valera@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 1,
                'role_id' => 1, // Administrador
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maria Teresa',
                'surname' => 'de los Mozos Pi',
                'username' => 'maitepi',
                'email' => 'maitepi@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 2,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Raquel',
                'surname' => 'Ortiz López',
                'username' => 'raquelortiz',
                'email' => 'raquel@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 3,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Raquel',
                'surname' => 'Martínez Cortés',
                'username' => 'raquelmartinez',
                'email' => 'raquel2@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 4,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manuel',
                'surname' => 'Valera Llamas',
                'username' => 'mavalla',
                'email' => 'manuel@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 5,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eusebio',
                'surname' => 'Sánchez Rubio',
                'username' => 'euse_rt',
                'email' => 'euse_rt@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 6,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Valentina',
                'surname' => 'Mora Valera',
                'username' => 'mora_valen',
                'email' => 'valen@example.com',
                'password' => Hash::make('password123'),
                'city_id' => 7,
                'role_id' => 2, // Registrado
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
