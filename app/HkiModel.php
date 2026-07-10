<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HkiModel extends Model
{
    protected $table = 'hki';
    protected $fillable = ['penelitian_id', 'jenis_hki', 'judul_hki', 'nomor_pendaftaran', 'file_sertifikat'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }
}
