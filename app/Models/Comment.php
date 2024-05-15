<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Clase Comentario
 *
 * Clase que representa la tabla 'comments' en la base de datos
 *
 * @package App\Models
 * @property int $id Identificador único del comentario
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * @var string  Nombre de la tabla
     */
    protected $table = 'comments';

    /**
     * @var string[]  Columnas de la tabla
     */
    protected $fillable = [
        'content',
        'user_id',
        'blog_id',
    ];

    /**
     * @var string[]  Columnas de la tabla relacionadas con la fecha
     */
    protected array $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Obtener el usuario asociado al comentario.
     *
     * @return BelongsTo Usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Obtener el blog asociado al comentario.
     *
     * @return BelongsTo Blog
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
