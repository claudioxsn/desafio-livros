<?php

namespace Tests\Feature;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LivroCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_criar_livro_com_autores_e_assuntos()
    {
        $autores = Autor::factory()->count(3)->create();
        $assuntos = Assunto::factory()->count(2)->create();

        $livro = Livro::factory()->create();
        $livro->autores()->attach($autores->pluck('CodAu'));
        $livro->assuntos()->attach($assuntos->pluck('codAs'));

        $this->assertDatabaseHas('Livro', ['Codl' => $livro->Codl]);
        $this->assertEquals(3, $livro->autores()->count());
        $this->assertEquals(2, $livro->assuntos()->count());
    }

    public function test_pode_atualizar_livro()
    {
        $livro = Livro::factory()->create();
        $novoTitulo = 'Título Atualizado';

        $livro->update(['Titulo' => $novoTitulo]);

        $this->assertDatabaseHas('Livro', ['Codl' => $livro->Codl, 'Titulo' => $novoTitulo]);
    }

    public function test_pode_deletar_livro_com_soft_delete_e_detach()
    {
        $livro = Livro::factory()->create();
        $autores = Autor::factory()->count(2)->create();
        $assuntos = Assunto::factory()->count(2)->create();

        $livro->autores()->attach($autores->pluck('CodAu'));
        $livro->assuntos()->attach($assuntos->pluck('codAs'));

        $livro->delete();

        $this->assertSoftDeleted('Livro', ['Codl' => $livro->Codl]);
        $this->assertDatabaseCount('Livro_Autor', 2);
        $this->assertDatabaseCount('Livro_Assunto', 2);
    }

    public function test_pode_restaurar_livro()
    {
        $livro = Livro::factory()->create();
        $livro->delete();

        $this->assertSoftDeleted('Livro', ['Codl' => $livro->Codl]);

        $livro->restore();

        $this->assertDatabaseHas('Livro', ['Codl' => $livro->Codl]);
    }

    public function test_pode_buscar_livro_com_relacionamentos()
    {
        $livro = Livro::factory()->create();
        $autores = Autor::factory()->count(2)->create();
        $assuntos = Assunto::factory()->count(3)->create();

        $livro->autores()->attach($autores->pluck('CodAu'));
        $livro->assuntos()->attach($assuntos->pluck('codAs'));

        $livroComRelacoes = Livro::with(['autores', 'assuntos'])->find($livro->Codl);

        $this->assertEquals(2, $livroComRelacoes->autores->count());
        $this->assertEquals(3, $livroComRelacoes->assuntos->count());
    }
}
