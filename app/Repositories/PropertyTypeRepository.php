<?php


namespace App\Repositories;


use App\Models\PropertyType;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;

class PropertyTypeRepository extends BaseRepository implements PropertyTypeRepositoryInterface
{
    protected $model = PropertyType::class;
}
