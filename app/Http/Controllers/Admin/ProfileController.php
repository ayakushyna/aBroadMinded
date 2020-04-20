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
    protected $validateRequest = ProfileRequest::class;
    /**
     * ProfileController constructor.
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        parent::__construct('profiles', $profileRepository);
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isManager()) {
            return $this->baseRepository->all();
        }
        $userId = $user->id;
        return $this->baseRepository->getByUserId($userId);
    }
}
