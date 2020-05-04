<?php


namespace App\Repositories\Interfaces;


interface GeoRepositoryInterface
{
    public function getCountries();

    public function getCountryByState($id);

    public function getStatesByCountry($id);

    public function getStateByCity($id);

    public function getCitiesByState($id);
}
