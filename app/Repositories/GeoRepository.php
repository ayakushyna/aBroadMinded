<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Repositories\Interfaces\GeoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class GeoRepository implements GeoRepositoryInterface
{
    protected  $city = City::class;
    protected  $state = State::class;
    protected  $country = Country::class;

    public function __construct()
    {
        $this->city = new City();
        $this->state = new State();
        $this->country = new Country();
    }

    public function getCountries()
    {
        return $this->country->all();
    }

    public function getCountryByState($id)
    {
        return $this->state->find($id)->country;
    }

    public function getStatesByCountry($id)
    {
        return $this->country->find($id)->states;
    }

    public function getStateByCity($id)
    {
        return $this->city->find($id)->state;
    }

    public function getCitiesByState($id)
    {
        return $this->state->find($id)->cities;
    }

    public function getProfitByCountry($start_date, $end_date)
    {
        return DB::select(DB::raw("select * from ranking(0,'$start_date'::date, '$end_date'::date)"));
    }

    public function getBookingCountByCountry($start_date, $end_date)
    {
        return DB::select(DB::raw("select * from ranking(1,'$start_date'::date, '$end_date'::date)"));
    }
}
