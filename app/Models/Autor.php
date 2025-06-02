<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Autor';
    protected $primaryKey = 'CodAu';
    public $incrementing = true;    
    protected $keyType = 'integer';  

    protected $fillable = [
        'Nome'
    ];

    public function livros()
    {
        return $this->belongsToMany(
            Livro::class,
            'livro_autor',      // Nome da tabela pivot
            'Autor_CodAu',      // Chave estrangeira deste model na tabela pivot
            'Livro_Codl'        // Chave estrangeira do model relacionado na tabela pivot
        );
    }
}
