<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name' => 'España',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Francia',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Italia',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Alemania',
                'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
