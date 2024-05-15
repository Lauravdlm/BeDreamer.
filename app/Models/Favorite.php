<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Clase Favorito
 *
 * Clase que representa la tabla 'favorites' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del favorito
 */
class Favorite extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'favorites';

    /**
     * @var string[] Columnas de la tabla
     */
    protected $fillable = ['type', 'user_id', 'place_id', 'restaurant_id', 'hotel_id', 'activity_id'];

    /**
     * @var string[] Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener el usuario asociado al favorito.
     *
     * @return BelongsTo Usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener el destino asociado al favorito.
     *
     * @return BelongsTo Destino
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    /**
     * Obtener el restaurante asociado al favorito.
     *
     * @return BelongsTo Restaurante
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    /**
     * Obtener el hotel asociado al favorito.
     *
     * @return BelongsTo Hotel
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    /**
     * Obtener la actividad asociada al favorito.
     *
     * @return BelongsTo Actividad
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
