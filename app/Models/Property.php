<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

    const HOST_TYPES = [
        'entire place',
        'private room',
        'shared room'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'address',
        'price',
        'host_type',
        'air_condition',
        'children',
        'hair_dryer',
        'parties',
        'pets',
        'smoking',
        'tv',
        'wifi',
        'max_bedrooms',
        'max_beds',
        'max_guests',
        'city_id',
        'profile_id',
        'property_type_id',
    ];

    const FIELDS_INFO = [
        ['key'=> 'title',         'label' => 'Title',         'comparator' => 'like',       'sortable' => true],
        ['key'=> 'description',   'label' => 'Description',   'comparator' => 'like',       'sortable' => true],
        ['key'=> 'address',       'label' => 'Address',       'comparator' => 'like',       'sortable' => true],
        ['key'=> 'host_type',     'label' => 'Host Type',     'comparator' => 'like',       'sortable' => true],
        ['key'=> 'city',          'label' => 'City',          'comparator' => 'like',       'sortable' => true],
        ['key'=> 'fullname',      'label' => 'Owner',         'comparator' => 'like',       'sortable' => true],
        ['key'=> 'name',          'label' => 'Property Type', 'comparator' => 'like',       'sortable' => true],
        ['key'=> 'score',         'label' => 'Score',         'comparator' => ['>=', '<='], 'sortable' => true,  'min' => 0, 'max' => 5],
        ['key'=> 'max_bedrooms',  'label' => 'Bedrooms',      'comparator' => ['>=', '<='], 'secondary' => true, 'min' => 1, 'max' => 20],
        ['key'=> 'max_beds',      'label' => 'Beds',          'comparator' => ['>=', '<='], 'secondary' => true, 'min' => 1, 'max' => 20],
        ['key'=> 'max_guests',    'label' => 'Max Guests',    'comparator' => ['>=', '<='], 'secondary' => true, 'min' => 1, 'max' => 20],
        ['key'=> 'price',         'label' => 'Price',         'comparator' => ['>=', '<='], 'sortable' => true,  'min' => 1, 'max' => 100000],
        ['key'=> 'air_condition', 'label' => 'Air Condition', 'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'children',      'label' => 'Children',      'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'hair_dryer',    'label' => 'Hair Dryer',    'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'parties',       'label' => 'Parties',       'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'pets',          'label' => 'Pets',          'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'smoking',       'label' => 'Smoking',       'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'tv',            'label' => 'TV',            'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
        ['key'=> 'wifi',          'label' => 'Wi-Fi',         'comparator' => '=',          'secondary' => true, 'type' => 'bool'],
//        ['key'=> 'active',        'label' => 'Active',        'comparator' => '=',          'sortable' => true, 'type' => 'bool'],
        ['key'=> 'date_range',    'label' => 'Date Range',    'comparator' => 'check_dates','type' => 'date_range'],
    ];

    /**
     * @return BelongsTo
     */
    public function property_type()
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * @return HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

}
