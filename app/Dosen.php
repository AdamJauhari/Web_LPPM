<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $fillable = [
        'user_id', 'nama_dosen', 'nidn', 'nupk', 'pangkat_jabatan',
        'id_prodi', 'dosen_luaran', 'no_hp', 'sk_dosen'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function penelitianList()
    {
        return $this->hasMany(Penelitian::class, 'dosen_id');
    }
}
