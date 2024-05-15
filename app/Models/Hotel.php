<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase Hotel
 *
 * Clase que representa la tabla 'hotels' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del hotel
 */
class Hotel extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'hotels';

    /**
     * @var string[] Columnas de la tabla
     */
    protected $fillable = [
        'name',
        'description',
        'services',
        'classification',
        'photo',
        'address',
        'latitude',
        'longitude',
        'place_id',
    ];

    /**
     * @var string[] Columnas de la tabla relacionadas con la fecha
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener el destino asociado al hotel.
     *
     * @return BelongsTo Destino
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    /**
     * Obtener las reseñas que contiene el hotel.
     *
     * @return HasMany Reseñas
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'hotel_id', 'id');
    }

    /**
     * Comprobar que un usuario tiene un determinado hotel en favoritos.
     *
     * @param User $user Datos el usuario
     *
     * @return bool True en caso de que el usuario tenga ese hotel añadido en favoritos | False en caso contrario
     */
    public function isFavorite(User $user): bool
    {
        return $user->favorites()->where('hotel_id', $this->id)->exists();
    }

    /**
     * Definir un método para establecer la URL para la columna 'photo' (dónde se va a almacenar).
     *
     * @return string URL con la dirección donde se almacena la foto
     */
    public function getPhotoUrlAttribute(): string
    {
        // Verifica si la imagen está definida
        if ($this->photo) {
            return asset('storage/hotels_photos/' . $this->photo);
        } else {
            // Si no hay imagen definida, devuelve la imagen predeterminada
            return asset('storage/no-available-image.jpg');
        }
    }
}
