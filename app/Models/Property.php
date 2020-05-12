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
        'active',
        'city_id',
        'profile_id',
        'property_type_id',
    ];

    const FIELDS_INFO = [
        ['key'=> 'title', 'label' => 'Title', 'sortable' => true, 'comparator' => 'like'],
        ['key'=> 'description', 'label' => 'Description', 'sortable' => true, 'comparator' => 'like'],
        ['key'=> 'address', 'label' => 'Address', 'sortable' => true, 'comparator' => 'like'],
        ['key'=> 'price', 'label' => 'Price', 'sortable' => true, 'min' => 0, 'comparator' => '<='],
        ['key'=> 'host_type', 'label' => 'Host Type', 'sortable' => false, 'comparator' => 'like'],
        ['key'=> 'city', 'label' => 'City', 'sortable' => true, 'comparator' => 'like'],
        ['key'=> 'fullname', 'label' => 'Owner', 'sortable' => true, 'comparator' => 'like'],
        ['key'=> 'property_type', 'label' => 'Property Type', 'sortable' => false, 'comparator' => 'like'],
        ['key'=> 'active', 'label' => 'Active', 'sortable' => false, 'comparator' => '='],
        ['key'=> 'max_bedrooms','label' => 'Max Bedrooms', 'comparator' => '>=', 'min' => 0, 'secondary' => true],
        ['key'=> 'max_beds', 'label' => 'Max Beds', 'comparator' => '>=', 'min' => 0, 'secondary' => true],
        ['key'=> 'max_guests', 'label' => 'Max Guests', 'comparator' => '>=', 'min' => 0, 'secondary' => true],
        ['key'=> 'air_condition', 'label' => 'Air Condition', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'children', 'label' => 'Children', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'hair_dryer', 'label' => 'Hair Dryer', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'parties', 'label' => 'Parties', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'pets', 'label' => 'Pets', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'smoking', 'label' => 'Smoking', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'tv', 'label' => 'TV', 'comparator' => '=', 'secondary' => true],
        ['key'=> 'wifi', 'label' => 'Wi-Fi', 'comparator' => '=', 'secondary' => true],
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
    public function owner()
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
}
