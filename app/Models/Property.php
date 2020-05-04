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

    const PRIMARY_FIELDS = [
        'title',
        'description',
        'address',
        'price',
        'host_type',
        'city',
        'owner',
        'property_type',
        'active',
    ];

    const SECONDARY_FIELDS = [
        'max_bedrooms',
        'max_beds',
        'max_guests',
        'air_condition',
        'children',
        'hair_dryer',
        'parties',
        'pets',
        'smoking',
        'tv',
        'wifi'
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
