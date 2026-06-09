<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $table = 'publikasis';

    protected $fillable = [
        'user_id',
        'judul',
        'abstrak',
        'jenis_publikasi',
        'kategori_reputasi',
        'url_jurnal',
        'url_repository',
    ];

    /**
     * Relasi: Publikasi dimiliki oleh seorang User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
