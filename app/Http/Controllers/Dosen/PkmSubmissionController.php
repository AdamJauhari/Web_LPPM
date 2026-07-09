<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PkmSubmission;
use App\Publikasi;
use Auth;

class PkmSubmissionController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function index()
    {
        $submissions = PkmSubmission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('dosen.pkm.index', compact('submissions'));
    }

    public function create()
    {
        $sumberDana   = ['Internal', 'Eksternal'];
        $semesterList = ['Ganjil', 'Genap'];
        $luaranList   = Publikasi::KATEGORI_LUARAN;
        $fakultasList = ['FTI','FEB','FKIP','FH','FIKES'];
        return view('dosen.pkm.create', compact('sumberDana','semesterList','luaranList','fakultasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'                  => 'required|string|max:255',
            'abstrak'                => 'required|string',
            'fakultas'               => 'required|in:FTI,FEB,FKIP,FH,FIKES',
            'semester'               => 'required|in:Ganjil,Genap',
            'tahun'                  => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'sumber_dana'            => 'required|in:Internal,Eksternal',
            'total_dana'             => 'required|numeric|min:0',
            'pelaksanaan'            => 'required|string',
            'luaran_jurnal'          => 'nullable|string',
            'sumber_dana_eksternal'  => 'nullable|string|max:255',
        ]);

        PkmSubmission::create([
            'user_id'               => Auth::id(),
            'nama_dosen'            => Auth::user()->name,
            'judul'                 => $request->judul,
            'abstrak'               => $request->abstrak,
            'team_members'          => $request->team_members,
            'fakultas'              => $request->fakultas,
            'semester'              => $request->semester,
            'tahun'                 => $request->tahun,
            'sumber_dana'           => $request->sumber_dana,
            'total_dana'            => $request->total_dana,
            'pelaksanaan'           => $request->pelaksanaan,
            'luaran_jurnal'         => $request->luaran_jurnal,
            'sumber_dana_eksternal' => $request->sumber_dana_eksternal,
            'status'                => 'pending',
        ]);

        return redirect('/dosen/pkm')
            ->with('success', 'Proposal PKM berhasil diajukan dan menunggu verifikasi LPPM.');
    }
}
