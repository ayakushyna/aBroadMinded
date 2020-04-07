<?php


namespace App\Repositories;


use App\Models\Feedback;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;

class FeedbackRepository extends BaseRepository implements FeedbackRepositoryInterface
{
    public function __construct(Feedback $feedback)
    {
        parent::__construct($feedback);
    }
}
