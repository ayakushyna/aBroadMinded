<?php


namespace App\Repositories;


use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    public function __construct(Booking $booking)
    {
        parent::__construct($booking);
    }
}
