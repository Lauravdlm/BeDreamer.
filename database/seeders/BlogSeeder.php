<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'title' => 'Mi viaje a Almería',
                'content' => 'Hoy quiero compartir mi experiencia...',
                'photo' => 'guia_almeria.jpg',
                'user_id' => 2,
                'place_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Descubriendo Granada',
                'content' => 'Granada es una ciudad llena de historia...',
                'photo' => 'guia_gr.jpg',
                'user_id' => 3,
                'place_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'De paseo en Segovia',
                'content' => 'Que bonita Segovia y que bonita su gente...',
                'photo' => 'guia_segovia.jpg',
                'user_id' => 4,
                'place_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Turisteando por Madrid',
                'content' => 'Qué decir de Madrid, capital de...',
                'photo' => 'guia_madrid.jpg',
                'user_id' => 5,
                'place_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Aventuras en Barcelona',
                'content' => 'Barcelona nunca duerme y yo tampoco...',
                'photo' => 'guia_bcn.jpg',
                'user_id' => 6,
                'place_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Descubriendo Chartres',
                'content' => 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira. Descubre su fascinante historia y arquitectura gótica.',
                'photo' => 'guia_chartres.jpg',
                'user_id' => 1,
                'place_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Explorando Arpino',
                'content' => 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón. Descubre los encantos de esta pintoresca localidad italiana.',
                'photo' => 'guia_arpino.jpg',
                'user_id' => 1,
                'place_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Aventuras en Füssen',
                'content' => 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes. Sumérgete en la belleza natural y la rica historia de esta encantadora ciudad alemana.',
                'photo' => 'guia_füssen.jpg',
                'user_id' => 2,
                'place_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
