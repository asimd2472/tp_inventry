<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteVisit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'products'     => 'array',
        'categories'   => 'array',
        'lead_status'  => 'array',
        'drop_reasons' => 'array',
        'follow_up'    => 'boolean',
        'follow_update'=> 'date',
        'visit_date'   => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
