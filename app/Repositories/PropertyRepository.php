<?php


namespace App\Repositories;


use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    protected $model = Property::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();
        $cities_name = $this->getCitiesName();

        $query = DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('properties.profile_id', '=', 'profiles_name.id');
            })
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('properties.city_id', '=', 'cities_name.id');
            })
            ->select(
                'properties.*',
                'profiles_name.fullname',
                'property_types.name',
                'cities_name.city'
            );

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function getList(){
        return DB::table('properties')->select(
            'properties.id',
            'properties.title'
        )->get();
    }

    public function getProfilesName()
    {
        return DB::table('profiles')
            ->select(
                'profiles.id',
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname")
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('properties')
                    ->whereRaw('properties.profile_id = profiles.id');
            });
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
                    ->from('properties')
                    ->whereRaw('properties.city_id = cities.id');
            });
    }

    public function getPropertiesByProfile($id, array $filterItems = [],array $sortItems = [])
    {
        $cities_name = $this->getCitiesName();

        $query = DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('properties.city_id', '=', 'cities_name.id');
            })
            ->select(
                'properties.*',
                'property_types.name',
                'cities_name.city'
            )
            ->where('profile_id', '=', $id);

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function findById($id)
    {
        return DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('profiles', 'properties.profile_id', '=', 'profiles.id')
            ->leftJoin('cities','properties.city_id', '=', 'cities.id')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->select(
                'properties.*',
                'property_types.name',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city"),
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname"),
            )
            ->where('properties.id', '=', $id)
            ->first();
    }

    public function getHostTypes()
    {
        return $this->model::HOST_TYPES;
    }
}
