<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;

class PropertyController extends BaseController
{
    /**
     * PropertyController constructor.
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        parent::__construct('properties', $propertyRepository);
    }
}
