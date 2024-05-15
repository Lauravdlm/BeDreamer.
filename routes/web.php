<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Rutas de autenticación
/**
 * Iniciar sesión
 */
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login');

/**
 * Registrar usuario
 */
Route::post('/register', [AuthController::class, 'register'])->name('register');

/**
 * Rutas protegidas que requieren autenticación
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * Cerrar sesión
     */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Obtener los datos del usuario autenticado
     */
    Route::get('/user', [AuthController::class, 'getUserData'])->name('user.data');
    /**
     * Panel de usuario
     */
    Route::get('/user-panel', [AuthController::class, 'index'])->name('user.panel');

    /**
     * Actualizar los datos del usuario
     */
    Route::post('/user/update', [AuthController::class, 'update'])->name('user.update');

    // Rutas relacionada con Favoritos
    /**
     * Favoritos del usuario
     */
    Route::get('/user-favorites', [FavoriteController::class, 'index'])->name('user.favorites');

    /**
     * Agregar un favorito desde el panel de usuario
     */
    Route::post('/user-favorite/store', [FavoriteController::class, 'store'])->name('user.favorites.store');

    /*
     * Eliminar un favorito
     */
    Route::delete('/user-favorite/delete/{id}', [FavoriteController::class, 'destroy'])->name('user.favorites.delete');

    /**
     * Agregar una actividad a favoritos
     */
    Route::post('/favorite/activity/add/{activity}', [FavoriteController::class, 'addActivity'])->name('favorite.activity.add');

    /**
     * Agregar un restaurante a favoritos
     */
    Route::post('/favorite/restaurant/add/{restaurant}', [FavoriteController::class, 'addRestaurant'])->name('favorite.restaurant.add');

    /**
     * Agregar un hotel a favoritos
     */
    Route::post('/favorite/hotel/add/{hotel}', [FavoriteController::class, 'addHotel'])->name('favorite.hotel.add');

    // Rutas para el blog y comentarios
    /**
     * Formulario para editar un determinado blog
     */
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');

    /**
     * Formulario para crear blog
     */
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');

    /**
     * Eliminar un blog
     */
    Route::delete('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');

    /**
     * Guardar un nuevo blog creado
     */
    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');

    /**
     * Actualizar un determinado blog
     */
    Route::put('/blog/{id}/update', [BlogController::class, 'update'])->name('blog.update');

    /**
     * Subir una foto mediante el editor de CKEditor
     */
    Route::post('/photoblog/upload', [UploadController::class, 'upload'])->name('photoblog.upload');

    /**
     * Crear comentarios para un determinado blog
     */
    Route::post('/blog/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Ruta para las reseñas
    /**
     * Crear reseñas para una determinada actividad
     */
    Route::post('/activity/{activity}/reviews', [ReviewController::class, 'storeActivity'])->name('activity.review.store');

    /**
     * Crear reseñas para un determinado hotel
     */
    Route::post('/hotel/{hotel}/reviews', [ReviewController::class, 'storeHotel'])->name('hotel.review.store');

    /**
     * Crear reseñas para un det. restaurante
     */
    Route::post('/restaurant/{restaurant}/reviews', [ReviewController::class, 'storeRestaurant'])->name('restaurant.review.store');

    /**
     * Rutas protegidas que requieren el rol administrador
     */
    Route::group(
        [
            'middleware' => 'has.admin.role', // Middleware para comprobar que el usuario tiene rol administrador
            'prefix' => 'admin-panel',
            'as' => 'admin.',
        ],
        function () {

            /**
             * Vista del Inicio del panel de Administrador
             */
            Route::get('/', [AdminController::class, 'index'])->name('index');

            /**
             * Obtener informe PDF de la tabla de usuarios
             */
            Route::get('/generate-pdf', [AdminController::class, 'generatePDF'])->name('generate-pdf');

            Route::group(
                [
                    'prefix' => 'users-management',
                    'as' => 'users-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de usuarios
                     */
                    Route::get('/', [UserController::class, 'usersTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de usuarios
                     */
                    Route::get('/search', [UserController::class, 'usersTable'])->name('search');

                    /**
                     * Eliminar un usuario
                     */
                    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un usuario
                     */
                    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [UserController::class, 'updatePhoto'])->name('update-photo');

                    /**
                     * Crear un usuario
                     */
                    Route::post('/create', [UserController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'places-management',
                    'as' => 'places-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de destinos
                     */
                    Route::get('/', [PlaceController::class, 'placesTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de destinos
                     */
                    Route::get('/search', [PlaceController::class, 'placesTable'])->name('search');

                    /**
                     * Eliminar un destino
                     */
                    Route::delete('/delete/{id}', [PlaceController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un destino
                     */
                    Route::put('/update/{id}', [PlaceController::class, 'update'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [PlaceController::class, 'updatePhoto'])->name('update-photo');
                    /**
                     * Crear un destino
                     */
                    Route::post('/create', [PlaceController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'cities-management',
                    'as' => 'cities-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de ciudades
                     */
                    Route::get('/', [CityController::class, 'citiesTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de ciudades
                     */
                    Route::get('/search', [CityController::class, 'citiesTable'])->name('search');

                    /**
                     * Eliminar una ciudad
                     */
                    Route::delete('/delete/{id}', [CityController::class, 'destroy'])->name('delete');

                    /**
                     * Editar una ciudad
                     */
                    Route::put('/update/{id}', [CityController::class, 'update'])->name('update');

                    /**
                     * Crear una ciudad
                     */
                    Route::post('/create', [CityController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'countries-management',
                    'as' => 'countries-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de países
                     */
                    Route::get('/', [CountryController::class, 'countriesTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de favoritos
                     */
                    Route::get('/search', [CountryController::class, 'countriesTable'])->name('search');

                    /**
                     * Eliminar un pais
                     */
                    Route::delete('/delete/{id}', [CountryController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un pais
                     */
                    Route::put('/update/{id}', [CountryController::class, 'update'])->name('update');

                    /**
                     * Crear un pais
                     */
                    Route::post('/create', [CountryController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'blogs-management',
                    'as' => 'blogs-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de blogs
                     */
                    Route::get('/', [BlogController::class, 'blogsTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de blogs
                     */
                    Route::get('/search', [BlogController::class, 'blogsTable'])->name('search');

                    /**
                     * Eliminar un blog
                     */
                    Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un blog
                     */
                    Route::put('/update/{id}', [BlogController::class, 'updateAdmin'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [BlogController::class, 'updatePhoto'])->name('update-photo');
                }
            );

            Route::group(
                [
                    'prefix' => 'restaurants-management',
                    'as' => 'restaurants-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de restaurantes
                     */
                    Route::get('/', [RestaurantController::class, 'restaurantsTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de restaurantes
                     */
                    Route::get('/search', [RestaurantController::class, 'restaurantsTable'])->name('search');

                    /**
                     * Eliminar un restaurante
                     */
                    Route::delete('/delete/{id}', [RestaurantController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un restaurante
                     */
                    Route::put('/update/{id}', [RestaurantController::class, 'update'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [RestaurantController::class, 'updatePhoto'])->name('update-photo');

                    /**
                     * Crear un restaurante
                     */
                    Route::post('/create', [RestaurantController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'hotels-management',
                    'as' => 'hotels-management.',
                ],
                function () {

                    /**
                     * Vista panel de administración de hoteles
                     */
                    Route::get('/', [HotelController::class, 'hotelsTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de hoteles
                     */
                    Route::get('/search', [HotelController::class, 'hotelsTable'])->name('search');

                    /**
                     * Eliminar un hotel
                     */
                    Route::delete('/delete/{id}', [HotelController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un hotel
                     */
                    Route::put('/update/{id}', [HotelController::class, 'update'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [HotelController::class, 'updatePhoto'])->name('update-photo');
                    /**
                     * Crear un hotel
                     */
                    Route::post('/create', [HotelController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'activities-management',
                    'as' => 'activities-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de actividades
                     */
                    Route::get('/', [ActivityController::class, 'activitiesTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de actividades
                     */
                    Route::get('/search', [ActivityController::class, 'activitiesTable'])->name('search');

                    /**
                     * Eliminar una actividad
                     */
                    Route::delete('/delete/{id}', [ActivityController::class, 'destroy'])->name('delete');

                    /**
                     * Editar una actividad
                     */
                    Route::put('/update/{id}', [ActivityController::class, 'update'])->name('update');

                    /**
                     * Editar la foto de portada
                     */
                    Route::put('/update-photo/{id}', [ActivityController::class, 'updatePhoto'])->name('update-photo');

                    /**
                     * Crear una actividad
                     */
                    Route::post('/create', [ActivityController::class, 'create'])->name('create');
                }
            );

            Route::group(
                [
                    'prefix' => 'comments-management',
                    'as' => 'comments-management.',
                ],
                function () {
                    /**
                     * Vista panel de administración de comentarios
                     */
                    Route::get('/', [CommentController::class, 'commentsTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de comentarios
                     */
                    Route::get('/search', [CommentController::class, 'commentsTable'])->name('search');

                    /**
                     * Eliminar un comentario
                     */
                    Route::delete('/delete/{id}', [CommentController::class, 'destroy'])->name('delete');

                    /**
                     * Editar un comentario
                     */
                    Route::put('/update/{id}', [CommentController::class, 'update'])->name('update');
                }
            );

            Route::group(
                [
                    'prefix' => 'reviews-management',
                    'as' => 'reviews-management.',
                ],
                function () {

                    /**
                     * Vista panel de administración de reseñas
                     */
                    Route::get('/', [ReviewController::class, 'reviewsTable'])->name('index');

                    /**
                     * Buscador para filtrar la tabla de reviews
                     */
                    Route::get('/search', [ReviewController::class, 'reviewsTable'])->name('search');

                    /**
                     * Eliminar una reseña
                     */
                    Route::delete('/delete/{id}', [ReviewController::class, 'destroy'])->name('delete');

                    /**
                     * Editar una reseña
                     */
                    Route::put('/update/{id}', [ReviewController::class, 'update'])->name('update');
                }
            );

            Route::group(
                [
                    'prefix' => 'favorites-management',
                    'as' => 'favorites-management.',
                ],
                function () {
                    Route::get('/', [FavoriteController::class, 'favoritesTable'])->name('index'); // Vista panel de administración de favoritos
                    Route::get('/search', [FavoriteController::class, 'favoritesTable'])->name('search'); // Buscador para filtrar la tabla de favoritos
                    Route::delete('/delete/{id}', [FavoriteController::class, 'delete'])->name('delete'); // Eliminar un favorito
                    Route::put('/update/{id}', [FavoriteController::class, 'update'])->name('update'); // Editar un favoritos
                }
            );

        }
    );
});

/** RUTAS PÚBLICAS */
/**
 * Obtener la vista de un determinado Blog
 */
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

/**
 * Obtener la vista de todos los Blogs
 */
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');

/**
 * Obtener la vista de un determinado Destino
 */
Route::get('/place/{id}', [PlaceController::class, 'show'])->name('place.show');

/**
 * Obtener la vista de todos los Destinos
 */
Route::get('/places', [PlaceController::class, 'index'])->name('places.index');

/**
 * Obtener la vista de una determinada Actividad
 */
Route::get('/activity/{id}', [ActivityController::class, 'show'])->name('activity.show');

/**
 * Obtener la vista de todas las actividades de un Destino en concreto
 */
Route::get('/places/{place_id}/activities', [ActivityController::class, 'activitiesByPlace'])->name('place.activities');

/**
 * Obtener la vista de un determinado Hotel
 */
Route::get('/hotel/{id}', [HotelController::class, 'show'])->name('hotel.show');

/**
 * Obtener la vista de todos los hoteles de un Destino en concreto
 */
Route::get('/places/{place_id}/hotels', [HotelController::class, 'hotelsByPlace'])->name('place.hotels');

/*
 * Obtener la vista de un determinado Restaurante
 */
Route::get('/restaurant/{id}', [RestaurantController::class, 'show'])->name('restaurant.show');

/*
 * Obtener la vista de todos los restaurantes de un Destino en concreto
 */
Route::get('/places/{place_id}/restaurants', [RestaurantController::class, 'restaurantsByPlace'])->name('place.restaurants');

/**
 * Obtener los mapas de las diferentes localizaciones
 */
Route::get('/map/{latitude}/{longitude}', [MapController::class, 'show'])->name('map.show');

// Rutas para el buscador dinámico en el filtrado de datos
/**
 * Lista de Destinos
 */
Route::post('/places/search', [PlaceController::class, 'search'])->name('places.search');

/**
 * Lista de Restaurantes
 */
Route::post('/restaurants/search', [RestaurantController::class, 'search'])->name('restaurants.search');

/*
 * Lista de Hoteles
 */
Route::post('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');

/*
 * Lista de Actividades
 */
Route::post('/activities/search', [ActivityController::class, 'search'])->name('activities.search');

/*
 * Lista de Ciudades
 */
Route::post('/cities/search', [CityController::class, 'search'])->name('cities.search');

/*
 * Lista de Países
 */
Route::post('/countries/search', [CountryController::class, 'search'])->name('countries.search');

/**
 * Ruta para el buscador principal del header
 */
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

/**
 * Panel de usuario
 */
Route::get('/loading-page', [HomeController::class, 'loadingPage'])->name('loading-page');

/**
 * Ruta para la página de inicio
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
