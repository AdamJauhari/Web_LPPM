<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Researche extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getRingkasanAutoAttribute()
    {
        if (!empty($this->ringkasan)) {
            return $this->ringkasan;
        }
        return \Illuminate\Support\Str::limit(strip_tags($this->body), 120);
    }

    public function getDateAttribute()
    {
        $date = $this->attributes['tanggal'] ?? $this->attributes['date'] ?? $this->attributes['created_at'] ?? now();
        return Carbon::parse($date)->translatedFormat('d F Y');
    }
}
