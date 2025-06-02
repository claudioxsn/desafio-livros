<?php

namespace Tests\Feature;

use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssuntoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_criar_um_assunto()
    {
        $assunto = Assunto::factory()->create();

        $this->assertDatabaseHas('Assunto', [
            'Descricao' => $assunto->Descricao,
        ]);
    }

    public function test_pode_atualizar_um_assunto()
    {
        $assunto = Assunto::factory()->create();
        $novaDescricao = 'Novo Assunto';

        $assunto->update(['Descricao' => $novaDescricao]);

        $this->assertDatabaseHas('Assunto', [
            'codAs' => $assunto->codAs,
            'Descricao' => $novaDescricao,
        ]);
    }

    public function test_pode_deletar_um_assunto()
    {
        $assunto = Assunto::factory()->create();

        $assunto->delete();

        $this->assertSoftDeleted('Assunto', [
            'codAs' => $assunto->codAs,
        ]);
    }
}
