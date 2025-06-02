<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livro extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Livro';
    protected $primaryKey = 'Codl';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',
        'Valor',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Edicao' => 'integer',
        'Valor' => 'decimal:2',
    ];

    public function autores()
    {
        return $this->belongsToMany(
            Autor::class,
            'Livro_Autor',
            'Livro_Codl',
            'Autor_CodAu'
        );
    }

    public function assuntos()
    {
        return $this->belongsToMany(
            Assunto::class,
            'Livro_Assunto',
            'Livro_Codl',
            'Assunto_codAs'
        );
    }
}
