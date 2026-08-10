<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteVisit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'products'   => 'array',
        'categories' => 'array',
        'follow_up'  => 'boolean',
        'visit_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
