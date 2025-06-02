<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_livros_por_autor');

        DB::statement("
    CREATE VIEW vw_livros_por_autor AS
    SELECT 
        a.CodAu AS autor_id,
        a.Nome AS autor_nome,
        l.Codl AS livro_id,
        l.Titulo,
        l.Editora,
        l.AnoPublicacao,
        l.Valor,
        GROUP_CONCAT(DISTINCT asu.Descricao ORDER BY asu.Descricao SEPARATOR ', ') AS assuntos
    FROM Livro l
    JOIN Livro_Autor la ON l.Codl = la.Livro_Codl
    JOIN Autor a ON a.CodAu = la.Autor_CodAu
    LEFT JOIN Livro_Assunto las ON l.Codl = las.Livro_Codl
    LEFT JOIN Assunto asu ON asu.codAs = las.Assunto_codAs
    GROUP BY a.CodAu, l.Codl
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_livros_por_autor');
    }
};
