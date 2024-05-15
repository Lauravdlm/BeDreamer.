<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase Restaurante
 *
 * Clase que representa la tabla 'restaurants' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del restaurante
 */
class Restaurant extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'restaurants';

    /**
     * @var string[] Columnas de la tabla
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'photo',
        'address',
        'latitude',
        'longitude',
        'place_id',
    ];

    /**
     * @var string[] Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener el destino asociado al restaurante.
     *
     * @return BelongsTo Destino
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    /**
     * Obtener las reseñas que contiene el restaurante.
     *
     * @return HasMany Reseñas
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'restaurant_id', 'id');
    }

    /**
     * Comprobar que un usuario tiene un determinado restaurante en favoritos.
     *
     * @param User $user Datos el usuario
     *
     * @return bool True en caso de que el usuario tenga ese restaurante añadido en favoritos | False en caso contrario
     */
    public function isFavorite(User $user): bool
    {
        return $user->favorites()->where('restaurant_id', $this->id)->exists();
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
            return asset('storage/restaurants_photos/' . $this->photo);
        } else {
            // Si no hay imagen definida, devuelve la imagen predeterminada
            return asset('storage/no-available-image.jpg');
        }
    }
}
