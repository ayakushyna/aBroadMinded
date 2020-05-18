<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * @var array
     */
    protected $fillable = [
        'score',
        'title',
        'body',
        'profile_id',
        'property_id'
    ];

    const FIELDS_INFO = [
        ['key'=> 'title',    'label' => 'Title',          'comparator' => 'like',       'sortable' => true],
        ['key'=> 'body',     'label' => 'Body',           'comparator' => 'like',       'sortable' => true],
        ['key'=> 'score',    'label' => 'Score',          'comparator' => ['>=', '<='], 'sortable' => true,  'min' => 0, 'max' => 5],
        ['key'=> 'fullname', 'label' => 'User',           'comparator' => 'like',       'sortable' => true],
        ['key'=> 'property', 'label' => 'Property Title', 'comparator' => 'like',       'sortable' => true]
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
