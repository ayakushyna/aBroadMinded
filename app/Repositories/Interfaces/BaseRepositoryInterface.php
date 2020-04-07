<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface BaseRepositoryInterface
{
    public function all();

    public function findById($id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
