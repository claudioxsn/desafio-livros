<?php

namespace App\Repository\Eloquent;

use App\Repository\Contracts\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    abstract protected function model();

    protected function resolveModel()
    {
        return app($this->model());
    }


    public function all()
    {
        return $this->model->all();
    }

    public function allWithPagination($qtd)
    {
        return $this->model->paginate($qtd);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function restore($id)
    {
        $item = $this->model->withTrashed()->findOrFail($id);
        return $item->restore();
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function withTrashed()
    {
        return $this->model->withTrashed()->get();
    }
}
