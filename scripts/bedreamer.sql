-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bedreamer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`id`, `name`, `description`, `type`, `price`, `photo`, `address`, `latitude`, `longitude`, `place_id`, `created_at`, `updated_at`) VALUES
(1, 'Visita a la Alcazaba de Almería', 'Explora la impresionante fortaleza árabe con vistas panorámicas de la ciudad y el mar Mediterráneo.', 'Monumentos', 10.00, 'alcazaba_almeria.jpg', 'Calle Almanzor, s/n, 04002', 36.84020000, -2.47170000, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Visita a la Alhambra y los Jardines del Generalife', 'Sumérgete en la historia y la arquitectura islámica de este impresionante palacio y sus jardines.', 'Monumentos', 15.00, 'alhambra_granada.jpg', 'Calle Real de la Alhambra, s/n, 18009', 37.17750000, -3.58750000, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Tour por la Sagrada Familia', 'Descubre la obra maestra inacabada de Antoni Gaudí y aprende sobre su arquitectura única.', 'Turismo', 12.50, 'sagrada_familia.jpg', 'Carrer de Mallorca, 401, 08013', 41.40360000, 2.17440000, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'Visita al Anfiteatro Romano de Tarragona', 'Explora uno de los mejores ejemplos de arquitectura romana en España, situado frente al mar Mediterráneo.', 'Monumentos', 8.75, 'anfiteatro_tarragona.jpg', 'Carrer de les Monges, 25, 43003', 41.10980000, 1.24920000, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'Tour por el Museo del Prado', 'Descubre una de las colecciones de arte más importantes del mundo, con obras de maestros como Velázquez, Goya y El Greco.', 'Museos', 20.00, 'museo_del_prado.jpg', 'Paseo del Prado, s/n, 28014', 40.41390000, -3.69250000, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Recorrido por la Catedral de Toledo', 'Admira la arquitectura gótica de esta impresionante catedral, que alberga obras de arte de El Greco.', 'Monumentos', 10.00, 'catedral_toledo.jpg', 'Calle Cardenal Cisneros, 1, 45002', 39.85740000, -4.02370000, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Exploración del Casco Antiguo de Oviedo', 'Sumérgete en la historia y la cultura de Asturias mientras paseas por las calles empedradas y descubres edificios históricos.', 'Turismo', 8.00, 'casco_antiguo_oviedo.jpg', 'Casco Antiguo', 43.36140000, -5.84560000, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Visita al Alcázar de Segovia', 'Contempla el imponente castillo que inspiró el diseño del castillo de Disney y disfruta de las vistas panorámicas de la ciudad.', 'Monumentos', 12.00, 'alcazar_segovia.jpg', 'Plaza Reina Victoria Eugenia, s/n, 40003 Segovia, España', 40.94850000, -4.11790000, 8, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Ruta por el Conjunto Monumental de Lorca', 'Descubre la riqueza histórica y arquitectónica de Lorca explorando sus monumentos, como el Castillo de Lorca y la Colegiata de San Patricio.', 'Turismo', 7.50, 'conjunto_monumental_lorca.jpg', 'Castillo de Lorca, s/n, 30800 Lorca, Murcia, España', 37.66950000, -1.69660000, 9, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(10, 'Caminata por la Ciudad Encantada', 'Maravíllate con las formaciones rocosas únicas de este paraje natural, que parecen esculpidas por la mano de un artista.', 'Turismo', 5.00, 'ciudad_encantada_cuenca.jpg', 'CM-2105, 16146 Valdecabras, Cuenca, España', 40.13080000, -2.11910000, 10, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(11, 'Visita a la Catedral de Chartres', 'Explora esta impresionante catedral gótica, famosa por sus vidrieras medievales y su laberinto tallado en el suelo.', 'Monumentos', 10.00, 'catedral_chartres.jpg', '16 Cloître Notre-Dame, 28000 Chartres, Francia', 48.44740000, 1.48710000, 11, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(12, 'Degustación de vinos en Arpino', 'Descubre los sabores de la región de Lazio con una cata de vinos en una bodega local en Arpino.', 'Gastronomía', 20.00, 'degustacion_vinos_arpino.jpg', 'Via Fontana, 14, 03034 Arpino FR, Italia', 41.63410000, 13.62020000, 12, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(13, 'Recorrido por el Castillo de Neuschwanstein', 'Visita el icónico castillo de cuento de hadas de Baviera, construido por el Rey Luis II.', 'Turismo', 15.00, 'castillo_neuschwanstein_fussen.jpg', 'Neuschwansteinstraße 20, 87645 Schwangau, Alemania', 47.55760000, 10.74980000, 13, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `photo`, `user_id`, `place_id`, `created_at`, `updated_at`) VALUES
(1, 'Mi viaje a Almería', 'Hoy quiero compartir mi experiencia...', 'guia_almeria.jpg', 2, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Descubriendo Granada', 'Granada es una ciudad llena de historia...', 'guia_gr.jpg', 3, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'De paseo en Segovia', 'Que bonita Segovia y que bonita su gente...', 'guia_segovia.jpg', 4, 8, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'Turisteando por Madrid', 'Qué decir de Madrid, capital de...', 'guia_madrid.jpg', 5, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'Aventuras en Barcelona', 'Barcelona nunca duerme y yo tampoco...', 'guia_bcn.jpg', 6, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Descubriendo Chartres', 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira. Descubre su fascinante historia y arquitectura gótica.', 'guia_chartres.jpg', 1, 11, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Explorando Arpino', 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón. Descubre los encantos de esta pintoresca localidad italiana.', 'guia_arpino.jpg', 1, 12, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Aventuras en Füssen', 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes. Sumérgete en la belleza natural y la rica historia de esta encantadora ciudad alemana.', 'guia_füssen.jpg', 2, 13, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `name`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Almería', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(2, 'Granada', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(3, 'Barcelona', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(4, 'Tarragona', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(5, 'Madrid', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(6, 'Toledo', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(7, 'Oviedo', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(8, 'Segovia', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(9, 'Murcia', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(10, 'Cuenca', 1, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(11, 'París', 2, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(12, 'Roma', 3, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(13, 'Múnich', 4, '2024-04-29 15:40:02', '2024-04-29 15:40:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `blog_id`, `created_at`, `updated_at`) VALUES
(1, '¡Qué emocionante viaje! Me encantaría visitar Almería algún día.', 1, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Gracias por compartir tu experiencia. ¡La foto se ve increíble!', 2, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Granada es una ciudad hermosa. ¡Espero poder visitarla pronto!', 3, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'Me encantó tu artículo. Granada tiene tanto que ofrecer.', 4, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'Segovia es una joya escondida. ¡Gracias por compartir tus aventuras!', 5, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Tu experiencia en Segovia suena maravillosa. ¡Definitivamente tengo que ir!', 6, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Madrid es una ciudad increíble. ¿Cuál fue tu parte favorita del viaje?', 7, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Qué genial leer sobre tus aventuras en Madrid. ¡Espero visitar pronto!', 8, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Barcelona es una ciudad vibrante. ¡Gracias por compartir tus experiencias!', 9, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(10, '¡Tu artículo sobre Barcelona me hace querer empacar y salir de inmediato!', 9, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(11, 'Prueba de comentario para el blog de Francia.', 7, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(12, '¡Excelente artículo sobre Francia! ¡Me encantaría leer más sobre tus viajes!', 1, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(13, 'Prueba de comentario para el blog de Italia.', 2, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(14, 'Gracias por compartir tus aventuras en Italia. ¡Espero leer más de tus viajes!', 4, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'España', '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(2, 'Francia', '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(3, 'Italia', '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(4, 'Alemania', '2024-04-29 15:40:02', '2024-04-29 15:40:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED DEFAULT NULL,
  `restaurant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hotel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO `favorites` (`id`, `type`, `user_id`, `place_id`, `restaurant_id`, `hotel_id`, `activity_id`, `created_at`, `updated_at`) VALUES
(1, 'Restaurante', 5, 7, 7, NULL, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Restaurante', 2, 2, 2, NULL, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Actividad', 3, 6, NULL, NULL, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'Actividad', 4, 1, NULL, NULL, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'Hotel', 7, 3, NULL, 3, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Hotel', 6, 9, NULL, 9, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Restaurante', 3, 1, 1, NULL, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `services` text DEFAULT NULL,
  `classification` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `description`, `services`, `classification`, `photo`, `address`, `latitude`, `longitude`, `place_id`, `created_at`, `updated_at`) VALUES
(1, 'AC Hotel Almería by Marriott', 'Este hotel elegante se encuentra en el centro de Almería, a pocos pasos de la Plaza de las Flores.', 'Wifi gratuito, restaurante, bar, gimnasio', 4, 'acalmeria.jpg', 'Plaza Flores, 5, 04001', 36.84030000, -2.46590000, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'NH Collection Granada Victoria', 'Un hotel moderno ubicado en el centro de Granada.', 'Wi-Fi, restaurante, bar, parking', 4, 'nhgranada.jpg', 'Puerta Real, 3, 18005', 37.17590000, -3.59860000, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Hotel Arts Barcelona', 'Un lujoso hotel con vistas al mar en Barcelona.', 'Wi-Fi, piscina, spa, restaurante', 5, 'artsbcn.jpg', 'Carrer de la Marina, 19-21, 08005', 41.38900000, 2.19310000, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'AC Hotel Tarragona by Marriott', 'Un moderno hotel cerca del centro histórico de Tarragona.', 'Wi-Fi, gimnasio, bar, parking', 4, 'actgn.jpg', 'Carrer de Mallorca, 52, 43001', 41.11960000, 1.24550000, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'The Westin Palace, Madrid', 'Un hotel icónico en el corazón de Madrid.', 'Wi-Fi, piscina, spa, restaurante', 5, 'westinmdd.jpg', 'Plaza de las Cortes, 7, 28014', 40.41500000, -3.69730000, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Eurostars Toledo', 'Un hotel con encanto en el casco antiguo de Toledo.', 'Wi-Fi, restaurante, bar', 4, 'eurostar.jpg', 'Paseo de San Eugenio, s/n, 45003', 39.85640000, -4.02580000, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Barceló Oviedo Cervantes', 'Un hotel elegante en el centro de Oviedo.', 'Wi-Fi, gimnasio, bar, parking', 5, 'barcel.jpg', 'C/ Cervantes, 13, 33004', 43.36340000, -5.84600000, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Hotel Infanta Isabel', 'Un hotel histórico en la Plaza Mayor de Segovia.', 'Wi-Fi, restaurante, bar', 3, 'isabel.jpg', 'Plaza Mayor 12, 40001', 40.94950000, -4.12460000, 8, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Parador de Lorca', 'Un parador histórico ubicado en el Castillo de Lorca.', 'Wi-Fi, restaurante, bar, piscina', 4, 'parador.jpg', 'Castillo de Lorca, s/n, 30800', 37.66950000, -1.69660000, 9, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(10, 'Parador de Cuenca', 'Un parador con vistas espectaculares en Cuenca.', 'Wi-Fi, restaurante, bar, spa', 4, 'paradorcuenca.jpg', 'Cerro del Socorro, s/n, 16001', 40.07210000, -2.14080000, 10, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(11, 'Best Western Premier Grand Monarque Hotel & Spa', 'Un hotel con encanto en el centro de Chartres.', 'Wi-Fi, restaurante, bar, spa', 4, 'Chartres.jpg', '22 Place des Epars, 28000 Chartres, Francia', 48.44730000, 1.48440000, 11, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(12, 'Hotel Il Cavalier D\\Arpino', 'Un acogedor hotel en el corazón de Arpino.', 'Wi-Fi, restaurante, bar', 3, 'cavalier.jpg', 'Piazza Municipio 2, 03033', 41.70030000, 13.62580000, 12, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(13, 'Hotel Schlosskrone', 'El Hotel Schlosskrone ofrece habitaciones elegantes.', 'Wi-Fi, desayuno buffet, restaurante, bar, spa', 4, 'schlosskrone.jpg', 'Prinzregentenplatz 4, 87629', 47.56970000, 10.69350000, 13, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_16_191916_create_roles_table', 1),
(3, '2024_01_16_191917_create_countries_table', 1),
(4, '2024_01_16_191927_create_cities_table', 1),
(5, '2024_01_16_191937_create_users_table', 1),
(6, '2024_01_16_191947_create_places_table', 1),
(7, '2024_01_16_192153_create_blogs_table', 1),
(8, '2024_01_16_192558_create_restaurants_table', 1),
(9, '2024_01_16_192721_create_hotels_table', 1),
(10, '2024_01_16_192722_create_activities_table', 1),
(11, '2024_01_16_192936_create_comments_table', 1),
(12, '2024_01_16_192937_create_reviews_table', 1),
(13, '2024_01_20_002605_create_favorites_table', 1),
(14, '2024_02_27_162850_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'token', '38f8d60fe05829ceef787701adaebac810bfb9067898c462f83d0d0e9f098a67', '[\"*\"]', '2024-04-29 15:44:19', NULL, '2024-04-29 15:40:32', '2024-04-29 15:44:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `places`
--

INSERT INTO `places` (`id`, `name`, `description`, `photo`, `latitude`, `longitude`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'Almería', 'Almería es el centro neurálgico de la Comarca Metropolitana de Almería, en el extremo sureste de la península ibérica y de la comarca turística de Almería-Cabo de Gata-Níjar.', 'almeria.jpg', 36.83400000, -2.46370000, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Granada', 'Granada es el vivo reflejo del esplendor de la etapa nazarí, presente en muchos de sus y en su joya arquitectónica por excelencia: La Alhambra. Considerada por muchos como la octava maravilla del mundo, este complejo palaciego atrae cada año a millones de turistas de todo el mundo.', 'granada.jpg', 37.17730000, -3.59860000, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Barcelona', 'Barcelona es una ciudad llena de originales opciones de ocio que animan a visitarla una y otra vez. Abierta al mar Mediterráneo y afamada por Gaudí y su arquitectura modernista, Barcelona se revela como una de las capitales europeas más trendy.', 'barcelona.jpg', 41.38510000, 2.17340000, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'Tarragona', 'En Tarragona la historia sale de las piedras, de los libros y cobra vida. La ciudad ha ido especializándose en actividades de reconstrucción histórica.', 'tgn.jpg', 41.11667000, 1.25000000, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'Madrid', 'Situada en el corazón de España, Madrid es la vibrante capital que combina a la perfección su rica historia con la modernidad de una metrópolis cosmopolita.', 'madrid.jpg', 40.41650000, -3.70256000, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Toledo', 'Convertida, durante siglos, en ciudad de leyenda, dormida en el sueño de una historia que le hizo ser un día capital de Europa y centro indiscutible de la vida española, Toledo es hoy una ciudad en expansión, moderna capital administrativa de Castilla-La Mancha.', 'toledo.jpg', 39.85810000, -4.02263000, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Oviedo', 'Oviedo está en el corazón de Asturias, en pleno centro, y su capital es la del Principado. Es el segundo municipio más poblado de Asturias, y es uno de los puntos clave del área metropolitana de la región....', 'oviedo.jpg', 43.36029000, -5.84476000, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Segovia', 'Segovia es una ciudad española, capital de la provincia de su nombre, integrada en la Comunidad Autónoma de Castilla y León. Se halla situada en el interior de la Península Ibérica, próxima a Valladolid, la capital autonómica, y a Madrid, la capital estatal.', 'segovia.jpg', 40.94808000, -4.11839000, 8, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Lorca', 'Lorca es conocida como la ciudad barroca por el importante legado barroco de su centro histórico, declarado conjunto histórico-artístico en 1964.', 'lorca.jpg', 37.67119000, -1.70170000, 9, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(10, 'Cuenca', 'Cuenca es ciudad para reposar, no de visita apresurada. Una ciudad para ver por dentro, paseando sus calles, entrando en sus rincones monumentales ; y contemplar desde fuera, desde el otro lado del Júcar; para ver bañada por el sol o iluminada por la noche...', 'cuenca.jpg', 40.06667000, -2.13333000, 10, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(11, 'Chartres', 'Chartres es una ciudad y comuna francesa situada en el departamento de Eure y Loir, del que es capital, en la región de Centro-Valle de Loira.', 'chartres.jpg', 48.44685000, 1.48925000, 11, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(12, 'Arpino', 'Escondida entre la frondosidad de las montañas de la provincia de Frosione, se encuentra Arpino. Quizás te suene el nombre, ya que fue aquí donde nació Cicerón.', 'arpino.jpg', 40.89270000, 14.32340000, 12, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(13, 'Füssen', 'Füssen es una ciudad de Alemania, dentro de la región de Suabia, en el estado federado de Baviera. Se encuentra a la orilla del río Lech al pie de los Alpes.', 'füssen.jpg', 47.57143000, 10.70171000, 13, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `type`, `photo`, `address`, `latitude`, `longitude`, `place_id`, `created_at`, `updated_at`) VALUES
(1, 'La Mala', 'La Mala Almería es un restaurante mediterráneo, bar, tapas, español, europeo, fusión e internacional que ofrece una variedad de platos, entre tortillas, tapas y raciones.', 'Mediterránea', 'lamala.jpg', 'Calle Real 69 Esquina C/Seneca, 04120', 36.83774300, -2.46570600, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 'Divino Ristorante Italiano', 'Ubicado en el corazón de Granada, Divino Ristorante Italiano es un restaurante italiano de alta calificación que sirve cocina tradicional toscana y romana.', 'Italiana', 'divino.jpg', 'Casa Colón, Calle Ribera del Genil, 2, 18005', 37.16806960, -3.59713650, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 'Ruar Street Food', 'Ruar Street Food es un restaurante de comida española y tapas ubicado en el corazón de Barcelona. Ofrece una variedad de opciones deliciosas y auténticas, como bocadillos y burgers viajados, combinados con acompañamientos crujientes y sabrosos.', 'Americana', 'ruar.jpg', 'Avenida del Paralelo 172, 08015', 41.37511200, 2.15564800, 3, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 'La Teca Salou', 'La Teca Salou es un restaurante ubicado en Salou, Tarragona, España. Se trata de un lugar ideal para disfrutar de una comida mediterránea, contemporánea y española, con opciones internacionales también disponibles.', 'Mediterránea', 'lateca.jpg', 'Carrer de la Ciutat de Reus, 43840', 41.07837780, 1.12991060, 4, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 'DiverXO', 'DiverXO es un restaurante creativo ubicado en Madrid, España. Se encuentra en el corazón de la ciudad, en el barrio de Chamberí.', 'Fusión', 'Diverxo.jpg', 'NH Eurobuilding, C. del Padre Damián, 23, Chamartín, 28036', 40.45839040, -3.68596950, 5, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 'Restaurante Alfileritos 24', 'Restaurante con varias salas con paredes de ladrillo visto, donde se sirven tapas creativas, platos de caza, desayunos y cócteles.', 'Española', 'alfileritos.jpg', 'Calle Alfileritos 24, 45003', 39.85977850, -4.02350350, 6, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Sidrería Pichote', 'Restaurante amplio y tradicional, de ambiente relajado, especializado en cachopo asturiano.', 'Asturiana', 'sidreria.png', 'Calle Mateo Llana Díaz-Estébanez, 8, 33012', 43.36805450, -5.86837840, 7, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'La Portada de Mediodia', 'Cochinillo y cordero en una antigua casa de postas del s. XVI con paredes de piedra y vigas de madera vistas.', 'Castellana', 'laportada.jpg', 'Calle San Nicolás de Bari, 31, 40160 Torrecaballeros', 40.99265500, -4.02430870, 8, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Oven Mozzarella Bar', 'Si eres un gran amante de la cocina italiana estás de suerte porque el restaurante Ôven la elabora con los mejores productos traídos desde la mismísima Italia.', 'Italiana', 'OvenMurcia.jpg', 'Plaza de Julián Romea, 30001', 37.98688920, -1.13063160, 9, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(10, 'El Torreón', 'Bienvenidos a El Torreón, un pequeño rincón gastronómico en un lugar único de Cuenca. Cocina tradicional basada en productos de gran calidad con exquisitez de sabores. Un lugar de encuentro, donde comer bien y pasarlo mejor.', 'Asador', 'torreon.jpg', 'Calle Larga, 23, 02150 Valdeganga', 39.13613720, -1.67595460, 10, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `restaurant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hotel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `type`, `content`, `score`, `activity_id`, `restaurant_id`, `hotel_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Actividad', 'Una experiencia increíble, la Alcazaba de Almería es impresionante y la guía turística fue muy informativa.', 4.50, 1, NULL, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(2, 2, 'Actividad', 'La visita a la Alhambra fue lo más destacado de nuestro viaje. La arquitectura y los jardines son simplemente asombrosos.', 5.00, 2, NULL, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(3, 3, 'Restaurante', 'La comida en La Mala fue deliciosa, especialmente las tapas. El ambiente era acogedor y el servicio excelente.', 4.00, NULL, 1, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(4, 4, 'Restaurante', 'Divino Ristorante Italiano superó nuestras expectativas. La pasta era auténtica y deliciosa, y el personal era muy amable.', 4.50, NULL, 2, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(5, 5, 'Hotel', 'El AC Hotel Almería by Marriott fue una excelente elección. La habitación era cómoda y limpia, y el personal era muy servicial.', 4.00, NULL, NULL, 1, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(6, 6, 'Hotel', 'Nos encantó nuestra estancia en NH Collection Granada Victoria. La ubicación era perfecta y las instalaciones eran de primera clase.', 4.50, NULL, NULL, 2, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', NULL, NULL),
(2, 'Registrado', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `password`, `photo`, `instagram`, `webpage`, `city_id`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Usuario', 'Administrador', 'admin_user', 'admin_user@example.com', '$2y$12$NQ/qrUuVm5Iiy.wxUG.J8.JW7x7mWYTtnM4.86d3dyC0ZIE9KQs5a', NULL, NULL, NULL, 5, 1, NULL, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(2, 'Usuario', 'Registrado', 'basic_user', 'basic_user@example.com', '$2y$12$Vf0Hc5gk1tTBbmZ.vexkMOz6wG4gaJll00g3on.Fu.rY9ehsJgbv2', NULL, NULL, NULL, 9, 2, NULL, '2024-04-29 15:40:02', '2024-04-29 15:40:02'),
(3, 'Laura', 'Valera de los Mozos', 'laura_valera', 'laura_valera@example.com', '$2y$12$8VPDgWQDUgwqm.mRhkCb/ut68VXcCBjUM84R0nPefV0h7JrQ4T2JO', NULL, NULL, NULL, 1, 1, NULL, '2024-04-29 15:40:03', '2024-04-29 15:40:03'),
(4, 'Maria Teresa', 'de los Mozos Pi', 'maitepi', 'maitepi@example.com', '$2y$12$PgSyuB413dOke3lWCOi02.rXkB/G4NVfdxFQFpd8mLV5siN597ed6', NULL, NULL, NULL, 2, 2, NULL, '2024-04-29 15:40:03', '2024-04-29 15:40:03'),
(5, 'Raquel', 'Ortiz López', 'raquelortiz', 'raquel@example.com', '$2y$12$t021fqdAeALK9fdEu.Ftc.ioPRKAMmhfJlN6LwT7fSVgWtYFrNCoO', NULL, NULL, NULL, 3, 2, NULL, '2024-04-29 15:40:03', '2024-04-29 15:40:03'),
(6, 'Raquel', 'Martínez Cortés', 'raquelmartinez', 'raquel2@example.com', '$2y$12$BsNtUQA4KLZR8c16u8IaKuojzsdvZ3ymxYXYnCMrpkyS/bVnHWA/W', NULL, NULL, NULL, 4, 2, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(7, 'Manuel', 'Valera Llamas', 'mavalla', 'manuel@example.com', '$2y$12$z65ESKOyJ.PPLLv34Jav6O75nADwqjtM0TKK/fHi2jWr8DU8vMrkS', NULL, NULL, NULL, 5, 2, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(8, 'Eusebio', 'Sánchez Rubio', 'euse_rt', 'euse_rt@example.com', '$2y$12$dPIZMU/5MhJugXa9e3uwoO5JnIleOdQ.ya65n8XbwgQRXSRy.BRTO', NULL, NULL, NULL, 6, 2, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04'),
(9, 'Valentina', 'Mora Valera', 'mora_valen', 'valen@example.com', '$2y$12$9OVxSn0mX4ZXSUUE1ObZlOblL/33RoDsY.L3IN8VzpSxYunJ3xjxq', NULL, NULL, NULL, 7, 2, NULL, '2024-04-29 15:40:04', '2024-04-29 15:40:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_place_id_foreign` (`place_id`);

--
-- Indices de la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_user_id_foreign` (`user_id`),
  ADD KEY `blogs_place_id_foreign` (`place_id`);

--
-- Indices de la tabla `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_blog_id_foreign` (`blog_id`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_place_id_foreign` (`place_id`),
  ADD KEY `favorites_restaurant_id_foreign` (`restaurant_id`),
  ADD KEY `favorites_hotel_id_foreign` (`hotel_id`),
  ADD KEY `favorites_activity_id_foreign` (`activity_id`);

--
-- Indices de la tabla `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotels_place_id_foreign` (`place_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `places_city_id_foreign` (`city_id`);

--
-- Indices de la tabla `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurants_place_id_foreign` (`place_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_activity_id_foreign` (`activity_id`),
  ADD KEY `reviews_restaurant_id_foreign` (`restaurant_id`),
  ADD KEY `reviews_hotel_id_foreign` (`hotel_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurants_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
