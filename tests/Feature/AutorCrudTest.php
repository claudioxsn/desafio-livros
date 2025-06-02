<?php

namespace Tests\Feature;

use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutorCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_um_autor()
    {
        $response = $this->postJson('/api/autores', [
            'Nome' => 'Autor Teste'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('Autor', ['Nome' => 'Autor Teste']);
    }

    /** @test */
    public function pode_listar_autores()
    {
        Autor::factory()->count(3)->create();

        $response = $this->getJson('/api/autores');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /** @test */
    public function pode_atualizar_um_autor()
    {
        $autor = Autor::factory()->create(['Nome' => 'Antigo Nome']);

        $response = $this->putJson("/api/autores/{$autor->CodAu}", [
            'Nome' => 'Novo Nome'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('Autor', ['CodAu' => $autor->CodAu, 'Nome' => 'Novo Nome']);
    }

    /** @test */
    public function pode_deletar_um_autor()
    {
        $autor = Autor::factory()->create();

        $response = $this->deleteJson("/api/autores/{$autor->CodAu}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('Autor', ['CodAu' => $autor->CodAu]);
    }
}
