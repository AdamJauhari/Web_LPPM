<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'kategori',
        'status',
        'tanggal',
        'penulis',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    const KATEGORI = ['Umum', 'Penelitian', 'Pengabdian', 'Akademik', 'Kegiatan', 'Pengumuman'];

    // Auto-generate slug dari judul
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul) . '-' . time();
            }
        });
    }

    // Scope hanya berita yang published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope filter per kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Ambil ringkasan otomatis jika tidak ada
    public function getRingkasanAutoAttribute()
    {
        return $this->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($this->konten), 200);
    }
}
