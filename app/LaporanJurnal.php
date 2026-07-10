<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanJurnal extends Model
{
    protected $table = 'laporan_jurnal';
    protected $fillable = ['penelitian_id', 'kategori_jurnal', 'nama_jurnal', 'url_jurnal', 'file_bukti'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }
}
