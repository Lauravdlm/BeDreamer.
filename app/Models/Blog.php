<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase Blog
 *
 * Clase que representa la tabla 'blogs' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del blog
*/
class Blog extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = [
        'title',
        'content',
        'photo',
        'user_id',
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
     * Definir un método para establecer la URL para la columna 'photo' (dónde se va a almacenar).
     *
     * @return string URL con la dirección donde se almacena la foto
     */
    public function getPhotoUrlAttribute(): string
    {
        // Verifica si la imagen de portada está definida
        if ($this->photo) {
            return asset('storage/blog_photos/' . $this->photo);
        } else {
            // Si no hay imagen definida, devuelve la imagen predeterminada
            return asset('storage/no-available-image.jpg');
        }
    }

    /**
     * Obtener el usuario asociado al blog.
     *
     * @return BelongsTo Destino
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    /**
     * Obtener el destino asociado al blog.
     *
     * @return BelongsTo Destinos
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    /**
     * Obtener los comentarios que contiene el blog.
     *
     * @return HasMany Comentarios
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id');
    }
}
