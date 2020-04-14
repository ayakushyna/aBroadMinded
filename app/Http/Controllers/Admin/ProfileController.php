<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileController extends BaseController
{
    /**
     * ProfileController constructor.
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        parent::__construct('profiles', $profileRepository);
    }

}
