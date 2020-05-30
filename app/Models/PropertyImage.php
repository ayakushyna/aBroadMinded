<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    protected $fillable = [
        'image_path',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
