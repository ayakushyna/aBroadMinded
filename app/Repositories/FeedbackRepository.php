<?php


namespace App\Repositories;


use App\Models\Feedback;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FeedbackRepository extends BaseRepository implements FeedbackRepositoryInterface
{
    protected $model = Feedback::class;

    public function all(array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();
        $properties_name = $this->getPropertiesName();

        $query = DB::table('feedbacks')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('feedbacks.booking_id', '=', 'profiles_name.booking_id');
            })
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('feedbacks.booking_id', '=', 'properties_name.booking_id');
            })
            ->select('feedbacks.*',
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
            ->leftJoin('bookings', 'properties.id', '=', 'bookings.property_id')
            ->select(
                'bookings.id as booking_id',
                'bookings.profile_id',
                'bookings.property_id',
                'properties.title as property'
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('feedbacks')
                    ->whereRaw('feedbacks.booking_id = bookings.id');
            });
    }

    public function getProfilesName()
    {
        return DB::table('profiles')
            ->leftJoin('bookings', 'profiles.id', '=', 'bookings.profile_id')
            ->select(
                'bookings.id as booking_id',
                'bookings.profile_id',
                'bookings.property_id',
                DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as fullname")
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('feedbacks')
                    ->whereRaw('feedbacks.booking_id = bookings.id');
            });
    }

    public function getFeedbacksByProfile($id, array $filterItems = [],array $sortItems = [])
    {
        $properties_name = $this->getPropertiesName();

        $query = DB::table('feedbacks')
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('feedbacks.booking_id', '=', 'properties_name.booking_id');
            })
            ->select('feedbacks.*',
                'properties_name.profile_id',
                'properties_name.property'
            )
            ->where('properties_name.profile_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function getFeedbacksByProperty($id, array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();

        $query = DB::table('feedbacks')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('feedbacks.booking_id', '=', 'profiles_name.booking_id');
            })
            ->select('feedbacks.*',
                'profiles_name.property_id',
                'profiles_name.fullname'
            )
            ->where('profiles_name.property_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
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
