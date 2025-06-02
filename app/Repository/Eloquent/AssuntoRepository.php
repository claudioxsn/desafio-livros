<?php

namespace App\Repository\Eloquent;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Models\Assunto;
use App\Repository\Eloquent\AbstractRepository;

class AssuntoRepository extends AbstractRepository
{
    protected function model()
    {
        return Assunto::class;
    }

    public function buscarPorId($id)
    {
        $assunto = Assunto::find($id);

        if (!$assunto) {
            throw new ModelNotFoundException("Assunto com ID {$id} não encontrado");
        }

        return $assunto;
    }

    public function buscarPorDescricaoComPagination($descricao, $qtd)
    {
        return $this->model->where('Descricao', 'like', "%$descricao%")->paginate($qtd);
    }

    public function criar(array $dados)
    {
        try {
            return Assunto::create($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao criar assunto: ' . $e->getMessage());
        }
    }

    public function atualizar($id, array $dados)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->update($dados);
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao atualizar assunto: ' . $e->getMessage());
        }
    }

    public function deletar($id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->delete();
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao deletar assunto: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $assunto = Assunto::withTrashed()->findOrFail($id);
            $assunto->restore();
            return $assunto;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao restaurar assunto: ' . $e->getMessage());
        }
    }
}
