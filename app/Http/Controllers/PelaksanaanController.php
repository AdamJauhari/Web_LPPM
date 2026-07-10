<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelaksanaan;
use Auth;

class PelaksanaanController extends Controller
{
    /**
     * Tampilkan daftar pelaksanaan milik user yang login.
     * Admin melihat semua data.
     */
    public function index()
    {
        if (!Auth::check()) return redirect('/login');

        $user = Auth::user();

        if ($user->role === 'admin') {
            $pelaksanaans = Pelaksanaan::with('user')->orderBy('id', 'desc')->paginate(10);
        } else {
            $pelaksanaans = Pelaksanaan::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        }

        return view('data-pelaksanaan.index', compact('pelaksanaans'));
    }

    /**
     * Tampilkan form tambah pelaksanaan.
     */
    public function create()
    {
        if (!Auth::check()) return redirect('/login');

        return view('data-pelaksanaan.create');
    }

    /**
     * Simpan data pelaksanaan baru.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) return redirect('/login');

        $request->validate([
            'jenis_kegiatan'   => 'required|in:Penelitian,Pengabdian',
            'judul'            => 'required|max:255',
            'deskripsi_singkat' => 'required',
            'sumber_dana'      => 'required|max:255',
            'url'              => 'nullable|url|max:255',
        ]);

        Pelaksanaan::create([
            'user_id'           => Auth::id(),
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'judul'             => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'sumber_dana'       => $request->sumber_dana,
            'url'               => $request->url,
        ]);

        return redirect('/data-pelaksanaan')->with('success', 'Data Pelaksanaan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit pelaksanaan.
     */
    public function edit($id)
    {
        if (!Auth::check()) return redirect('/login');

        $pelaksanaan = Pelaksanaan::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' && $pelaksanaan->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('data-pelaksanaan.edit', compact('pelaksanaan'));
    }

    /**
     * Update data pelaksanaan.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) return redirect('/login');

        $pelaksanaan = Pelaksanaan::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' && $pelaksanaan->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'jenis_kegiatan'   => 'required|in:Penelitian,Pengabdian',
            'judul'            => 'required|max:255',
            'deskripsi_singkat' => 'required',
            'sumber_dana'      => 'required|max:255',
            'url'              => 'nullable|url|max:255',
        ]);

        $pelaksanaan->update([
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'judul'             => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'sumber_dana'       => $request->sumber_dana,
            'url'               => $request->url,
        ]);

        return redirect('/data-pelaksanaan')->with('success', 'Data Pelaksanaan berhasil diperbarui!');
    }

    /**
     * Hapus data pelaksanaan.
     */
    public function destroy($id)
    {
        if (!Auth::check()) return redirect('/login');

        $pelaksanaan = Pelaksanaan::findOrFail($id);
        $user = Auth::user();

        if ($user->role != 'admin' && $pelaksanaan->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $pelaksanaan->delete();

        return redirect('/data-pelaksanaan')->with('success', 'Data Pelaksanaan berhasil dihapus!');
    }
}
