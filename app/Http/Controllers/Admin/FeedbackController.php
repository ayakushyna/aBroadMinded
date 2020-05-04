<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FeedbackRequest;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{
    protected string $name = 'feedback';
    protected string $validateRequest = FeedbackRequest::class;
    /**
     * FeedbackController constructor.
     * @param FeedbackRepositoryInterface $feedbackRepository
     */
    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        parent::__construct($feedbackRepository);
    }
}
