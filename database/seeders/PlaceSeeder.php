<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('places')->insert([
            [
                'name' => 'Almería',
                'description' => 'Almería es el centro neurálgico de la Comarca Metropolitana de Almería, en el extremo sureste de la península ibérica y de la comarca turística de Almería-Cabo de Gata-Níjar.',
                'photo' => 'almeria.jpg',
                'latitude' => 36.834,
                'longitude' => -2.4637,
                'city_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Granada',
                'description' => 'Granada es el vivo reflejo del esplendor de la etapa nazarí, presente en muchos de sus y en su joya arquitectónica por excelencia: La Alhambra. Considerada por muchos como la octava maravilla del mundo, este complejo palaciego atrae cada año a millones de turistas de todo el mundo.',
                'photo' => 'granada.jpg',
                'latitude' => 37.1773,
                'longitude' => -3.5986,
                'city_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barcelona',
                'description' => 'Barcelona es una ciudad llena de originales opciones de ocio que animan a visitarla una y otra vez. Abierta al mar Mediterráneo y afamada por Gaudí y su arquitectura modernista, Barcelona se revela como una de las capitales europeas más trendy.',
                'photo' => 'barcelona.jpg',
                'latitude' => 41.3851,
                'longitude' => 2.1734,
                'city_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tarragona',
                'description' => 'En Tarragona la historia sale de las piedras, de los libros y cobra vida. La ciudad ha ido especializándose en actividades de reconstrucción histórica.',
                'photo' => 'tgn.jpg',
                'latitude' => 41.11667,
                'longitude' => 1.25,
                'city_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Madrid',
                'description' => 'Situada en el corazón de España, Madrid es la vibrante capital que combina a la perfección su rica historia con la modernidad de una metrópolis cosmopolita.',
                'photo' => 'madrid.jpg',
                'latitude' => 40.4165,
                'longitude' => -3.70256,
                'city_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toledo',
                'description' => 'Convertida, durante siglos, en ciudad de leyenda, dormida en el sueño de una historia que le hizo ser un día capital de Europa y centro indiscutible de la vida española, Toledo es hoy una ciudad en expansión, moderna capital administrativa de Castilla-La Mancha.',
                'photo' => 'toledo.jpg',
                'latitude' => 39.8581,
                'longitude' => -4.02263,
                'city_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oviedo',
                'description' => 'Oviedo está en el corazón de Asturias, en pleno centro, y su capital es la del Principado. Es el segundo municipio más poblado de Asturias, y es uno de los puntos clave del área metropolitana de la región....',
                'photo' => 'oviedo.jpg',
                'latitude' => 43.36029,
                'longitude' => -5.84476,
                'city_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Segovia',
                'description' => 'Segovia es una ciudad española, capital de la provincia de su nombre, integrada en la Comunidad Autónoma de Castilla y León. Se halla situada en el interior de la Península Ibérica, próxima a Valladolid, la capital autonómica, y a Madrid, la capital estatal.',
                'photo' => 'segovia.jpg',
                'latitude' => 40.94808,
                'longitude' => -4.11839,
                'city_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lorca',
                'description' => 'Lorca es conocida como la ciudad barroca por el importante legado barroco de su centro histórico, declarado conjunto histórico-artístico en 1964.',
                'photo' => 'lorca.jpg',
                'latitude' => 37.67119,
                'longitude' => -1.7017,
                'city_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cuenca',
                'description' => 'Cuenca es ciudad para reposar, no de visita apresurada. Una ciudad para ver por dentro, paseando sus calles, entrando en sus rincones monumentales ; y contemplar desde fuera, desde el otro lado del Júcar; para ver bañada por el sol o iluminada por la noche...',
                'photo' => 'cuenca.jpg',
                'latitude' => 40.06667,
                'longitude' => -2.13333,
                'city_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chartres',
                'description' => 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira.',
                'photo' => 'chartres.jpg',
                'latitude' => 48.44685,
                'longitude' => 1.48925,
                'city_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arpino',
                'description' => 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón.',
                'photo' => 'arpino.jpg',
                'latitude' => 40.8927,
                'longitude' => 14.3234,
                'city_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Füssen',
                'description' => 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes.',
                'photo' => 'füssen.jpg',
                'latitude' => 47.57143,
                'longitude' => 10.70171,
                'city_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
