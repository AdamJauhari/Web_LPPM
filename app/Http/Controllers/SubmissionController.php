<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class SubmissionController extends Controller
{
    // Form ajuan proposal penelitian
    public function createResearch()
    {
        if (!Auth::check()) return redirect('/login');
        return view('submissions.research');
    }

    // Simpan ajuan proposal
    public function storeResearch(Request $request)
    {
        if (!Auth::check()) return redirect('/login');

        $this->validate($request, [
            'title' => 'required|max:255',
            'abstract' => 'required',
            'research_type' => 'required',
        ]);

        DB::table('research_submissions')->insert([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'abstract' => $request->abstract,
            'research_type' => $request->research_type,
            'team_members' => $request->team_members,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/status-peninjauan')->with('success', 'Proposal penelitian berhasil diajukan!');
    }

    // Form ajuan jurnal
    public function createJournal()
    {
        if (!Auth::check()) return redirect('/login');
        return view('submissions.journal');
    }

    // Simpan ajuan jurnal
    public function storeJournal(Request $request)
    {
        if (!Auth::check()) return redirect('/login');

        $this->validate($request, [
            'title' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:10240',
            'journal_name' => 'required',
        ]);

        $fileName = null;
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/journals'), $fileName);
        }

        DB::table('journal_submissions')->insert([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file' => $fileName,
            'journal_name' => $request->journal_name,
            'authors' => $request->authors,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/status-peninjauan')->with('success', 'Jurnal penelitian berhasil diajukan!');
    }

    // Status peninjauan
    public function statusPeninjauan()
    {
        if (!Auth::check()) return redirect('/login');

        $proposals = DB::table('research_submissions')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $journals = DB::table('journal_submissions')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('submissions.status', compact('proposals', 'journals'));
    }

    // Jurnal saya
    public function jurnalSaya()
    {
        if (!Auth::check()) return redirect('/login');

        $journals = DB::table('journal_submissions')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('submissions.jurnal-saya', compact('journals'));
    }
}
