<?php


namespace App\Repositories;


use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    public function __construct(Property $property)
    {
        parent::__construct($property);
    }
}
