<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\GeoRepositoryInterface;
use Illuminate\Http\Request;

class GeoController
{
    protected GeoRepositoryInterface $geoRepository;

    public function __construct(GeoRepositoryInterface $geoRepository)
    {
        $this->geoRepository = $geoRepository;
    }

    public function getCountries()
    {
        $data = $this->geoRepository->getCountries();

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getCountryByState($id)
    {
        $data = $this->geoRepository->getCountryByState($id);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getStatesByCountry($id)
    {
        $data = $this->geoRepository->getStatesByCountry($id);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getStateByCity($id)
    {
        $data = $this->geoRepository->getStateByCity($id);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getCitiesByState($id)
    {
        $data = $this->geoRepository->getCitiesByState($id);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getProfitByCountry(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $data = $this->geoRepository->getProfitByCountry($start_date, $end_date);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function getBookingCountByCountry(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $data = $this->geoRepository->getBookingCountByCountry($start_date, $end_date);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }
}
