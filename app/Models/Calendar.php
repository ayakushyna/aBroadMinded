<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    /**
     * @return BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
