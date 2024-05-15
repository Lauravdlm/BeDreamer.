<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clase Rol
 *
 * Clase que representa la tabla 'roles' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del rol
 */
class Role extends Model
{
    use HasFactory;
    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'roles';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = ['name'];

    /**
     * @var string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Obtener los usuarios que contiene el rol.
     *
     * @return HasMany Usuarios
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
