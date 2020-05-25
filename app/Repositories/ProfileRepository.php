<?php


namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    protected $model = Profile::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $cities_name = $this->getCitiesName();

        $query = DB::table('profiles')
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('profiles.city_id', '=', 'cities_name.id');
            })
            ->select(
                'profiles.*',
                'cities_name.city'
            );

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(10);
    }

    public function getList(){
        return DB::table('profiles')->select(
            'profiles.id',
            'profiles.first_name',
            'profiles.last_name'
        )->get();
    }

    public function findById($id)
    {
        return DB::table('profiles')
            ->leftJoin('cities','profiles.city_id', '=', 'cities.id')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->select(
                'profiles.*',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city")
            )
            ->where('profiles.id', '=', $id)
            ->first();
    }

    public function getCitiesName()
    {
        return DB::table('cities')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->select(
                'cities.id',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city")
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('profiles')
                    ->whereRaw('profiles.city_id = cities.id');
            });
    }

    public function getByUserId($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function getGender()
    {
        return $this->model::GENDER;
    }
}
