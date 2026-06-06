<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Publication extends Model
{
    protected $guarded = ['id'];

    public function getDateAttribute()
    {
        $date = $this->attributes['date'] ?? $this->attributes['created_at'] ?? now();
        return Carbon::parse($date)->translatedFormat('d F Y');
    }
}
