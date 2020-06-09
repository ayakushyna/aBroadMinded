<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;
    protected array $operators = ["=", "<", ">", "<=", ">=", "<>", "!="];
    protected array $string_operators = ['like', 'as'];

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
                if (is_array($filter['comparator'])){
                    foreach ($filter['comparator'] as $key => $comparator) {
                        $query = $query->where($filter['key'], $comparator, $value[$key]);
                    }
                }
                else if(in_array($filter['comparator'], $this->operators)){
                    $query = $query->where($filter['key'], $filter['comparator'], $value);
                }
                else if(in_array($filter['comparator'], $this->string_operators)){
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
        DB::connection()->enableQueryLog();
        $query = $this->model->findOrFail($id);
        $queries = DB::getQueryLog();
        info( $queries );
        return $query;
    }

    public function create(array $data)
    {
        DB::connection()->enableQueryLog();
        $result = $this->model->create($data);
        $queries = DB::getQueryLog();
        info( $queries );
        return $result;
    }

    public function update(array $data, $id)
    {
        DB::connection()->enableQueryLog();
        $record = $this->model->findOrFail($id);

        $result = $record->update($data);
        $queries = DB::getQueryLog();
        info( $queries );
        return $result;
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $result =  $this->model->destroy($id);
        $queries = DB::getQueryLog();
        info( $queries );
        return $result;
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
