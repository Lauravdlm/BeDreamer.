<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Hotel;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('favorites')->insert([
            [
                'type' => 'Restaurante',
                'user_id' => 5,
                'restaurant_id' => 7,
                'hotel_id' => null,
                'activity_id' => null,
                'place_id' => Restaurant::find(7)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Restaurante',
                'user_id' => 2,
                'restaurant_id' => 2,
                'hotel_id' => null,
                'activity_id' => null,
                'place_id' => Restaurant::find(2)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Actividad',
                'user_id' => 3,
                'restaurant_id' => null,
                'hotel_id' => null,
                'activity_id' => 6,
                'place_id' => Activity::find(6)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Actividad',
                'user_id' => 4,
                'restaurant_id' => null,
                'hotel_id' => null,
                'activity_id' => 1,
                'place_id' => Activity::find(1)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Hotel',
                'user_id' => 7,
                'restaurant_id' => null,
                'hotel_id' => 3,
                'activity_id' => null,
                'place_id' => Hotel::find(3)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Hotel',
                'user_id' => 6,
                'restaurant_id' => null,
                'hotel_id' => 9,
                'activity_id' => null,
                'place_id' => Hotel::find(9)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Restaurante',
                'user_id' => 3,
                'restaurant_id' => 1,
                'hotel_id' => null,
                'activity_id' => null,
                'place_id' => Restaurant::find(1)->place_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
