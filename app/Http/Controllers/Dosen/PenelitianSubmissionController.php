<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ResearchSubmission;
use App\Publikasi;
use Auth;

class PenelitianSubmissionController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    /** Daftar pengajuan penelitian milik dosen ini */
    public function index()
    {
        $submissions = ResearchSubmission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('dosen.penelitian.index', compact('submissions'));
    }

    /** Form pengajuan baru */
    public function create()
    {
        $sumberDana   = ResearchSubmission::SUMBER_DANA;
        $semesterList = ResearchSubmission::SEMESTER;
        $kategoriList = Publikasi::KATEGORI_LUARAN;
        $fakultasList = ['FTI','FEB','FKIP','FH','FIKES'];
        return view('dosen.penelitian.create', compact('sumberDana','semesterList','kategoriList','fakultasList'));
    }

    /** Simpan pengajuan */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'abstract'        => 'required|string',
            'research_type'   => 'required|string',
            'fakultas'        => 'required|in:FTI,FEB,FKIP,FH,FIKES',
            'semester'        => 'required|in:Ganjil,Genap',
            'tahun'           => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'sumber_dana'     => 'required|in:Internal,Eksternal',
            'total_dana'      => 'required|numeric|min:0',
            'kategori_luaran' => 'nullable|string',
        ]);

        ResearchSubmission::create([
            'user_id'         => Auth::id(),
            'nama_dosen'      => Auth::user()->name,
            'title'           => $request->title,
            'abstract'        => $request->abstract,
            'research_type'   => $request->research_type,
            'team_members'    => $request->team_members,
            'fakultas'        => $request->fakultas,
            'semester'        => $request->semester,
            'tahun'           => $request->tahun,
            'sumber_dana'     => $request->sumber_dana,
            'total_dana'      => $request->total_dana,
            'kategori_luaran' => $request->kategori_luaran,
            'status'          => 'pending',
        ]);

        return redirect('/dosen/penelitian')
            ->with('success', 'Proposal penelitian berhasil diajukan dan menunggu verifikasi LPPM.');
    }
}
