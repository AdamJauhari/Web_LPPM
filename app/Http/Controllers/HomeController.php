<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //Query Builder

class HomeController extends Controller
{
    public function index()
    {
        $researches = \App\Researche::orderBy('date', 'desc')->take(5)->get();
        $comserv = \App\CommunityService::orderBy('date', 'desc')->take(5)->get();
        $orgMembers = DB::table('organization_members')->orderBy('sort_order')->get();
        return view('/index', compact('researches', 'comserv', 'orgMembers'));
    }

    public function show($title)
    {
        // die($slug);
        // $research = \App\Researche::where('title', $title)->first();
        // return view('/berita-penelitian/detail-1', compact('research'));
    }
}
