<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase Destino
 *
 *  Clase que representa la tabla 'places' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del destino
 */
class Place extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     *
     * @var string
     */
    protected $table = 'places';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = [
        'name',
        'description',
        'photo',
        'latitude',
        'longitude',
        'city_id',
    ];

    /**
     * @var string[] Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Definir un método para establecer la URL para la columna 'photo' (dónde se va a almacenar).
     *
     * @return string URL con la dirección donde se almacena la foto
     */
    public function getPhotoUrlAttribute()
    {
        // Verifica si la imagen está definida
        if ($this->photo) {
            return asset('storage/places_photos/' . $this->photo);
        } else {
            // Si no hay imagen definida, devuelve la imagen predeterminada
            return asset('storage/no-available-image.jpg');
        }
    }

    /**
     * Obtener los blogs que contiene el destino.
     *
     * @return HasMany Blogs
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'blog_id', 'id');
    }

    /**
     * Obtener el país asociado al destino.
     *
     * @return BelongsTo País
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Obtener la ciudad asociada al destino.
     *
     * @return BelongsTo Ciudad
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

}
