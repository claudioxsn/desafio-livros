<?php

namespace App\Repository\Contracts;

interface RepositoryInterface
{
    public function all();
    public function allWithPagination($qtd);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function restore($id);
    public function onlyTrashed();
    public function withTrashed();
}
