<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HkiSubmission;
use Auth;

class HkiSubmissionController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function index()
    {
        $submissions = HkiSubmission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('dosen.hki.index', compact('submissions'));
    }

    public function create()
    {
        $jenisHki     = HkiSubmission::JENIS_HKI;
        $fakultasList = ['FTI','FEB','FKIP','FH','FIKES'];
        return view('dosen.hki.create', compact('jenisHki','fakultasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'              => 'required|string|max:255',
            'abstrak'            => 'required|string',
            'jenis_hki'         => 'required|in:Paten,HAKI,Non-Scopus / Hak Cipta Lainnya',
            'fakultas'           => 'required|in:FTI,FEB,FKIP,FH,FIKES',
            'tahun_pengajuan'    => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'tanggal_pengajuan'  => 'nullable|date',
            'nomor_pendaftaran'  => 'nullable|string|max:100',
        ]);

        HkiSubmission::create([
            'user_id'            => Auth::id(),
            'judul'              => $request->judul,
            'abstrak'            => $request->abstrak,
            'jenis_hki'          => $request->jenis_hki,
            'fakultas'           => $request->fakultas,
            'tahun_pengajuan'    => $request->tahun_pengajuan,
            'tanggal_pengajuan'  => $request->tanggal_pengajuan,
            'nomor_pendaftaran'  => $request->nomor_pendaftaran,
            'team_members'       => $request->team_members,
            'status'             => 'pending',
        ]);

        return redirect('/dosen/hki')
            ->with('success', 'Pengajuan HKI berhasil dikirim dan menunggu verifikasi LPPM.');
    }
}
