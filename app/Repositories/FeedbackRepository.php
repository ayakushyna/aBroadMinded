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
                $join->on('feedbacks.profile_id', '=', 'profiles_name.id');
            })
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('feedbacks.property_id', '=', 'properties_name.id');
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
            ->select(
                'properties.id',
                'properties.title as property'
            )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('feedbacks')
                    ->whereRaw('feedbacks.property_id = properties.id');
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
                    ->from('feedbacks')
                    ->whereRaw('feedbacks.profile_id = profiles.id');
            });
    }

    public function getFeedbacksByProfile($id, array $filterItems = [],array $sortItems = [])
    {
        $properties_name = $this->getPropertiesName();

        $query = DB::table('feedbacks')
            ->leftJoinSub($properties_name, 'properties_name', function ($join) {
                $join->on('feedbacks.property_id', '=', 'properties_name.id');
            })
            ->select('feedbacks.*',
                'properties_name.property'
            )
            ->where('profile_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function getFeedbacksByProperty($id, array $filterItems = [],array $sortItems = [])
    {
        $profiles_name = $this->getProfilesName();

        $query = DB::table('feedbacks')
            ->leftJoinSub($profiles_name, 'profiles_name', function ($join) {
                $join->on('feedbacks.profile_id', '=', 'profiles_name.id');
            })
            ->select('feedbacks.*',
                'profiles_name.fullname'
            )
            ->where('property_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }
}
