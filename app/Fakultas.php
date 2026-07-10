<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $fillable = ['nama_fakultas', 'nama_dekan', 'nama_dosen', 'no_hp'];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id');
    }
}
