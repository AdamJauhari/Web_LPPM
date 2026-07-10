<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifikasiPenelitian extends Model
{
    protected $table = 'verifikasi_penelitian';
    protected $fillable = ['penelitian_id', 'user_id', 'catatan_verifikasi', 'tanggal_verifikasi'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
