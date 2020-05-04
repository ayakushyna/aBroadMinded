<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = new $this->model();
    }

    public function all()
    {
        return $this->model->paginate(10);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);

        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getPrimaryFields()
    {
        return $this->model->getFillable();
    }

    public function getSecondaryFields()
    {
        return [];
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
