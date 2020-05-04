<?php


namespace App\Repositories\Interfaces;


interface ProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUserId($id);

    public function getGender();
}
