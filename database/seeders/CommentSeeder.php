<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            [
                'content' => '¡Qué emocionante viaje! Me encantaría visitar Almería algún día.',
                'user_id' => 1,
                'blog_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Gracias por compartir tu experiencia. ¡La foto se ve increíble!',
                'user_id' => 2,
                'blog_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Granada es una ciudad hermosa. ¡Espero poder visitarla pronto!',
                'user_id' => 3,
                'blog_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Me encantó tu artículo. Granada tiene tanto que ofrecer.',
                'user_id' => 4,
                'blog_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Segovia es una joya escondida. ¡Gracias por compartir tus aventuras!',
                'user_id' => 5,
                'blog_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Tu experiencia en Segovia suena maravillosa. ¡Definitivamente tengo que ir!',
                'user_id' => 6,
                'blog_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Madrid es una ciudad increíble. ¿Cuál fue tu parte favorita del viaje?',
                'user_id' => 7,
                'blog_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Qué genial leer sobre tus aventuras en Madrid. ¡Espero visitar pronto!',
                'user_id' => 8,
                'blog_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Barcelona es una ciudad vibrante. ¡Gracias por compartir tus experiencias!',
                'user_id' => 9,
                'blog_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => '¡Tu artículo sobre Barcelona me hace querer empacar y salir de inmediato!',
                'user_id' => 9,
                'blog_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Prueba de comentario para el blog de Francia.',
                'user_id' => 7,
                'blog_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => '¡Excelente artículo sobre Francia! ¡Me encantaría leer más sobre tus viajes!',
                'user_id' => 1,
                'blog_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Prueba de comentario para el blog de Italia.',
                'user_id' => 2,
                'blog_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'content' => 'Gracias por compartir tus aventuras en Italia. ¡Espero leer más de tus viajes!',
                'user_id' => 4,
                'blog_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
