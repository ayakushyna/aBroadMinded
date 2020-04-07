<?php


namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function all();

    public function findById($id);

    public function update($id);

    public function delete($id);
}
