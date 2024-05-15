<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurants')->insert([
            [
                'name' => 'La Mala',
                'type' => 'Mediterránea',
                'description' => 'La Mala Almería es un restaurante mediterráneo, bar, tapas, español, europeo, fusión e internacional que ofrece una variedad de platos, entre tortillas, tapas y raciones.',
                'photo' => 'lamala.jpg',
                'latitude' => 36.837743,
                'longitude' => -2.465706,
                'address' => 'Calle Real 69 Esquina C/Seneca, 04120',
                'place_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Divino Ristorante Italiano',
                'type' => 'Italiana',
                'description' => 'Ubicado en el corazón de Granada, Divino Ristorante Italiano es un restaurante italiano de alta calificación que sirve cocina tradicional toscana y romana.',
                'photo' => 'divino.jpg',
                'latitude' => 37.1680696,
                'longitude' => -3.5971365,
                'address' => 'Casa Colón, Calle Ribera del Genil, 2, 18005',
                'place_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ruar Street Food',
                'type' => 'Americana',
                'description' => 'Ruar Street Food es un restaurante de comida española y tapas ubicado en el corazón de Barcelona. Ofrece una variedad de opciones deliciosas y auténticas, como bocadillos y burgers viajados, combinados con acompañamientos crujientes y sabrosos.',
                'photo' => 'ruar.jpg',
                'latitude' => 41.375112,
                'longitude' => 2.155648,
                'address' => 'Avenida del Paralelo 172, 08015',
                'place_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'La Teca Salou',
                'type' => 'Mediterránea',
                'description' => 'La Teca Salou es un restaurante ubicado en Salou, Tarragona, España. Se trata de un lugar ideal para disfrutar de una comida mediterránea, contemporánea y española, con opciones internacionales también disponibles.',
                'photo' => 'lateca.jpg',
                'latitude' => 41.0783778,
                'longitude' => 1.1299106,
                'address' => 'Carrer de la Ciutat de Reus, 43840',
                'place_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DiverXO',
                'type' => 'Fusión',
                'description' => 'DiverXO es un restaurante creativo ubicado en Madrid, España. Se encuentra en el corazón de la ciudad, en el barrio de Chamberí.',
                'photo' => 'Diverxo.jpg',
                'latitude' => 40.4583904,
                'longitude' => -3.6859695,
                'address' => 'NH Eurobuilding, C. del Padre Damián, 23, Chamartín, 28036',
                'place_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Restaurante Alfileritos 24',
                'type' => 'Española',
                'description' => 'Restaurante con varias salas con paredes de ladrillo visto, donde se sirven tapas creativas, platos de caza, desayunos y cócteles.',
                'photo' => 'alfileritos.jpg',
                'latitude' => 39.8597785,
                'longitude' => -4.0235035,
                'address' => 'Calle Alfileritos 24, 45003',
                'place_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sidrería Pichote',
                'type' => 'Asturiana',
                'description' => 'Restaurante amplio y tradicional, de ambiente relajado, especializado en cachopo asturiano.',
                'photo' => 'sidreria.png',
                'latitude' => 43.3680545,
                'longitude' => -5.8683784,
                'address' => 'Calle Mateo Llana Díaz-Estébanez, 8, 33012',
                'place_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'La Portada de Mediodia',
                'type' => 'Castellana',
                'description' => 'Cochinillo y cordero en una antigua casa de postas del s. XVI con paredes de piedra y vigas de madera vistas.',
                'photo' => 'laportada.jpg',
                'latitude' => 40.992655,
                'longitude' => -4.0243087,
                'address' => 'Calle San Nicolás de Bari, 31, 40160 Torrecaballeros',
                'place_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oven Mozzarella Bar',
                'type' => 'Italiana',
                'description' => 'Si eres un gran amante de la cocina italiana estás de suerte porque el restaurante Ôven la elabora con los mejores productos traídos desde la mismísima Italia.',
                'photo' => 'OvenMurcia.jpg',
                'latitude' => 37.9868892,
                'longitude' => -1.1306316,
                'address' => 'Plaza de Julián Romea, 30001',
                'place_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'El Torreón',
                'type' => 'Asador',
                'description' => 'Bienvenidos a El Torreón, un pequeño rincón gastronómico en un lugar único de Cuenca. Cocina tradicional basada en productos de gran calidad con exquisitez de sabores. Un lugar de encuentro, donde comer bien y pasarlo mejor.',
                'photo' => 'torreon.jpg',
                'latitude' => 39.1361372,
                'longitude' => -1.6759546,
                'address' => 'Calle Larga, 23, 02150 Valdeganga',
                'place_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
