<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvrDetails extends Model
{
    protected $guarded = [];
    protected $casts = [
        'cvr_data' => 'array'
    ];
}
