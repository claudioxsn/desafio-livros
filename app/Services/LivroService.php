<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Repository\Eloquent\LivroRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LivroService
{
    protected $livroRepository;

    public function __construct(LivroRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function listAll()
    {
        return $this->livroRepository->allWithRelations();
    }

    public function listAllWithPagination($qtd = 10)
    {
        return $this->livroRepository->allWithPagination($qtd);
    }

    public function listarLivrosPorTituloComPagination($titulo)
    {
        return $this->livroRepository->buscarPorTituloComPagination($titulo, 8);
    }

    public function findById($id)
    {
        try {
            return $this->livroRepository->findById($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function create(array $dados)
    {
        try {
            return DB::transaction(function () use ($dados) {
                $livro = $this->livroRepository->create($dados);

                if (isset($dados['Livro_CodAu'])) {
                    $livro->autores()->sync($dados['Livro_CodAu']);
                }

                if (isset($dados['Livro_codAs'])) {
                    $livro->assuntos()->sync($dados['Livro_codAs']);
                }

                return $livro;
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function update($id, array $dados)
    {
        try {
            return DB::transaction(function () use ($id, $dados) {
                $livro = $this->livroRepository->update($id, $dados);

                if (isset($dados['Livro_CodAu'])) {
                    $livro->autores()->sync($dados['Livro_CodAu']);
                }

                if (isset($dados['Livro_codAs'])) {
                    $livro->assuntos()->sync($dados['Livro_codAs']);
                }

                return $livro;
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            return $this->livroRepository->delete($id);
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function restore($id)
    {
        try {
            return $this->livroRepository->restore($id);
        } catch (DatabaseException $e) {
            throw $e;
        }
    }
}
