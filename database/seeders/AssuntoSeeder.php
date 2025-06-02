<?php

namespace Database\Seeders;

use App\Models\Assunto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assuntos = [
            'Drama',
            'Comédia',
            'Romance',
            'Ficção Científica',
            'Suspense',
            'Terror',
            'Aventura',
            'Histórico',
            'Biografia',
            'Fantasia',
        ];

        foreach ($assuntos as $descricao) {
            Assunto::create(['Descricao' => $descricao]);
        }
    }
}
