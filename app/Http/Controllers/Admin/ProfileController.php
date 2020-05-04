<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends BaseController
{
    protected string $name = 'profile';
    protected string $validateRequest = ProfileRequest::class;
    /**
     * ProfileController constructor.
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        parent::__construct($profileRepository);
    }

    public function getGender()
    {
        $data = $this->baseRepository->getGender();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }
}
