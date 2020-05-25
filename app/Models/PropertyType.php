<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'property_types';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    const FIELDS_INFO = [
        ['key'=> 'name',   'label' => 'Name',   'comparator' => 'like',       'sortable' => true],
        ['key'=> 'count',  'label' => 'Count',  'comparator' => ['>=', '<='], 'sortable' => true],
    ];
    /**
     * @return HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
