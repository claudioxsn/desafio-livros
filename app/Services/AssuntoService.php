<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Repository\Eloquent\AssuntoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssuntoService
{
    protected $assuntoRepository;

    public function __construct(AssuntoRepository $assuntoRepository)
    {
        $this->assuntoRepository = $assuntoRepository;
    }


    public function listarTodos()
    {
        return $this->assuntoRepository->all();
    }

    public function listarTodosWithPagination()
    {
        return $this->assuntoRepository->allWithPagination(8);
    }

    public function listarPorNomeComPagination($nome)
    {
        return $this->assuntoRepository->buscarPorDescricaoComPagination($nome, 8);
    }

    public function buscarPorId($id)
    {
        try {
            return $this->assuntoRepository->buscarPorId($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function criar(array $dados)
    {
        try {
            return DB::transaction(function () use ($dados) {
                return $this->assuntoRepository->criar($dados);
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        try {
            return DB::transaction(function () use ($id, $dados) {
                return $this->assuntoRepository->atualizar($id, $dados);
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function deletar($id)
    {
        try {
            return $this->assuntoRepository->deletar($id);
        } catch (ModelNotFoundException | DatabaseException $e) {
            throw $e;
        }
    }

    public function restore($id)
    {
        try {
            return $this->assuntoRepository->restore($id);
        } catch (DatabaseException $e) {
            throw $e;
        }
    }
}
