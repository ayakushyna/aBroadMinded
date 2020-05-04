<?php


namespace App\Repositories;


use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    protected $model = Booking::class;
}
