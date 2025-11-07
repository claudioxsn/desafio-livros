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

    public function listAll()
    {
        return $this->autorRepository->all();
    }

    public function listAllWithPagination()
    {
        return $this->autorRepository->allWithPagination(8); // 8 autores por página
    }

    public function listAuthorsByNameWithPagination($nome)
    {
        return $this->autorRepository->findByNameWithPagination($nome, 8); // 8 autores por página
    }

    public function findById($id)
    {
          try {
            return $this->autorRepository->findById($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function create(array $dados)
    {
        try {
            return DB::transaction(function () use ($dados) {
                return $this->autorRepository->create($dados);
            });
        } catch (DatabaseException $e) {
            throw $e;  
        }
    }

    public function update($id, array $dados)
    {
        try {
            return DB::transaction(function () use ($id, $dados) {
                return $this->autorRepository->update($id, $dados);
            });
        } catch (DatabaseException $e) {
            throw $e; 
        }
    }

    public function delete($id)
    {
        try {
            $autor = $this->autorRepository->delete($id);
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
