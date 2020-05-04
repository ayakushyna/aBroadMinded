<?php


namespace App\Repositories;


use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    protected $model = Property::class;

    public function all()
    {
        return DB::table('properties')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('profiles', 'properties.profile_id', '=', 'profiles.id')
            ->leftJoin('cities', 'properties.city_id', '=', 'cities.id')
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->select('properties.*',
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as owner"),
                'property_types.name as property_type',
                DB::raw("CONCAT(cities.name, ', ', states.name, ', ', countries.name) as city")
            )
            ->paginate(5);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getPrimaryFields()
    {
        return $this->model::PRIMARY_FIELDS;
    }

    public function getSecondaryFields()
    {
        return $this->model::SECONDARY_FIELDS;
    }

    public function getHostTypes(){
        return $this->model::HOST_TYPES;
    }
}
