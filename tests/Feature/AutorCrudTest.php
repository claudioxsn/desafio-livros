<?php

namespace Tests\Feature;

use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutorCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_author()
    {
        $response = $this->postJson('/api/autores', [
            'Nome' => 'Autor Teste'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('Autor', ['Nome' => 'Autor Teste']);
    }

    public function test_test_can_list_authors()
    {
        Autor::factory()->count(3)->create();

        $response = $this->getJson('/api/autores');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_test_can_update_author()
    {
        $autor = Autor::factory()->create(['Nome' => 'Antigo Nome']);

        $response = $this->putJson("/api/autores/{$autor->CodAu}", [
            'Nome' => 'Novo Nome'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('Autor', ['CodAu' => $autor->CodAu, 'Nome' => 'Novo Nome']);
    }

    public function test_can_delete_author()
    {
        $autor = Autor::factory()->create();

        $response = $this->deleteJson("/api/autores/{$autor->CodAu}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('Autor', ['CodAu' => $autor->CodAu]);
    }
}
