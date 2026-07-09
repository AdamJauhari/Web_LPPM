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
        // Field SINTA baru
        'tahun_publikasi',
        'nama_jurnal',
        'volume_edisi',
        'doi',
        'sinta_id',
        'scopus_id',
        'garuda_id',
        'sumber',
        'status_verifikasi',
        'catatan_admin',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Kategori luaran jurnal yang tersedia
    const KATEGORI_LUARAN = [
        'Scopus Q1', 'Scopus Q2', 'Scopus Q3', 'Scopus Q4',
        'Sinta S1', 'Sinta S2', 'Sinta S3', 'Sinta S4', 'Sinta S5', 'Sinta S6',
        'Non-Sinta',
        'Prosiding Internasional',
        'Prosiding Nasional',
        'HKI - Paten',
        'HKI - Hak Cipta (HAKI)',
    ];

    // =====================
    // Relasi
    // =====================

    /** Dosen pemilik luaran ini */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Admin yang memverifikasi */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // =====================
    // Scopes
    // =====================

    public function scopeByFakultas($query, $fakultas)
    {
        return $query->whereHas('user', fn($q) => $q->where('fakultas', $fakultas));
    }

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'verified');
    }
}
