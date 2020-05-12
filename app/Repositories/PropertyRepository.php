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
        $query = DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('profiles', 'properties.profile_id', '=', 'profiles.id')
            ->leftJoin('cities', 'properties.city_id', '=', 'cities.id')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->select('properties.*',
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname"),
                'property_types.name as property_type',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city")
            );
        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);
        return $query->paginate(5);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getFieldsInfo()
    {
        return $this->model::FIELDS_INFO;
    }


    public function getHostTypes(){
        return $this->model::HOST_TYPES;
    }
}
