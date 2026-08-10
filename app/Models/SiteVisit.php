<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'products'   => 'array',
        'categories' => 'array',
    ];
}
