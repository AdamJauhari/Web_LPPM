<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    protected $table = 'penelitian';
    protected $fillable = [
        'dosen_id', 'universitas_id', 'klasifikasi', 'tahun',
        'dana', 'jumlah_dana', 'judul', 'status_proposal', 'status_verifikasi'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function pengajuanProposal()
    {
        return $this->hasMany(PengajuanProposal::class, 'penelitian_id');
    }

    public function verifikasi()
    {
        return $this->hasMany(VerifikasiPenelitian::class, 'penelitian_id');
    }

    public function hki()
    {
        return $this->hasOne(HkiModel::class, 'penelitian_id');
    }

    public function laporanSidang()
    {
        return $this->hasOne(LaporanSidang::class, 'penelitian_id');
    }

    public function laporanJurnal()
    {
        return $this->hasMany(LaporanJurnal::class, 'penelitian_id');
    }
}
