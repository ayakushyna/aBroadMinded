<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyTypeRequest;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;

class PropertyTypeController extends BaseController
{
    protected string $name = 'property type';
    protected string $validateRequest = PropertyTypeRequest::class;

    public function __construct(PropertyTypeRepositoryInterface $propertyTypeRepository)
    {
        parent::__construct($propertyTypeRepository);
    }
}
