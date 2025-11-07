<?php

namespace App\Repository\Eloquent;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Models\Assunto;
use App\Repository\Eloquent\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException as EloquentNotFoundException;

class AssuntoRepository extends AbstractRepository
{
    protected function model()
    {
        return Assunto::class;
    }

    public function findById($id)
    {
        try {
            return $this->model()::findOrFail($id);
        } catch (EloquentNotFoundException $e) {
            throw new ModelNotFoundException("Assunto com ID {$id} não encontrado");
        }
    }

    public function findByDescriptionWithPagination($descricao, $qtd)
    {
        return $this->model->where('Descricao', 'like', "%$descricao%")->paginate($qtd);
    }

    public function create(array $dados)
    {
        try {
            return $this->model()::create($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao criar assunto: ' . $e->getMessage());
        }
    }

    public function update($id, array $dados)
    {
        try {
            $assunto = $this->model()::findOrFail($id);
            $assunto->update($dados);
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao atualizar assunto: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $assunto = $this->model()::findOrFail($id);
            $assunto->delete();
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao deletar assunto: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $assunto = $this->model()::withTrashed()->findOrFail($id);
            $assunto->restore();
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao restaurar assunto: ' . $e->getMessage());
        }
    }
}
