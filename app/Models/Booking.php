<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'adults',
        'children',
        'price',
        'status',
        'profile_id',
        'property_id'
    ];

    const FIELDS_INFO = [
        ['key'=> 'property',   'label' => 'Property Title', 'comparator' => 'like',        'sortable' => true],
        ['key'=> 'start_date', 'label' => 'Start Date',     'comparator' => '=',           'sortable' => true, 'type' => 'date'],
        ['key'=> 'end_date',   'label' => 'End Date',       'comparator' => '=',           'sortable' => true, 'type' => 'date'],
        ['key'=> 'adults',     'label' => 'Adults',         'comparator' => ['>=', '<='],  'sortable' => true,  'min' => 0, 'max' => 10],
        ['key'=> 'children',   'label' => 'Children',       'comparator' => ['>=', '<='],  'sortable' => true,  'min' => 0, 'max' => 10],
        ['key'=> 'price',      'label' => 'Price',          'comparator' => ['>=', '<='],  'sortable' => true,  'min' => 0, 'max' => 10],
        ['key'=> 'fullname',   'label' => 'Client',         'comparator' => 'like',        'sortable' => true],
        ['key'=> 'status',     'label' => 'Status',         'comparator' => 'like',        'sortable' => true]
    ];

    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
