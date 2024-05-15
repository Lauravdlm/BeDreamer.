<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Clase Reseña
 *
 * Clase que representa la tabla 'reviews' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único de la reseña
 */
class Review extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'reviews';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = [
        'user_id',
        'type',
        'content',
        'score',
        'activity_id',
        'restaurant_id',
        'hotel_id',
    ];

    /**
     * @var string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Obtener el usuario asociado a la reseña.
     *
     * @return BelongsTo Usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Obtener la actividad asociada a la reseña.
     *
     * @return BelongsTo Actividad
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * Obtener el restaurante asociado a la reseña.
     *
     * @return BelongsTo Restaurante
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    /**
     * Obtener el hotel asociado a la reseña.
     *
     * @return BelongsTo Hotel
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
}
