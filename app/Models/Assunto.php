<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Assunto",
 *     type="object",
 *     title="Assunto",
 *     required={"id", "nome"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="Filosofia"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-01T12:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
 * )
 */
class Assunto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Assunto';
    protected $primaryKey = 'codAs';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'Descricao',
    ];

    public function livros()
    {
        return $this->belongsToMany(
            Livro::class,
            'livro_assunto',
            'Assunto_codAs',
            'Livro_Codl'
        );
    }
}
