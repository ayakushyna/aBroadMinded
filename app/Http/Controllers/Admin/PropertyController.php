<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyRequest;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;

class PropertyController extends BaseController
{
    protected $validateRequest = PropertyRequest::class;
    /**
     * PropertyController constructor.
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        parent::__construct('properties', $propertyRepository);
    }
}
