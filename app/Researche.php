<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Researche extends Model
{
    protected $guarded = ['id'];
    // protected $fillable = ['title', 'description', 'author', 'date'];

    public function getDateAttribute()
    {
        $date = $this->attributes['date'] ?? $this->attributes['created_at'] ?? now();
        return Carbon::parse($date)->translatedFormat('d F Y');
    }
}
