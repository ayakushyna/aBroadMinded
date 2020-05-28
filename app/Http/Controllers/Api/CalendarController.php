<?php


namespace App\Http\Controllers\Api;


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

    public function getDates($id)
    {
        $data = $this->baseRepository->getDates($id);

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }
}
