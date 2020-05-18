<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;
    protected array $operators = ["=", "<", ">", "<=", ">=", "<>", "!="];

    public function __construct()
    {
        $this->model = new $this->model();
    }

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $query = $this->applyFilter($this->model, $filterItems);
        $query = $this->applySorting($query, $sortItems);
        return $query->paginate(10);
    }

    public function applyFilter($query = null, array $filterItems = [])
    {
        if($query != null && $filterItems){
            foreach ($filterItems as $filter)
            {
                $value = $filter['value'];
                if(in_array($filter['comparator'], $this->operators)){
                    $query = $query->where($filter['key'], $filter['comparator'], $value);
                }
                else {
                    $query = $query->where($filter['key'], $filter['comparator'], "%$value%");
                }

            }
        }
        return $query;
    }

    public function applySorting($query = null, array $sortItems = [])
    {
        if($query != null && $sortItems){

            $this->sortOrder($sortItems);

            foreach ($sortItems as $sort)
            {
                $query = $query->orderBy($sort['key'], $sort['direction']);
            }
        }
        return $query;
    }

    private function sortOrder(array &$array = [])
    {
        usort($array, function ($first, $second){
            return $first['order'] - $second['order'];
        });
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

    public function getFieldsInfo()
    {
        return $this->model::FIELDS_INFO;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
