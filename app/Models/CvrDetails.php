<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvrDetails extends Model
{
    protected $guarded = [];
    protected $casts = [
        'cvr_data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actionPoints()
    {
        return $this->hasMany(CvrActionPoints::class, 'cvr_id');
    }

    public function complaints()
    {
        return $this->hasMany(CvrComplaints::class, 'cvr_id');
    }
}
