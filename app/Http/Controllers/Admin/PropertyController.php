<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyRequest;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;

class PropertyController extends BaseController
{
    protected string $name = 'property';
    protected string $validateRequest = PropertyRequest::class;
    /**
     * PropertyController constructor.
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        parent::__construct($propertyRepository);
    }

    public function getHostTypes()
    {
        $data = $this->baseRepository->getHostTypes();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }
}
