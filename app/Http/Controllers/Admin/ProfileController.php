<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    protected string $name = 'profile';
    protected string $validateRequest = ProfileRequest::class;
    /**
     * ProfileController constructor.
     * @param ProfileRepositoryInterface $profileRepository
     */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        parent::__construct($profileRepository);
    }

    public function getGender()
    {
        $data = $this->baseRepository->getGender();

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getProperties(Request $request, $id, PropertyRepositoryInterface $propertyRepository)
    {
        $params = $this->toArray($request);

        $data = $propertyRepository->getPropertiesByProfile($id, $params['filters'], $params['sortings']);
        $fields = $propertyRepository->getFieldsInfo();

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

    public function getBookings(Request $request, $id, BookingRepositoryInterface $bookingRepository)
    {
        $params = $this->toArray($request);

        $data = $bookingRepository->getBookingsByProfile($id, $params['filters'], $params['sortings']);
        $fields = $bookingRepository->getFieldsInfo();

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

        $data = $feedbackRepository->getFeedbacksByProfile($id, $params['filters'], $params['sortings']);
        $fields = $feedbackRepository->getFieldsInfo();

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
