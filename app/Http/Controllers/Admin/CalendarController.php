<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Http\Requests\CalendarRequest;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CalendarRepositoryInterface;

class CalendarController extends BaseController
{
    protected string $name = 'calendar';
    protected string $validateRequest = CalendarRequest::class;

    public function __construct(CalendarRepositoryInterface $calendarRepository)
    {
        parent::__construct($calendarRepository);
    }
}
