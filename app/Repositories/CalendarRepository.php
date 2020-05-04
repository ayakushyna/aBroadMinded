<?php


namespace App\Repositories;


use App\Models\Calendar;
use App\Repositories\Interfaces\CalendarRepositoryInterface;

class CalendarRepository extends BaseRepository implements CalendarRepositoryInterface
{
    protected $model = Calendar::class;
}
