<?php


namespace App\Repositories;


use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    protected $model = Booking::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();
        $properties_name = $this->getPropertiesName();

        $query = DB::table('bookings')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('bookings.profile_id', '=', 'profiles_name.id');
            })
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('bookings.property_id', '=', 'properties_name.id');
            })
            ->select('bookings.*',
                'profiles_name.fullname',
                'properties_name.property'
            );

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(10);
    }

    public function getPropertiesName()
    {
        return DB::table('properties')
            ->select(
                'properties.id',
                'properties.title as property'
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('bookings')
                    ->whereRaw('bookings.property_id = properties.id');
            });
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
                    ->from('bookings')
                    ->whereRaw('bookings.profile_id = profiles.id');
            });
    }

    public function getBookingsByProfile($id, array $filterItems = [],array $sortItems = [])
    {
        $properties_name = $this->getPropertiesName();

        $query = DB::table('bookings')
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('bookings.property_id', '=', 'properties_name.id');
            })
            ->select('bookings.*',
                'properties_name.property'
            )
            ->where('profile_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function getBookingsByProperty($id, array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();

        $query = DB::table('bookings')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('bookings.profile_id', '=', 'profiles_name.id');
            })
            ->select('bookings.*',
                'profiles_name.fullname'
            )
            ->where('property_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function findById($id)
    {
        return DB::table('bookings')
            ->leftJoin('profiles', 'bookings.profile_id', '=', 'profiles.id')
            ->leftJoin('properties', 'bookings.property_id', '=', 'properties.id')
            ->select(
                'bookings.*',
                'properties.title as property',
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname"),
            )
            ->where('bookings.id', '=', $id)
            ->first();
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

    public function getFieldsInfoExcludeProperty()
    {
        $fields = $this->model::FIELDS_INFO;

        foreach ($fields as $k => $v) {
            if ($fields[$k]['key'] == 'property') {
                unset($fields[$k]);
            }
        }

        return array_values($fields);
    }
}
