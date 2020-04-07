<?php

namespace App\Http\Controllers;

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
