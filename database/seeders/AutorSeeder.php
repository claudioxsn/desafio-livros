<?php

namespace Database\Seeders;

use App\Models\Autor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nomes = [
            'Márcio',
            'Fernanda',
            'João',
            'Aline',
            'Carlos',
            'Renata',
            'Lucas',
            'Beatriz',
            'Roberto',
            'Juliana',
        ];

        foreach ($nomes as $nome) {
            Autor::create(['Nome' => $nome]);
        }
    }
}
