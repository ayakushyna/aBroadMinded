<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingController extends BaseController
{
    /**
     * BookingController constructor.
     * @param BookingRepositoryInterface $bookingRepository
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        parent::__construct('bookings', $bookingRepository);
    }
}
