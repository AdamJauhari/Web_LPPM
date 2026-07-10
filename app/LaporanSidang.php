<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanSidang extends Model
{
    protected $table = 'laporan_sidang';
    protected $fillable = ['penelitian_id', 'tanggal_sidang', 'berita_acara_file', 'hasil_sidang'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }
}
