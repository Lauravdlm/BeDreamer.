<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase País
 *
 * Clase que representa la tabla 'countries' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del país
 */
class Country extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'countries';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = ['name'];

    /**
     * @var array|string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Obtener las ciudades que contiene el país.
     *
     * @return HasMany Ciudades
     */
    public function city(): HasMany
    {
        return $this->hasMany(City::class, 'city_id', 'id');
    }
}
