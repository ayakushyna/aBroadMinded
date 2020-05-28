<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    public function validateProfile(Request $request)
    {
        app($this->validateRequest);

        return  response()->json(['status' => 'success'], 200);
    }

    public function updatePhoto(Request $request,$id)
    {
        $image = $request->photo;

        if(isset($image))
        {
            $image_path = $image->storeAs(
                'profile_' . $id, time() . '_' . $image->getClientOriginalName(), 'public'
            );

            Profile::where('id', '=', $id)
                ->update(['photo'=> $image_path]);
        }

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function deletePhoto($id)
    {
        $image = Profile::select('photo')
                ->where('id', '=', $id)
                ->get();

        if(Storage::disk('public')->exists($image->image_path))
        {
            Storage::disk('public')->delete($image->image_path);
        }
    }

    public function getList()
    {
        $data = $this->baseRepository->getList();

        return  response()->json(
            [
                'items' => $data
            ], 200);
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
        $fields = $propertyRepository->getFieldsInfoExcludeProfile();

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
        $fields = $bookingRepository->getFieldsInfoExcludeProfile();

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
        $fields = $feedbackRepository->getFieldsInfoExcludeProfile();

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
