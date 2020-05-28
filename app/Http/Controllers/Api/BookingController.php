<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingController extends BaseController
{
    protected string $name = 'booking';
    protected string $validateRequest = BookingRequest::class;
    /**
     * BookingController constructor.
     * @param BookingRepositoryInterface $bookingRepository
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        parent::__construct($bookingRepository);
    }

    public function getDates($id)
    {
        $data = $this->baseRepository->getDates($id);

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getStatuses()
    {
        $data = $this->baseRepository->getStatuses();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }
}
