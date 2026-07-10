<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $fillable = ['nama_prodi', 'nama_koordinator', 'dosen', 'fakultas_id', 'no_hp', 'email'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function dosenList()
    {
        return $this->hasMany(Dosen::class, 'id_prodi');
    }
}
