<?php


namespace App\Repositories;


use App\Models\PropertyType;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PropertyTypeRepository extends BaseRepository implements PropertyTypeRepositoryInterface
{
    protected $model = PropertyType::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $query = DB::table('property_types')
            ->leftJoin('properties', 'properties.property_type_id', '=', 'property_types.id')
            ->select(
                'property_types.*',
                DB::raw("COUNT(properties.id)"))
            ->groupBy('property_types.id');

        $query = $this->checkCountFilter($query, $filterItems);

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(10);
    }

    public function checkCountFilter($query = null, array &$filterItems = [])
    {
        for($i = 0; $i < count($filterItems); ++$i){
            if($filterItems[$i]['key'] == 'count'){
                $query = $query->having( DB::raw("COUNT(properties.id)"), $filterItems[$i]['comparator'], $filterItems[$i]['value']);
                unset($filterItems[$i]);
                break;
            }
        }
        return $query;
    }
}
