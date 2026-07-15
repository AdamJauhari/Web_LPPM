<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommunityService;
use Illuminate\Support\Str;

class PengabdianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CommunityService::where('status', 'published')->orderBy('tanggal', 'desc');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'LIKE', "%{$q}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$q}%");
            });
        }

        $comserv = $query->paginate(9)->appends($request->query());
        
        $terkait = CommunityService::where('status', 'published')->orderBy('tanggal', 'desc')->take(4)->get();
        $kategoriList = CommunityService::where('status', 'published')->whereNotNull('kategori')->distinct()->pluck('kategori');
        
        return view('/pengabdian/index', compact('comserv', 'terkait', 'kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengabdian/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|min:2',
            'description' => 'required|min:2',
            'author' => 'required|min:3',
            'date' => 'required|date_format:Y-m-d'
        ]);

        $imgName = null;

        if($request->thumbnail) {
            // $imgName = $request->thumbnail->getClientOriginalName() . '-' . time() . '.' . $request->thumbnail->extension();
            $imgName = $request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path('img/pengabdian'), $imgName);
        }

        CommunityService::create([
            'title' => $request->title,
            'slug'=> Str::slug($request->title, '-'),
            'description' => $request->description,
            'author' => $request->author,
            'date' => $request->date,
            'thumbnail' => $imgName
        ]);
        // CommunityService::create($request->all());

        return redirect('/admin/successlogin/pengabdian')->with('status', 'Berita Pengabdian Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $comserv = CommunityService::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $terkait = CommunityService::where('status', 'published')
                    ->where('id', '!=', $comserv->id)
                    ->orderBy('tanggal', 'desc')
                    ->take(4)->get();
                    
        return view('pengabdian/show', compact('comserv', 'terkait'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityService $comserv)
    {
        return view('pengabdian/edit', compact('comserv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityService $comserv)
    {
        $request->validate([
            'title' => 'required|max:255|min:2',
            'description' => 'required|min:2',
            'author' => 'required|min:3',
            'date' => 'required|date_format:Y-m-d'
        ]);
        
        // $imgName = null;

        if($request->thumbnail) {
            // $imgName = $request->thumbnail->getClientOriginalName() . '-' . time() . '.' . $request->thumbnail->extension();
            $imgName = $request->thumbnail->getClientOriginalName();
            $request->thumbnail->move(public_path('img/pengabdian'), $imgName);

            CommunityService::where('id', $comserv->id)
                ->update([
                    'thumbnail' => $imgName
                ]);
        }

        CommunityService::where('id', $comserv->id)
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'author' => $request->author,
                    'date' => $request->date
                ]);
        return redirect('/admin/successlogin/pengabdian')->with('status', 'Berita Pengabdian Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CommunityService::find($id)->delete();
        return redirect('/admin/successlogin/pengabdian')->with('status', 'Berita Pengabdian Berhasil Dihapus!');
    }
}
