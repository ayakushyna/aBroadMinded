<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        app($this->validateRequest);

        try {
            $item = $this->baseRepository->create($request->only($this->baseRepository->getModel()->getFillable()));
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'items' => $item
        ], 200);
    }

    public function update(Request $request,$id)
    {
        app($this->validateRequest);

        try {
            $item = $this->baseRepository->update($request->only($this->baseRepository->getModel()->getFillable()), $id);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'items' => ['id' => $id]
        ], 200);
    }
}
