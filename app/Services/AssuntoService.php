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

    public function listAll()
    {
        return $this->assuntoRepository->all();
    }

    public function listAllWithPagination()
    {
        return $this->assuntoRepository->allWithPagination(8);
    }

    public function findByNameWithPagination($nome)
    {
        return $this->assuntoRepository->findByDescriptionWithPagination($nome, 8);
    }

    public function findById($id)
    {
        try {
            return $this->assuntoRepository->findById($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function create(array $dados)
    {
        try {
            return DB::transaction(function () use ($dados) {
                return $this->assuntoRepository->create($dados);
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function update($id, array $dados)
    {
        try {
            return DB::transaction(function () use ($id, $dados) {
                return $this->assuntoRepository->update($id, $dados);
            });
        } catch (DatabaseException $e) {
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            return $this->assuntoRepository->delete($id);
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
