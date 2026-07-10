<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanProposal extends Model
{
    protected $table = 'pengajuan_proposal';
    protected $fillable = ['penelitian_id', 'user_id', 'catatan_pengajuan', 'status', 'tanggal_ajuan'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
