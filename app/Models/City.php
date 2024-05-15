<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Clase Ciudad
 *
 * Clase que representa la tabla 'cities' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único de la ciudad
 */
class City extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'cities';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = [
        'name',
        'country_id'
    ];

    /**
     * @var array|string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Obtener el país asociado a la ciudad.
     *
     * @return BelongsTo País
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Obtener los destinos que contiene la ciudad.
     *
     * @return HasMany Destinos
     */
    public function place(): HasMany
    {
        return $this->hasMany(Place::class, 'place_id', 'id');
    }
}
