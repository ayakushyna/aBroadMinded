<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'gender',
        'birthday',
        'active',
        'city_id'
    ];

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
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

    /**
     * @return HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
