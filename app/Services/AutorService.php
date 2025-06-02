<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Repository\Eloquent\AutorRepository;
use Illuminate\Support\Facades\DB;

class AutorService
{
    protected $autorRepository;

    public function __construct(AutorRepository $autorRepository)
    {
        $this->autorRepository = $autorRepository;
    }

    public function listarTodos()
    {
        return $this->autorRepository->all();
    }

    public function listarTodosWithPagination()
    {
        return $this->autorRepository->allWithPagination(8); // 8 autores por página
    }

    public function listarAutoresPorNomeComPagination($nome)
    {
        return $this->autorRepository->buscarPorNomeComPagination($nome, 8); // 8 autores por página
    }

    public function buscarPorId($id)
    {
          try {
            return $this->autorRepository->buscarPorId($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function criar(array $dados)
    {
        try {
            return DB::transaction(function () use ($dados) {
                return $this->autorRepository->criar($dados);
            });
        } catch (DatabaseException $e) {
            throw $e;  
        }
    }

    public function atualizar($id, array $dados)
    {
        try {
            return DB::transaction(function () use ($id, $dados) {
                return $this->autorRepository->atualizar($id, $dados);
            });
        } catch (DatabaseException $e) {
            throw $e; 
        }
    }

    public function deletar($id)
    {
        try {
            $autor = $this->autorRepository->deletar($id);
            return $autor;
        } catch (ModelNotFoundException $e) {
            throw $e; 
        } catch (DatabaseException $e) {
            throw $e;  
        }
    }

    public function restore($id)
    {
        try {
            return $this->autorRepository->restore($id);
        } catch (DatabaseException $e) {
            throw $e;  
        }
    }
}
