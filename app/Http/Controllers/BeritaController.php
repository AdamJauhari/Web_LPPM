<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Daftar berita publik (dengan filter kategori opsional)
     */
    public function index(Request $request)
    {
        $query = Berita::published()->orderBy('tanggal', 'desc');

        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'LIKE', "%{$q}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$q}%");
            });
        }

        $beritas = $query->paginate(9)->appends($request->query());
        $kategoriList = Berita::KATEGORI;

        return view('berita.index', compact('beritas', 'kategoriList'));
    }

    /**
     * Detail satu berita berdasarkan slug
     */
    public function show($slug)
    {
        $berita = Berita::published()->where('slug', $slug)->firstOrFail();

        // Berita terkait (kategori sama, bukan yang sedang ditampilkan)
        $terkait = Berita::published()
            ->where('kategori', $berita->kategori)
            ->where('id', '!=', $berita->id)
            ->orderBy('tanggal', 'desc')
            ->limit(3)
            ->get();

        return view('berita.show', compact('berita', 'terkait'));
    }

    // ================================================================
    // ADMIN SSR (via web routes dengan session)
    // ================================================================

    /**
     * List berita di admin panel SSR
     */
    public function adminIndex()
    {
        $beritas = Berita::orderBy('tanggal', 'desc')->paginate(10);
        $stats = [
            'total'     => Berita::count(),
            'published' => Berita::where('status', 'published')->count(),
            'draft'     => Berita::where('status', 'draft')->count(),
        ];
        return view('admin.adm_berita', compact('beritas', 'stats'));
    }

    /**
     * Form tambah berita (admin SSR)
     */
    public function adminCreate()
    {
        $kategoriList = Berita::KATEGORI;
        return view('admin.berita_create', compact('kategoriList'));
    }

    /**
     * Simpan berita baru (admin SSR)
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'judul'    => 'required|max:255',
            'konten'   => 'required',
            'kategori' => 'required|in:' . implode(',', Berita::KATEGORI),
            'tanggal'  => 'required|date',
            'status'   => 'required|in:draft,published',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarPath = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/berita'), $gambarPath);
        }

        Berita::create([
            'judul'     => $request->judul,
            'slug'      => Str::slug($request->judul) . '-' . time(),
            'ringkasan' => $request->ringkasan,
            'konten'    => $request->konten,
            'gambar'    => $gambarPath,
            'kategori'  => $request->kategori,
            'status'    => $request->status,
            'tanggal'   => $request->tanggal,
            'penulis'   => $request->penulis,
        ]);

        return redirect('/admin/successlogin/berita')->with('status', 'Berita berhasil ditambahkan!');
    }

    /**
     * Form edit berita (admin SSR)
     */
    public function adminEdit($id)
    {
        $berita = Berita::findOrFail($id);
        $kategoriList = Berita::KATEGORI;
        return view('admin.berita_edit', compact('berita', 'kategoriList'));
    }

    /**
     * Update berita (admin SSR)
     */
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required|max:255',
            'konten'   => 'required',
            'kategori' => 'required|in:' . implode(',', Berita::KATEGORI),
            'tanggal'  => 'required|date',
            'status'   => 'required|in:draft,published',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        $berita = Berita::findOrFail($id);
        $data = [
            'judul'     => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten'    => $request->konten,
            'kategori'  => $request->kategori,
            'status'    => $request->status,
            'tanggal'   => $request->tanggal,
            'penulis'   => $request->penulis,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarPath = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/berita'), $gambarPath);
            $data['gambar'] = $gambarPath;
        }

        $berita->update($data);

        return redirect('/admin/successlogin/berita')->with('status', 'Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita (admin SSR)
     */
    public function adminDestroy($id)
    {
        Berita::findOrFail($id)->delete();
        return redirect('/admin/successlogin/berita')->with('status', 'Berita berhasil dihapus!');
    }
}
