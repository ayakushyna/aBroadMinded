<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    /**
     * @return HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
