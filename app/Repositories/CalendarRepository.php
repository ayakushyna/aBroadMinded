<?php


namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Calendar;
use App\Repositories\Interfaces\CalendarRepositoryInterface;

class CalendarRepository extends BaseRepository implements CalendarRepositoryInterface
{
    protected $model = Calendar::class;

    public function getCalendarsByProperty($id, array $filterItems = [],array $sortItems = [])
    {
        $query = DB::table('available_date_ranges')
            ->select('available_date_ranges.*')
            ->where('property_id', '=', $id);;

        $query = $this->applyFilter($query, $filterItems);
        $query = $this->applySorting($query, $sortItems);

        return $query->paginate(5);
    }

    public function getDates($id)
    {
        return DB::table('available_date_ranges')
            ->select('available_date_ranges.start_date', 'available_date_ranges.end_date')
            ->where('property_id', '=', $id)
            ->get();
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
