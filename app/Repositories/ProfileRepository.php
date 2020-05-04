<?php


namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    protected $model = Profile::class;

    public function getByUserId($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function getGender()
    {
        return $this->model::GENDER;
    }
}
