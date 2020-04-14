<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{
    /**
     * FeedbackController constructor.
     * @param FeedbackRepositoryInterface $feedbackRepository
     */
    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        parent::__construct('feedbacks', $feedbackRepository);
    }
}
