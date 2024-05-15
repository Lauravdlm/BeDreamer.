<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['name' => 'Almería', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Granada', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Barcelona', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarragona', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Madrid', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Toledo', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oviedo', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Segovia', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Murcia', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenca', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'París', 'country_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Roma', 'country_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Múnich', 'country_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
