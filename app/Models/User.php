<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Clase Usuario
 *
 * Clase que representa la tabla 'users' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del usuario
 * @property-read Role role Rol del usuario
 */
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable ;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'users';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = ['name', 'surname', 'username', 'email', 'password', 'photo', 'instagram', 'webpage', 'city_id', 'role_id'];

    /**
     * @var string[]  Columnas de la tabla relacionadas con la contraseña
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Obtener el rol asociado al usuario.
     *
     * @return BelongsTo Rol
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * Definir un método para establecer la URL para la columna 'photo' (dónde se va a almacenar).
     *
     * @return string URL con la dirección donde se almacena la foto
     */
    public function getPhotoUrlAttribute(): string
    {
        // Verifica si la imagen del usuario está definida
        if ($this->photo) {
            // return Storage::url('profile_photos/' . $this->photo);
            return asset('storage/profile_photos/' . $this->photo);
        } else {
            return asset('storage/profile_photos/no-avatar.png');
        }
    }

    /**
     * Obtener los comentarios que contiene el usuario.
     *
     * @return HasMany Comentarios
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /**
     * Obtener las reseñas que contiene el usuario.
     *
     * @return HasMany Reseñas
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    /**
     * Obtener los blogs que contiene el usuario.
     *
     * @return HasMany Blogs
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }

    /**
     * Obtener los favoritos que contiene el usuario.
     *
     * @return HasMany Favoritos
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    /**
     * Obtener la ciudad asociada al usuario.
     *
     * @return BelongsTo Ciudad
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
