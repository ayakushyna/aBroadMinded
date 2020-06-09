<?php


namespace App\Repositories;


use App\Models\Property;
use App\Models\PropertyImage;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    protected $model = Property::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();
        $cities_name = $this->getCitiesName();
        $scores = $this->getScore();

        $query = DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('properties.profile_id', '=', 'profiles_name.id');
            })
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('properties.city_id', '=', 'cities_name.id');
            })
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('properties.id', '=', 'scores.property_id');
            })
            ->select(
                'properties.*',
                'profiles_name.fullname',
                'property_types.name',
                'cities_name.city',
                'scores.score'
            );

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function applyFilter($query = null, array $filterItems = [])
    {
        $query = parent::applyFilter($query, $filterItems);

        if($query != null && $filterItems){
            foreach ($filterItems as $filter)
            {
                $value = $filter['value'];
                if ($filter['comparator'] == 'check_dates'){
                    $query = $query->whereRaw(
                        "(select * from check_dates(properties.id, '$value[0]'::date, '$value[1]'::date)) = true"
                    );
                }
            }
        }
        return $query;
    }

    public function getPropertiesWithImages(array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();
        $cities_name = $this->getCitiesName();
        $scores = $this->getScore();

        $query = Property::with('images')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('properties.profile_id', '=', 'profiles_name.id');
            })
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('properties.city_id', '=', 'cities_name.id');
            })
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('properties.id', '=', 'scores.property_id');
            })
            ->select(
                'properties.*',
                'profiles_name.fullname',
                'property_types.name',
                'cities_name.city',
                'scores.score'
            );

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->get();
    }

    public function getList(){
        return DB::table('properties')
            ->select(
            'properties.id',
            'properties.title')
            ->get();
    }

    public function  getBusyCount($date){
        return DB::table('properties')
            ->selectRaw(
            "COUNT(properties.id) - count_busy_properties('$date'::date) as Free,
            count_busy_properties('$date'::date) as Busy")
            ->get();
    }

    public function getGroupByHostTypes()
    {
        return DB::table('properties')
            ->select(DB::raw("properties.host_type as name, COUNT(properties.id)"))
            ->groupBy('properties.host_type')
            ->get();
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

    public function getScore()
    {
        return DB::table('properties')
            ->select(
                'properties.id as property_id',
                DB::raw("COALESCE(AVG(feedbacks.score),0)::NUMERIC(2,1) as score"))
            ->leftJoin('bookings', 'bookings.property_id', '=', 'properties.id')
            ->leftJoin('feedbacks', 'feedbacks.booking_id', '=', 'bookings.id')
            ->groupBy('properties.id');
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
        $scores = $this->getScore();

        $query = DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoinSub($cities_name, 'cities_name', function ($join) {
                $join->on('properties.city_id', '=', 'cities_name.id');
            })
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('properties.id', '=', 'scores.property_id');
            })
            ->select(
                'properties.*',
                'property_types.name',
                'cities_name.city',
                'scores.score'
            )
            ->where('profile_id', '=', $id);

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function findById($id)
    {
        $scores = $this->getScore();

        return Property::with('images')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('profiles', 'properties.profile_id', '=', 'profiles.id')
            ->leftJoin('cities','properties.city_id', '=', 'cities.id')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->leftJoin('bookings', 'bookings.property_id', '=', 'properties.id')
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('properties.id', '=', 'scores.property_id');
            })
            ->select(
                'properties.*',
                'property_types.name',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city"),
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname"),
                'scores.score'
            )
            ->where('properties.id', '=', $id)
            ->first();
    }

    public function getHostTypes()
    {
        return $this->model::HOST_TYPES;
    }

    public function getFieldsInfoExcludeProfile(){
        $fields = $this->model::FIELDS_INFO;

        foreach($fields as $k => $v) {
            if($fields[$k]['key'] == 'fullname') {
                unset($fields[$k]);
            }
        }

        return array_values($fields);
    }
}
