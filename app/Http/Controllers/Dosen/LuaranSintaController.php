<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Publikasi;
use App\User;
use Auth;

class LuaranSintaController extends Controller
{
    public function __construct()
    {
        // Pastikan yang akses adalah user yang sudah login
        $this->middleware('auth');
    }

    /**
     * Daftar luaran milik dosen yang sedang login.
     */
    public function index(Request $request)
    {
        $query = Publikasi::where('user_id', Auth::id());

        if ($request->filled('jenis')) {
            $query->where('jenis_publikasi', $request->jenis);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun_publikasi', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $luarans = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoriList = Publikasi::KATEGORI_LUARAN;

        return view('dosen.luaran-sinta.index', compact('luarans', 'kategoriList'));
    }

    /**
     * Form input luaran baru secara manual.
     */
    public function create()
    {
        $kategoriList = Publikasi::KATEGORI_LUARAN;
        return view('dosen.luaran-sinta.create', compact('kategoriList'));
    }

    /**
     * Simpan luaran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'              => 'required|string|max:255',
            'abstrak'            => 'required|string',
            'jenis_publikasi'    => 'required|in:Jurnal,Prosiding,Buku,HKI',
            'kategori_reputasi'  => 'required|string',
            'tahun_publikasi'    => 'required|integer|min:2000|max:' . date('Y'),
            'nama_jurnal'        => 'nullable|string|max:255',
            'volume_edisi'       => 'nullable|string|max:100',
            'doi'                => 'nullable|string|max:255',
            'url_jurnal'         => 'nullable|url|max:255',
            'url_repository'     => 'nullable|url|max:255',
        ]);

        Publikasi::create([
            'user_id'           => Auth::id(),
            'judul'             => $request->judul,
            'abstrak'           => $request->abstrak,
            'jenis_publikasi'   => $request->jenis_publikasi,
            'kategori_reputasi' => $request->kategori_reputasi,
            'tahun_publikasi'   => $request->tahun_publikasi,
            'nama_jurnal'       => $request->nama_jurnal,
            'volume_edisi'      => $request->volume_edisi,
            'doi'               => $request->doi,
            'url_jurnal'        => $request->url_jurnal,
            'url_repository'    => $request->url_repository,
            'sumber'            => 'manual',
            'status_verifikasi' => 'pending',
        ]);

        return redirect('/dosen/luaran-sinta')
            ->with('success', 'Luaran berhasil ditambahkan dan menunggu verifikasi admin.');
    }

    /**
     * Form edit luaran (hanya jika masih pending).
     */
    public function edit($id)
    {
        $luaran = Publikasi::where('user_id', Auth::id())->findOrFail($id);

        if ($luaran->status_verifikasi !== 'pending') {
            return redirect('/dosen/luaran-sinta')
                ->with('error', 'Luaran yang sudah diverifikasi tidak dapat diedit.');
        }

        $kategoriList = Publikasi::KATEGORI_LUARAN;
        return view('dosen.luaran-sinta.edit', compact('luaran', 'kategoriList'));
    }

    /**
     * Update luaran.
     */
    public function update(Request $request, $id)
    {
        $luaran = Publikasi::where('user_id', Auth::id())->findOrFail($id);

        if ($luaran->status_verifikasi !== 'pending') {
            return redirect('/dosen/luaran-sinta')
                ->with('error', 'Luaran yang sudah diverifikasi tidak dapat diubah.');
        }

        $request->validate([
            'judul'              => 'required|string|max:255',
            'abstrak'            => 'required|string',
            'jenis_publikasi'    => 'required|in:Jurnal,Prosiding,Buku,HKI',
            'kategori_reputasi'  => 'required|string',
            'tahun_publikasi'    => 'required|integer|min:2000|max:' . date('Y'),
            'nama_jurnal'        => 'nullable|string|max:255',
            'volume_edisi'       => 'nullable|string|max:100',
            'doi'                => 'nullable|string|max:255',
            'url_jurnal'         => 'nullable|url|max:255',
            'url_repository'     => 'nullable|url|max:255',
        ]);

        $luaran->update($request->only([
            'judul', 'abstrak', 'jenis_publikasi', 'kategori_reputasi',
            'tahun_publikasi', 'nama_jurnal', 'volume_edisi', 'doi',
            'url_jurnal', 'url_repository',
        ]));

        return redirect('/dosen/luaran-sinta')
            ->with('success', 'Luaran berhasil diperbarui.');
    }

    /**
     * Hapus luaran (hanya jika masih pending).
     */
    public function destroy($id)
    {
        $luaran = Publikasi::where('user_id', Auth::id())->findOrFail($id);

        if ($luaran->status_verifikasi !== 'pending') {
            return redirect('/dosen/luaran-sinta')
                ->with('error', 'Luaran yang sudah diverifikasi tidak dapat dihapus.');
        }

        $luaran->delete();
        return redirect('/dosen/luaran-sinta')
            ->with('success', 'Luaran berhasil dihapus.');
    }
}
