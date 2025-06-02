<?php

namespace App\Repository\Eloquent;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Models\Autor;
use App\Repository\Eloquent\AbstractRepository;

class AutorRepository extends AbstractRepository
{
    protected function model()
    {
        return Autor::class;
    }

    public function buscarPorId($id)
    {
        $autor = $this->model()::find($id);

        if (!$autor) {
            throw new ModelNotFoundException("Autor com ID {$id} não encontrado");
        }

        return $autor;
    }

    public function buscarPorNomeComPagination($nome, $qtd)
    {
        return $this->model->where('Nome', 'like', "%$nome%")->paginate($qtd);
    }

    public function criar(array $dados)
    {
        try {
            return $this->model()::create($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao criar autor: ' . $e->getMessage());
        }
    }

    public function atualizar($id, array $dados)
    {
        try {
            $autor = $this->model()::findOrFail($id);
            $autor->update($dados);
            return $autor;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao atualizar autor: ' . $e->getMessage());
        }
    }

    public function deletar($id)
    {
        try {
            $autor = Autor::findOrFail($id);
            $autor->delete();
            return $autor;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao deletar autor: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $autor = Autor::withTrashed()->findOrFail($id);
            $autor->restore();
            return $autor;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new DatabaseException('Erro ao restaurar autor: ' . $e->getMessage());
        }
    }
}
