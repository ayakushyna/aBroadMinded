<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calendars';

    /**
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'property_id'
    ];

    const FIELDS_INFO = [
        ['key'=> 'start_date', 'label' => 'Start Date',     'comparator' => '=',    'sortable' => true, 'type' => 'date'],
        ['key'=> 'end_date',   'label' => 'End Date',       'comparator' => '=',    'sortable' => true, 'type' => 'date'],
        ['key'=> 'property',   'label' => 'Property Title', 'comparator' => 'like', 'sortable' => true]
    ];

    /**
     * @return BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
