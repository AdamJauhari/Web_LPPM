<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publikasi;
use Auth;

class DataPublikasiController extends Controller
{
    /**
     * Tampilkan daftar publikasi milik user yang login.
     * Admin melihat semua data.
     */
    public function index()
    {
        if (!Auth::check()) return redirect('/login');

        $user = Auth::user();

        if ($user->role === 'admin') {
            $publikasis = Publikasi::with('user')->orderBy('id', 'desc')->paginate(10);
        } else {
            $publikasis = Publikasi::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        }

        return view('data-publikasi.index', compact('publikasis'));
    }

    /**
     * Tampilkan form tambah publikasi.
     */
    public function create()
    {
        if (!Auth::check()) return redirect('/login');

        return view('data-publikasi.create');
    }

    /**
     * Simpan data publikasi baru.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) return redirect('/login');

        $request->validate([
            'judul'              => 'required|max:255',
            'abstrak'            => 'required',
            'jenis_publikasi'    => 'required|in:Jurnal,Prosiding',
            'kategori_reputasi'  => 'required|max:255',
            'url_jurnal'         => 'nullable|url|max:255',
            'url_repository'     => 'nullable|url|max:255',
        ]);

        Publikasi::create([
            'user_id'            => Auth::id(),
            'judul'              => $request->judul,
            'abstrak'            => $request->abstrak,
            'jenis_publikasi'    => $request->jenis_publikasi,
            'kategori_reputasi'  => $request->kategori_reputasi,
            'url_jurnal'         => $request->url_jurnal,
            'url_repository'     => $request->url_repository,
        ]);

        return redirect('/data-publikasi')->with('success', 'Data Publikasi berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit publikasi.
     */
    public function edit($id)
    {
        if (!Auth::check()) return redirect('/login');

        $publikasi = Publikasi::findOrFail($id);
        $user = Auth::user();

        // Hanya pemilik atau admin yang bisa edit
        if ($user->role != 'admin' && $publikasi->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('data-publikasi.edit', compact('publikasi'));
    }

    /**
     * Update data publikasi.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) return redirect('/login');

        $publikasi = Publikasi::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' && $publikasi->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'judul'              => 'required|max:255',
            'abstrak'            => 'required',
            'jenis_publikasi'    => 'required|in:Jurnal,Prosiding',
            'kategori_reputasi'  => 'required|max:255',
            'url_jurnal'         => 'nullable|url|max:255',
            'url_repository'     => 'nullable|url|max:255',
        ]);

        $publikasi->update([
            'judul'              => $request->judul,
            'abstrak'            => $request->abstrak,
            'jenis_publikasi'    => $request->jenis_publikasi,
            'kategori_reputasi'  => $request->kategori_reputasi,
            'url_jurnal'         => $request->url_jurnal,
            'url_repository'     => $request->url_repository,
        ]);

        return redirect('/data-publikasi')->with('success', 'Data Publikasi berhasil diperbarui!');
    }

    /**
     * Hapus data publikasi.
     */
    public function destroy($id)
    {
        if (!Auth::check()) return redirect('/login');

        $publikasi = Publikasi::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' && $publikasi->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $publikasi->delete();

        return redirect('/data-publikasi')->with('success', 'Data Publikasi berhasil dihapus!');
    }
}
