<?php

namespace App\Repository\Eloquent;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Models\Livro;
use App\Repository\Eloquent\AbstractRepository;

class LivroRepository extends AbstractRepository
{
    protected function model()
    {
        return Livro::class;
    }

    public function findById($id)
    {
        $livro = $this->model()::find($id);

        if (!$livro) {
            throw new ModelNotFoundException("Livro com ID {$id} não encontrado");
        }

        return $livro;
    }

    public function buscarPorTituloComPagination($titulo, $qtd)
    {
        return $this->model()::where('Titulo', 'like', "%$titulo%")->paginate($qtd);
    }

    public function create(array $dados)
    {
        try {
            return $this->model()::create($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao criar livro: ' . $e->getMessage());
        }
    }

    public function update($id, array $dados)
    {
        try {
            $livro = $this->model()::findOrFail($id);
            $livro->update($dados);
            return $livro;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao atualizar livro: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $livro = $this->model()::findOrFail($id);
            $livro->delete();
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao deletar livro: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $livro = $this->model()::withTrashed()->findOrFail($id);
            $livro->restore();
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao restaurar livro: ' . $e->getMessage());
        }
    }

    public function allWithRelations()
    {
        return $this->model()::with(['autores', 'assuntos'])->get();
    }

    public function allWithPagination($qtd = 10)
    {
        return $this->model()::paginate($qtd);
    }
}
