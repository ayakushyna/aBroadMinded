<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyRequest;
use App\Models\PropertyImage;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CalendarRepositoryInterface;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends BaseController
{
    protected string $name = 'property';
    protected string $validateRequest = PropertyRequest::class;
    /**
     * PropertyController constructor.
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        parent::__construct($propertyRepository);
    }

    public function getPropertiesWithImages(Request $request){
        $params = $this->toArray($request);
        $data = $this->baseRepository->getPropertiesWithImages($params['filters'], $params['sortings']);
        $fields = $this->baseRepository->getFieldsInfo();

        return response()->json([
            'items' => $data,
            'fields' => $fields,
            'params' => $params,
        ], 200);
    }

    public function getList()
    {
        $data = $this->baseRepository->getList();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getHostTypes()
    {
        $data = $this->baseRepository->getHostTypes();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getBookings(Request $request, $id, BookingRepositoryInterface $bookingRepository)
    {
        $params = $this->toArray($request);

        $data = $bookingRepository->getBookingsByProperty($id, $params['filters'], $params['sortings']);
        $fields = $bookingRepository->getFieldsInfoExcludeProperty();

        $data = $data->toArray();
        $items = $data['data'];

        unset($data['data']);
        $pagination = $data;

        return response()->json([
            'name' => $this->name,
            'items' => $items,
            'pagination' => $pagination,
            'fields' => $fields,
            'params' => $params,
        ], 200);

    }

    public function getFeedbacks(Request $request, $id, FeedbackRepositoryInterface $feedbackRepository)
    {
        $params = $this->toArray($request);

        $data = $feedbackRepository->getFeedbacksByProperty($id, $params['filters'], $params['sortings']);
        $fields = $feedbackRepository->getFieldsInfoExcludeProperty();

        $data = $data->toArray();
        $items = $data['data'];

        unset($data['data']);
        $pagination = $data;

        return response()->json([
            'name' => $this->name,
            'items' => $items,
            'pagination' => $pagination,
            'fields' => $fields,
            'params' => $params,
        ], 200);

    }

    public function getCalendars(Request $request, $id, CalendarRepositoryInterface $calendarRepository)
    {
        $params = $this->toArray($request);

        $data = $calendarRepository->getCalendarsByProperty($id, $params['filters'], $params['sortings']);
        $fields = $calendarRepository->getFieldsInfoExcludeProperty();

        $data = $data->toArray();
        $items = $data['data'];

        unset($data['data']);
        $pagination = $data;

        return response()->json([
            'name' => $this->name,
            'items' => $items,
            'pagination' => $pagination,
            'fields' => $fields,
            'params' => $params,
        ], 200);

    }
}
