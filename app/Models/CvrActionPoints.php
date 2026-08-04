<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CvrDetails;

class CvrActionPoints extends Model
{
    protected $guarded = [];

    public function cvrDetails()
    {
        return $this->belongsTo(CvrDetails::class, 'cvr_id');
    }
}
