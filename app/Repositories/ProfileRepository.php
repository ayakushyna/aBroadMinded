<?php


namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }

    public function getByUserId($id)
    {
        return $this->model->where('user_id', $id)->get();
    }
}
