-- Inserción de roles
INSERT INTO roles (name)
VALUES
('Administrador'),
('Registrado');

-- Inserción de paises
INSERT INTO countries (name)
VALUES
('España'),
('Francia'),
('Italia'),
('Alemania');

-- Inserción de ciudades
INSERT INTO cities (name, country_id) VALUES
('Almería', 1),
('Granada', 1),
('Barcelona', 1),
('Tarragona', 1),
('Madrid', 1),
('Toledo', 1),
('Oviedo', 1),
('Segovia', 1),
('Murcia', 1),
('Cuenca', 1),
('París', 2),
('Múnich', 4),
('Roma', 3);

-- Inserción de usuarios
INSERT INTO users (name, surname, username, email, password, city_id, role_id)
VALUES
('Usuario', 'Administrador', 'admin_user', 'admin_user@example.com', PASSWORD('password123'), 5, 1),
('Usuario', 'Registrado', 'basic_user', 'basic_user@example.com', PASSWORD('password123'), 9, 2),
('Laura', 'Valera de los Mozos', 'laura_valera', 'laura_valera@example.com', PASSWORD('password123'), 1, 1),
('Maria Teresa', 'de los Mozos Pi', 'maitepi', 'maitepi@example.com', PASSWORD('password123'), 2, 2),
('Raquel', 'Ortiz López', 'raquelortiz', 'raquel@example.com', PASSWORD('password123'), 3, 2),
('Raquel', 'Martínez Cortés', 'raquelmartinez', 'raquel2@example.com', PASSWORD('password123'), 4, 2),
('Manuel', 'Valera Llamas', 'mavalla', 'manuel@example.com', PASSWORD('password123'), 5, 2),
('Eusebio', 'Sánchez Rubio', 'euse_rt', 'euse_rt@example.com', PASSWORD('password123'), 6, 2),
('Valentina', 'Mora Valera', 'mora_valen', 'valen@example.com', PASSWORD('password123'), 7, 2);

-- Inserción  de destinos
INSERT INTO places (name, description, photo, longitude, latitude, city_id)
VALUES
('Almería', 'Almería es el centro neurálgico de la Comarca Metropolitana de Almería, en el extremo sureste de la península ibérica y de la comarca turística de Almería-Cabo de Gata-Níjar.', 'almeria.jpg', -2.4637, 36.834, 1),
('Granada', 'Granada es el vivo reflejo del esplendor de la etapa nazarí, presente en muchos de sus y en su joya arquitectónica por excelencia: La Alhambra. Considerada por muchos como la octava maravilla del mundo, este complejo palaciego atrae cada año a millones de turistas de todo el mundo....', 'granada.jpg', -3.5986, 37.1773, 2),
('Barcelona', 'Barcelona es una ciudad llena de originales opciones de ocio que animan a visitarla una y otra vez. Abierta al mar Mediterráneo y afamada por Gaudí y su arquitectura modernista, Barcelona se revela como una de las capitales europeas más trendy.', 'barcelona.jpg', 2.1734, 41.3851, 3),
('Tarragona', 'En Tarragona la historia sale de las piedras, de los libros y cobra vida. La ciudad ha ido especializándose en actividades de reconstrucción histórica.', 'tgn.jpg', 41.11667, 1.25, 4),
('Madrid', 'Situada en el corazón de España, Madrid es la vibrante capital que combina a la perfección su rica historia con la modernidad de una metrópolis cosmopolita.', 'madrid.jpg', 40.4165, -3.70256, 5),
('Toledo', 'Convertida, durante siglos, en ciudad de leyenda, dormida en el sueño de una historia que le hizo ser un día capital de Europa y centro indiscutible de la vida española, Toledo es hoy una ciudad en expansión, moderna capital administrativa de Castilla-La Mancha.', 'toledo.jpg', 39.8581, -4.02263, 6),
('Oviedo', 'Oviedo está en el corazón de Asturias, en pleno centro, y su capital es la del Principado. Es el segundo municipio más poblado de Asturias, y es uno de los puntos clave del área metropolitana de la región....', 'oviedo.jpg', 43.36029, -5.84476, 7),
('Segovia', 'Segovia es una ciudad española, capital de la provincia de su nombre, integrada en la Comunidad Autónoma de Castilla y León. Se halla situada en el interior de la Península Ibérica, próxima a Valladolid, la capital autonómica, y a Madrid, la capital estatal.', 'segovia.jpg', 40.94808, -4.11839, 8),
('Lorca', 'Lorca es conocida como la ciudad barroca por el importante legado barroco de su centro histórico, declarado conjunto histórico-artístico en 1964.', 'lorca.jpg', 37.67119, -1.7017, 9),
('Cuenca', 'Cuenca es ciudad para reposar, no de visita apresurada. Una ciudad para ver por dentro, paseando sus calles, entrando en sus rincones monumentales ; y contemplar desde fuera, desde el otro lado del Júcar; para ver bañada por el sol o iluminada por la noche.', 'cuenca.jpg', 40.06667, -2.13333, 10),
('Chartres', 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira.', 'chartres.jpg', 1.48925, 48.44685, 11),
('Arpino', 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón.', 'arpino.jpg', 14.3234, 40.8927, 12),
('Füssen', 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes.', 'füssen.jpg', 47.57143, 10.70171, 13);

-- Inserción  de blogs
INSERT INTO blogs (title, content, photo, user_id, place_id, created_at, updated_at)
VALUES
('Mi viaje a Almería', 'Hoy quiero compartir mi experiencia...', 'guia_almeria.jpg', 2, 1, NOW(), NOW()),
('Descubriendo Granada', 'Granada es una ciudad llena de historia...', 'guia_gr.jpg', 3, 2, NOW(), NOW()),
('De paseo en Segovia', 'Que bonita Segovia y que bonita su gente...', 'guia_segovia.jpg', 4, 8, NOW(), NOW()),
('Turisteando por Madrid', 'Qué decir de Madrid, capital de...', 'guia_madrid.jpg', 5, 5, NOW(), NOW()),
('Aventuras en Barcelona', 'Barcelona nunca duerme y yo tampoco...', 'guia_bcn.jpg', 6, 3, NOW(), NOW()),
('Descubriendo Chartres', 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira. Descubre su fascinante historia y arquitectura gótica.', 'guia_chartres.jpg', 1, 11, NOW(), NOW()),
('Explorando Arpino', 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón. Descubre los encantos de esta pintoresca localidad italiana.', 'guia_arpino.jpg', 1, 12, NOW(), NOW()),
('Aventuras en Füssen', 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes. Sumérgete en la belleza natural y la rica historia de esta encantadora ciudad alemana.', 'guia_füssen.jpg', 1, 13, NOW(), NOW());

-- Inserción  de restaurantes
INSERT INTO restaurants (name, type, description, photo, latitude, longitude, address, place_id, created_at, updated_at) VALUES
('La Mala', 'Mediterránea', 'La Mala Almería es un restaurante mediterráneo, bar, tapas, español, europeo, fusión e internacional que ofrece una variedad de platos, entre tortillas, tapas y raciones.', 'lamala.jpg', 36.837743, -2.465706, 'Calle Real 69 Esquina C/Seneca, 04120', 1, NOW(), NOW()),
('Divino Ristorante Italiano', 'Italiana', 'Ubicado en el corazón de Granada, Divino Ristorante Italiano es un restaurante italiano de alta calificación que sirve cocina tradicional toscana y romana.', 'divino.jpg', 37.1680696, -3.5971365, 'Casa Colón, Calle Ribera del Genil, 2, 18005', 2, NOW(), NOW()),
('Ruar Street Food', 'Americana', 'Ruar Street Food es un restaurante de comida española y tapas ubicado en el corazón de Barcelona. Ofrece una variedad de opciones deliciosas y auténticas, como bocadillos y burgers viajados, combinados con acompañamientos crujientes y sabrosos.', 'ruar.jpg', 41.375112, 2.155648, 'Avenida del Paralelo 172, 08015', 3, NOW(), NOW()),
('La Teca Salou', 'Mediterránea', 'La Teca Salou es un restaurante ubicado en Salou, Tarragona, España. Se trata de un lugar ideal para disfrutar de una comida mediterránea, contemporánea y española, con opciones internacionales también disponibles.', 'lateca.jpg', 41.0783778, 1.1299106, 'Carrer de la Ciutat de Reus, 43840', 4, NOW(), NOW()),
('DiverXO', 'Fusión', 'DiverXO es un restaurante creativo ubicado en Madrid, España. Se encuentra en el corazón de la ciudad, en el barrio de Chamberí.', 'Diverxo.jpg', 40.4583904, -3.6859695, 'NH Eurobuilding, C. del Padre Damián, 23, Chamartín, 28036', 5, NOW(), NOW()),
('Restaurante Alfileritos 24', 'Española', 'Restaurante con varias salas con paredes de ladrillo visto, donde se sirven tapas creativas, platos de caza, desayunos y cócteles.', 'alfileritos.jpg', 39.8597785, -4.0235035, 'Calle Alfileritos 24, 45003', 6, NOW(), NOW()),
('Sidrería Pichote', 'Asturiana', 'Restaurante amplio y tradicional, de ambiente relajado, especializado en cachopo asturiano.', 'sidreria.png', 43.3680545, -5.8683784, 'Calle Mateo Llana Díaz-Estébanez, 8, 33012', 7, NOW(), NOW()),
('La Portada de Mediodia', 'Castellana', 'Cochinillo y cordero en una antigua casa de postas del s. XVI con paredes de piedra y vigas de madera vistas.', 'laportada.jpg', 40.992655, -4.0243087, 'Calle San Nicolás de Bari, 31, 40160 Torrecaballeros', 8, NOW(), NOW()),
('Oven Mozzarella Bar', 'Italiana', 'Si eres un gran amante de la cocina italiana estás de suerte porque el restaurante Ôven la elabora con los mejores productos traídos desde la mismísima Italia.', 'OvenMurcia.jpg', 37.9868892, -1.1306316, 'Plaza de Julián Romea, 30001', 9, NOW(), NOW()),
('El Torreón', 'Asador', 'Bienvenidos a El Torreón, un pequeño rincón gastronómico en un lugar único de Cuenca. Cocina tradicional basada en productos de gran calidad con exquisitez de sabores. Un lugar de encuentro, donde comer bien y pasarlo mejor.', 'torreon.jpg', 39.1361372, -1.6759546, 'Calle Larga, 23, 02150 Valdeganga', 10, NOW(), NOW());


-- Inserción  de hoteles
INSERT INTO hotels (name, description, photo, services, classification, address, latitude, longitude, place_id, created_at, updated_at)
VALUES
('AC Hotel Almería by Marriott', 'Este hotel elegante se encuentra en el centro de Almería, a pocos pasos de la Plaza de las Flores.', 'acalmeria.jpg', 'Wifi gratuito, restaurante, bar, gimnasio', 4, 'Plaza Flores, 5, 04001', 36.8403, -2.4659, 1, NOW(), NOW()),
('NH Collection Granada Victoria', 'Un hotel moderno ubicado en el centro de Granada.', 'nhgranada.jpg', 'Wi-Fi, restaurante, bar, parking', 4, 'Puerta Real, 3, 18005', 37.1759, -3.5986, 2, NOW(), NOW()),
('Hotel Arts Barcelona', 'Un lujoso hotel con vistas al mar en Barcelona.', 'artsbcn.jpg', 'Wi-Fi, piscina, spa, restaurante', 5, 'Carrer de la Marina, 19-21, 08005', 41.3890, 2.1931, 3, NOW(), NOW()),
('AC Hotel Tarragona by Marriott', 'Un moderno hotel cerca del centro histórico de Tarragona.', 'actgn.jpg', 'Wi-Fi, gimnasio, bar, parking', 4, 'Carrer de Mallorca, 52, 43001', 41.1196, 1.2455, 4, NOW(), NOW()),
('The Westin Palace, Madrid', 'Un hotel icónico en el corazón de Madrid.', 'westinmdd.jpg', 'Wi-Fi, piscina, spa, restaurante', 5, 'Plaza de las Cortes, 7, 28014', 40.4150, -3.6973, 5, NOW(), NOW()),
('Eurostars Toledo', 'Un hotel con encanto en el casco antiguo de Toledo.', 'eurostar.jpg', 'Wi-Fi, restaurante, bar', 4, 'Paseo de San Eugenio, s/n, 45003', 39.8564, -4.0258, 6, NOW(), NOW()),
('Barceló Oviedo Cervantes', 'Un hotel elegante en el centro de Oviedo.', 'barcel.jpg', 'Wi-Fi, gimnasio, bar, parking', 5, 'C/ Cervantes, 13, 33004', 43.3634, -5.8460, 7, NOW(), NOW()),
('Hotel Infanta Isabel', 'Un hotel histórico en la Plaza Mayor de Segovia.', 'isabel.jpg', 'Wi-Fi, restaurante, bar', 3, 'Plaza Mayor, s/n, 40001', 40.9495, -4.1246, 8, NOW(), NOW()),
('Parador de Lorca', 'Un parador histórico ubicado en el Castillo de Lorca.', 'parador.jpg', 'Wi-Fi, restaurante, bar, piscina', 4, 'Castillo de Lorca, s/n, 30800', 37.6695, -1.6966, 9, NOW(), NOW()),
('Parador de Cuenca', 'Un parador con vistas espectaculares en Cuenca.', 'paradorcuenca.jpg', 'Wi-Fi, restaurante, bar, spa', 4, 'Cerro del Socorro, s/n, 16001', 40.0721, -2.1408, 10, NOW(), NOW()),
('Best Western Premier Grand Monarque Hotel & Spa', 'Un hotel con encanto en el centro de Chartres.', 'Chartres.jpg', 'Wi-Fi, restaurante, bar, spa', 4, '22 Place des Epars, 28000 Chartres, Francia', 48.4473, 1.4844, 11, NOW(), NOW()),
('Hotel Il Cavalier D\Arpino', 'Un acogedor hotel en el corazón de Arpino.', 'cavalier.jpg', 'Wi-Fi, restaurante, bar', 3, 'Piazza Municipio 2, 03033', 41.7003, 13.6258, 12, NOW(), NOW()),
('Hotel Schlosskrone', 'El Hotel Schlosskrone ofrece habitaciones elegantes.', 'schlosskrone.jpg', 'Wi-Fi, desayuno buffet, restaurante, bar, spa', 4, 'Prinzregentenplatz 4, 87629', 47.5697, 10.6935, 13, NOW(), NOW());

-- Inserción  de actividades
INSERT INTO activities (name, description, photo, type, price, address, latitude, longitude, place_id, created_at, updated_at)
VALUES
('Visita a la Alcazaba de Almería', 'Explora la impresionante fortaleza árabe con vistas panorámicas de la ciudad y el mar Mediterráneo.', 'alcazaba_almeria.jpg', 'Monumentos', 10.00, 'Calle Almanzor, s/n, 04002', 36.8402, -2.4717, 1, NOW(), NOW()),
('Visita a la Alhambra y los Jardines del Generalife', 'Sumérgete en la historia y la arquitectura islámica de este impresionante palacio y sus jardines.', 'alhambra_granada.jpg', 'Monumentos', 15.00, 'Calle Real de la Alhambra, s/n, 18009', 37.1775, -3.5875, 2, NOW(), NOW()),
('Tour por la Sagrada Familia', 'Descubre la obra maestra inacabada de Antoni Gaudí y aprende sobre su arquitectura única.', 'sagrada_familia.jpg', 'Turismo', 12.50, 'Carrer de Mallorca, 401, 08013', 41.4036, 2.1744, 3, NOW(), NOW()),
('Visita al Anfiteatro Romano de Tarragona', 'Explora uno de los mejores ejemplos de arquitectura romana en España, situado frente al mar Mediterráneo.', 'anfiteatro_tarragona.jpg', 'Monumentos', 8.75, 'Carrer de les Monges, 25, 43003', 41.1098, 1.2492, 4, NOW(), NOW()),
('Tour por el Museo del Prado', 'Descubre una de las colecciones de arte más importantes del mundo, con obras de maestros como Velázquez, Goya y El Greco.', 'museo_del_prado.jpg', 'Museos', 20.00, 'Paseo del Prado, s/n, 28014', 40.4139, -3.6925, 5, NOW(), NOW()),
('Recorrido por la Catedral de Toledo', 'Admira la arquitectura gótica de esta impresionante catedral, que alberga obras de arte de El Greco.', 'catedral_toledo.jpg', 'Monumentos', 10.00, 'Calle Cardenal Cisneros, 1, 45002', 39.8574, -4.0237, 6, NOW(), NOW()),
('Exploración del Casco Antiguo de Oviedo', 'Sumérgete en la historia y la cultura de Asturias mientras paseas por las calles empedradas y descubres edificios históricos.', 'casco_antiguo_oviedo.jpg', 'Turismo', 8.00, 'Casco Antiguo', 43.3614, -5.8456, 7, NOW(), NOW()),
('Visita al Alcázar de Segovia', 'Contempla el imponente castillo que inspiró el diseño del castillo de Disney y disfruta de las vistas panorámicas de la ciudad.', 'alcazar_segovia.jpg', 'Monumentos', 12.00, 'Plaza Reina Victoria Eugenia, s/n, 40003 Segovia, España', 40.9485, -4.1179, 8, NOW(), NOW()),
('Ruta por el Conjunto Monumental de Lorca', 'Descubre la riqueza histórica y arquitectónica de Lorca explorando sus monumentos, como el Castillo de Lorca y la Colegiata de San Patricio.', 'conjunto_monumental_lorca.jpg', 'Turismo', 7.50, 'Castillo de Lorca, s/n, 30800 Lorca, Murcia, España', 37.6695, -1.6966, 9, NOW(), NOW()),
('Caminata por la Ciudad Encantada', 'Maravíllate con las formaciones rocosas únicas de este paraje natural, que parecen esculpidas por la mano de un artista.', 'ciudad_encantada_cuenca.jpg', 'Turismo', 5.00, 'CM-2105, 16146 Valdecabras, Cuenca, España', 40.1308, -2.1191, 10, NOW(), NOW()),
('Visita a la Catedral de Chartres', 'Explora esta impresionante catedral gótica, famosa por sus vidrieras medievales y su laberinto tallado en el suelo.', 'catedral_chartres.jpg', 'Monumentos', 10.00, '16 Cloître Notre-Dame, 28000 Chartres, Francia', 48.4474, 1.4871, 11, NOW(), NOW()),
('Degustación de vinos en Arpino', 'Descubre los sabores de la región de Lazio con una cata de vinos en una bodega local en Arpino.', 'degustacion_vinos_arpino.jpg', 'Gastronomía', 20.00, 'Via Fontana, 14, 03034 Arpino FR, Italia', 41.6341, 13.6202, 12, NOW(), NOW()),
('Recorrido por el Castillo de Neuschwanstein', 'Visita el icónico castillo de cuento de hadas de Baviera, construido por el Rey Luis II.', 'castillo_neuschwanstein_fussen.jpg', 'Turismo', 15.00, 'Neuschwansteinstraße 20, 87645 Schwangau, Alemania', 47.5576, 10.7498, 13, NOW(), NOW());


-- Inserción  de comentarios
INSERT INTO comments (content, user_id, blog_id, created_at, updated_at)
VALUES
('¡Qué emocionante viaje! Me encantaría visitar Almería algún día.', 1, 1, NOW(), NOW()),
('Gracias por compartir tu experiencia. ¡La foto se ve increíble!', 2, 1, NOW(), NOW()),
('Granada es una ciudad hermosa. ¡Espero poder visitarla pronto!', 3, 2, NOW(), NOW()),
('Me encantó tu artículo. Granada tiene tanto que ofrecer.', 4, 2, NOW(), NOW()),
('Segovia es una joya escondida. ¡Gracias por compartir tus aventuras!', 5, 3, NOW(), NOW()),
('Tu experiencia en Segovia suena maravillosa. ¡Definitivamente tengo que ir!', 6, 3, NOW(), NOW()),
('Madrid es una ciudad increíble. ¿Cuál fue tu parte favorita del viaje?', 7, 4, NOW(), NOW()),
('Qué genial leer sobre tus aventuras en Madrid. ¡Espero visitar pronto!', 8, 4, NOW(), NOW()),
('Barcelona es una ciudad vibrante. ¡Gracias por compartir tus experiencias!', 9, 5, NOW(), NOW()),
('¡Tu artículo sobre Barcelona me hace querer empacar y salir de inmediato!', 9, 5, NOW(), NOW()),
('Prueba de comentario para el blog de Francia.', 7, 6, NOW(), NOW()),
('¡Excelente artículo sobre Francia! ¡Me encantaría leer más sobre tus viajes!', 1, 6, NOW(), NOW()),
('Prueba de comentario para el blog de Italia.', 2, 7, NOW(), NOW()),
('Gracias por compartir tus aventuras en Italia. ¡Espero leer más de tus viajes!', 4, 7, NOW(), NOW());

-- Inserción de reseñas para actividades
INSERT INTO reviews (user_id, type, content, score, activity_id, created_at, updated_at)
VALUES
(1, 'Actividad', 'Una experiencia increíble, la Alcazaba de Almería es impresionante y la guía turística fue muy informativa.', 4.5, 1, NOW(), NOW()),
(2, 'Actividad', 'La visita a la Alhambra fue lo más destacado de nuestro viaje. La arquitectura y los jardines son simplemente asombrosos.', 5.0, 2, NOW(), NOW());

-- Inserción de reseñas para restaurantes
INSERT INTO reviews (user_id, type, content, score, restaurant_id, created_at, updated_at)
VALUES
(3, 'Restaurante', 'La comida en La Mala fue deliciosa, especialmente las tapas. El ambiente era acogedor y el servicio excelente.', 4.0, 1, NOW(), NOW()),
(4, 'Restaurante', 'Divino Ristorante Italiano superó nuestras expectativas. La pasta era auténtica y deliciosa, y el personal era muy amable.', 4.5, 2, NOW(), NOW());

-- Inserción de reseñas para hoteles
INSERT INTO reviews (user_id, type, content, score, hotel_id, created_at, updated_at)
VALUES
(5, 'Hotel', 'El AC Hotel Almería by Marriott fue una excelente elección. La habitación era cómoda y limpia, y el personal era muy servicial.', 4.0, 1, NOW(), NOW()),
(6, 'Hotel', 'Nos encantó nuestra estancia en NH Collection Granada Victoria. La ubicación era perfecta y las instalaciones eran de primera clase.', 4.5, 2, NOW(), NOW());

-- Inserción  de favoritos
INSERT INTO favorites (type, user_id, restaurant_id, hotel_id, activity_id, place_id)
VALUES
('Restaurante', 5, 7, NULL, NULL, (SELECT place_id FROM restaurants WHERE id = 7)),
('Restaurante', 2, 2, NULL, NULL, (SELECT place_id FROM restaurants WHERE id = 2)),
('Actividad', 3, NULL, NULL, 6, (SELECT place_id FROM activities WHERE id = 6)),
('Actividad', 4, NULL, NULL, 1, (SELECT place_id FROM activities WHERE id = 1)),
('Hotel', 7, NULL, 3, NULL, (SELECT place_id FROM hotels WHERE id = 3)),
('Hotel', 6, NULL, 9, NULL, (SELECT place_id FROM hotels WHERE id = 9)),
('Restaurante', 3, 1, NULL, NULL, (SELECT place_id FROM restaurants WHERE id = 1));
