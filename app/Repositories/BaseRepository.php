<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return Model::all();
    }

    public function findById($id)
    {
        return Model::where('id', $id)->firstOrFail();
    }

    public function update($id)
    {
        $model = Model::where('id', $id)->firstOrFail();

        $model->update(request());
    }

    public function delete($id)
    {
        Model::where('id', $id)->delete();
    }
}
