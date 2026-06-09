<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    protected $table = 'pelaksanaans';

    protected $fillable = [
        'user_id',
        'jenis_kegiatan',
        'judul',
        'deskripsi_singkat',
        'sumber_dana',
        'url',
    ];

    /**
     * Relasi: Pelaksanaan dimiliki oleh seorang User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
