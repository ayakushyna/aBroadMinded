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

    const GENDER = [
        'undefined',
        'female',
        'male'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'active',
        'city_id'
    ];

    const FIELDS_INFO = [
        ['key'=> 'first_name',  'label' => 'First Name', 'comparator' => 'like', 'sortable' => true],
        ['key'=> 'last_name',   'label' => 'Last Name',  'comparator' => 'like', 'sortable' => true],
        ['key'=> 'gender',      'label' => 'Gender',     'comparator' => 'like', 'sortable' => true],
        ['key'=> 'city',        'label' => 'City',       'comparator' => 'like', 'sortable' => true],
        ['key'=> 'birthday',    'label' => 'Birthday',   'comparator' => '=',    'sortable' => true, 'type' => 'date'],
        ['key'=> 'active',      'label' => 'Active',     'comparator' => '=',    'sortable' => true, 'type' => 'bool'],
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

//    /**
//     * @return HasOne
//     */
//    public function user()
//    {
//        return $this->hasOne(User::class);
//    }
}
