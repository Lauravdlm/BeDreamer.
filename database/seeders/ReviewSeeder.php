<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id' => 1,
                'type' => 'Actividad',
                'content' => 'Una experiencia increíble, la Alcazaba de Almería es impresionante y la guía turística fue muy informativa.',
                'score' => 4.5,
                'activity_id' => 1,
                'restaurant_id' => null,
                'hotel_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'type' => 'Actividad',
                'content' => 'La visita a la Alhambra fue lo más destacado de nuestro viaje. La arquitectura y los jardines son simplemente asombrosos.',
                'score' => 5.0,
                'activity_id' => 2,
                'restaurant_id' => null,
                'hotel_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'type' => 'Restaurante',
                'content' => 'La comida en La Mala fue deliciosa, especialmente las tapas. El ambiente era acogedor y el servicio excelente.',
                'score' => 4.0,
                'activity_id' => null,
                'restaurant_id' => 1,
                'hotel_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'type' => 'Restaurante',
                'content' => 'Divino Ristorante Italiano superó nuestras expectativas. La pasta era auténtica y deliciosa, y el personal era muy amable.',
                'score' => 4.5,
                'activity_id' => null,
                'restaurant_id' => 2,
                'hotel_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'type' => 'Hotel',
                'content' => 'El AC Hotel Almería by Marriott fue una excelente elección. La habitación era cómoda y limpia, y el personal era muy servicial.',
                'score' => 4.0,
                'activity_id' => null,
                'restaurant_id' => null,
                'hotel_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'type' => 'Hotel',
                'content' => 'Nos encantó nuestra estancia en NH Collection Granada Victoria. La ubicación era perfecta y las instalaciones eran de primera clase.',
                'score' => 4.5,
                'activity_id' => null,
                'restaurant_id' => null,
                'hotel_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
