<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class RegisterDosenController extends Controller
{
    /**
     * Daftar opsi fakultas yang tersedia di UCA.
     */
    const FAKULTAS = [
        'FTI'   => 'Fakultas Teknologi Informasi (FTI)',
        'FEB'   => 'Fakultas Ekonomi & Bisnis (FEB)',
        'FKIP'  => 'Fakultas Keguruan & Ilmu Pendidikan (FKIP)',
        'FH'    => 'Fakultas Hukum (FH)',
        'FIKES' => 'Fakultas Ilmu Kesehatan (FIKES)',
    ];

    /**
     * Daftar jabatan fungsional akademik.
     */
    const JABATAN = [
        'Tenaga Pengajar',
        'Asisten Ahli',
        'Lektor',
        'Lektor Kepala',
        'Guru Besar / Profesor',
    ];

    /**
     * Tampilkan form registrasi dosen.
     */
    public function showForm()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        $fakultasList = self::FAKULTAS;
        $jabatanList  = self::JABATAN;
        return view('auth.register_dosen', compact('fakultasList', 'jabatanList'));
    }

    /**
     * Proses pendaftaran dosen.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'nidn'               => 'required|string|max:20|unique:users,nidn',
            'email'              => 'required|email|max:255|unique:users,email',
            'fakultas'           => 'required|in:' . implode(',', array_keys(self::FAKULTAS)),
            'jabatan_fungsional' => 'required|in:' . implode(',', self::JABATAN),
            'password'           => 'required|min:8|confirmed',
        ], [
            'name.required'               => 'Nama lengkap wajib diisi.',
            'nidn.required'               => 'NIDN/NUPTK wajib diisi.',
            'nidn.unique'                 => 'NIDN ini sudah terdaftar.',
            'email.unique'                => 'Email ini sudah digunakan.',
            'fakultas.required'           => 'Fakultas wajib dipilih.',
            'jabatan_fungsional.required' => 'Jabatan fungsional wajib dipilih.',
            'password.min'                => 'Password minimal 8 karakter.',
            'password.confirmed'          => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'               => $request->name,
            'nidn'               => $request->nidn,
            'email'              => $request->email,
            'fakultas'           => $request->fakultas,
            'jabatan_fungsional' => $request->jabatan_fungsional,
            'password'           => bcrypt($request->password),
            'role'               => 'dosen',
            'is_approved'        => 0, // Memerlukan persetujuan admin LPPM
        ]);

        return redirect('/login')->with('success', 'Pendaftaran akun Dosen berhasil! Akun Anda saat ini berstatus PENDING dan memerlukan persetujuan (approval) dari Administrator LPPM sebelum dapat digunakan untuk login.');
    }

    /**
     * Redirect berdasarkan role setelah login.
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;
        if ($role === 'admin_lppm' || $role === 'admin_uppm') {
            return redirect('/admin/successlogin');
        }
        return redirect('/dosen/dashboard');
    }
}
