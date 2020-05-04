<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Repositories\Interfaces\GeoRepositoryInterface;
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
}
