<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'nim_nip',
        'nidn', 'fakultas', 'jabatan_fungsional',
        'username', 'is_approved', 'approval_notes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =========================================================
    // Helper methods untuk cek role
    // =========================================================

    /** Apakah user ini Admin LPPM (Pusat)? */
    public function isAdminLppm(): bool
    {
        return $this->role === 'admin_lppm';
    }

    /** Apakah user ini Admin UPPM (Fakultas)? */
    public function isAdminUppm(): bool
    {
        return $this->role === 'admin_uppm';
    }

    /** Apakah user ini Dosen? */
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    /** Apakah user ini admin level manapun (lppm atau uppm)? */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin_lppm', 'admin_uppm']);
    }

    // =========================================================
    // Relasi
    // =========================================================

    /** Luaran publikasi milik dosen ini */
    public function publikasis()
    {
        return $this->hasMany(Publikasi::class);
    }
}
