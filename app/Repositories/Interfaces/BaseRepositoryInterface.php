<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface BaseRepositoryInterface
{
    public function all(array $filterItems, array $sortItems);

    public function applyFilter($query, array $filterItems);

    public function applySorting($query, array $sortItems);

    public function findById($id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function getFieldsInfo();
}
