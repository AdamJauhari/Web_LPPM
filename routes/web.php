<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoEmail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', 'HomeController@index');

// Berita
Route::get('/berita', 'BeritaController@index');
Route::get('/berita/{slug}', 'BeritaController@show');


// Penelitian
Route::get('/penelitian', 'PenelitianController@index');
Route::get('/admin/successlogin/penelitian/create', 'PenelitianController@create');
Route::post('/admin/successlogin/penelitian', 'PenelitianController@store');
Route::get('/penelitian/{research}', 'PenelitianController@show');
Route::get('/admin/successlogin/penelitian/{research}/edit', 'PenelitianController@edit');
Route::put('/admin/successlogin/penelitian/{research}', 'PenelitianController@update');
Route::delete('/admin/successlogin/penelitian/{research}', 'PenelitianController@destroy');

// Pengabdian
Route::get('/pengabdian', 'PengabdianController@index');
Route::get('/admin/successlogin/pengabdian/create', 'PengabdianController@create');
Route::post('/admin/successlogin/pengabdian', 'PengabdianController@store');
Route::get('/pengabdian/{comserv}', 'PengabdianController@show');
Route::get('/admin/successlogin/pengabdian/{comserv}/edit', 'PengabdianController@edit');
Route::put('/admin/successlogin/pengabdian/{comserv}', 'PengabdianController@update');
Route::delete('/admin/successlogin/pengabdian/{comserv}', 'PengabdianController@destroy');

// Kepakaran
Route::get('/kepakaran', 'KepakaranController@index');
Route::get('/admin/successlogin/kepakaran/create', 'KepakaranController@create');
Route::post('/admin/successlogin/kepakaran', 'KepakaranController@store');
Route::get('/kepakaran/detail/{expertises}', 'KepakaranController@show');
Route::get('/admin/successlogin/kepakaran/{expertises}/edit', 'KepakaranController@edit');
Route::put('/admin/successlogin/kepakaran/{expertises}', 'KepakaranController@update');
Route::delete('/admin/successlogin/kepakaran/{expertises}', 'KepakaranController@destroy');

// Produk Riset
Route::get('/riset', 'RisetController@index');
Route::get('/riset/judul-riset', 'RisetController@show');

// Publikasi
Route::get('/publikasi', 'PublikasiController@index');
Route::get('/admin/successlogin/publikasi/create', 'PublikasiController@create');
Route::post('/admin/successlogin/publikasi', 'PublikasiController@store');
Route::get('/publikasi/{publications}', 'PublikasiController@show');
Route::get('/admin/successlogin/publikasi/{publications}/edit', 'PublikasiController@edit');
Route::get('/publikasi/download/{publications}', 'PublikasiController@getDownload');
Route::put('/admin/successlogin/publikasi/{publications}', 'PublikasiController@update');
Route::delete('/admin/successlogin/publikasi/{publications}', 'PublikasiController@destroy');

// Admin Panel (Dashboard + Sidebar Index Pages)
Route::get('/admin/successlogin', 'AdminController@successlogin');
Route::get('/admin/successlogin/penelitian', 'AdminController@penelitian');
Route::get('/admin/successlogin/pengabdian', 'AdminController@pengabdian');
Route::get('/admin/successlogin/publikasi', 'AdminController@publikasi');
Route::get('/admin/successlogin/kepakaran', 'AdminController@kepakaran');
Route::get('/admin/logout', 'AdminController@logout');

// Admin Berita (SSR CRUD)
Route::get('/admin/successlogin/berita', 'BeritaController@adminIndex');
Route::get('/admin/successlogin/berita/create', 'BeritaController@adminCreate');
Route::post('/admin/successlogin/berita', 'BeritaController@adminStore');
Route::get('/admin/successlogin/berita/{id}/edit', 'BeritaController@adminEdit');
Route::put('/admin/successlogin/berita/{id}', 'BeritaController@adminUpdate');
Route::delete('/admin/successlogin/berita/{id}', 'BeritaController@adminDestroy');

// Admin Kelola Publikasi (Data Publikasi Dosen)
Route::get('/admin/successlogin/kelola-publikasi', 'AdminController@kelolaPublikasi');
Route::get('/admin/successlogin/kelola-publikasi/create', 'AdminController@kelolaPublikasiCreate');
Route::post('/admin/successlogin/kelola-publikasi', 'AdminController@kelolaPublikasiStore');
Route::get('/admin/successlogin/kelola-publikasi/{id}/edit', 'AdminController@kelolaPublikasiEdit');
Route::put('/admin/successlogin/kelola-publikasi/{id}', 'AdminController@kelolaPublikasiUpdate');
Route::delete('/admin/successlogin/kelola-publikasi/{id}', 'AdminController@kelolaPublikasiDestroy');

// Admin Kelola Pelaksanaan (Data Pelaksanaan Dosen)
Route::get('/admin/successlogin/kelola-pelaksanaan', 'AdminController@kelolaPelaksanaan');
Route::get('/admin/successlogin/kelola-pelaksanaan/create', 'AdminController@kelolaPelaksanaanCreate');
Route::post('/admin/successlogin/kelola-pelaksanaan', 'AdminController@kelolaPelaksanaanStore');
Route::get('/admin/successlogin/kelola-pelaksanaan/{id}/edit', 'AdminController@kelolaPelaksanaanEdit');
Route::put('/admin/successlogin/kelola-pelaksanaan/{id}', 'AdminController@kelolaPelaksanaanUpdate');
Route::delete('/admin/successlogin/kelola-pelaksanaan/{id}', 'AdminController@kelolaPelaksanaanDestroy');

// User Login (Mahasiswa & Dosen)
Route::get('/login', 'AdminController@index');
Route::post('/login/checklogin', 'AdminController@checklogin');
Route::get('/login/successlogin', function() { return redirect('/'); });
Route::get('/login/logout', 'AdminController@logout');

// Ajuan & Status
Route::get('/ajukan-penelitian', 'SubmissionController@createResearch');
Route::post('/ajukan-penelitian', 'SubmissionController@storeResearch');
Route::get('/ajukan-jurnal', 'SubmissionController@createJournal');
Route::post('/ajukan-jurnal', 'SubmissionController@storeJournal');
Route::get('/status-peninjauan', 'SubmissionController@statusPeninjauan');
Route::get('/jurnal-saya', 'SubmissionController@jurnalSaya');

// Data Publikasi (CRUD - Dosen & Admin)
Route::get('/data-publikasi', 'DataPublikasiController@index');
Route::get('/data-publikasi/create', 'DataPublikasiController@create');
Route::post('/data-publikasi', 'DataPublikasiController@store');
Route::get('/data-publikasi/{id}/edit', 'DataPublikasiController@edit');
Route::put('/data-publikasi/{id}', 'DataPublikasiController@update');
Route::delete('/data-publikasi/{id}', 'DataPublikasiController@destroy');

// Data Pelaksanaan (CRUD - Dosen & Admin)
Route::get('/data-pelaksanaan', 'PelaksanaanController@index');
Route::get('/data-pelaksanaan/create', 'PelaksanaanController@create');
Route::post('/data-pelaksanaan', 'PelaksanaanController@store');
Route::get('/data-pelaksanaan/{id}/edit', 'PelaksanaanController@edit');
Route::put('/data-pelaksanaan/{id}', 'PelaksanaanController@update');
Route::delete('/data-pelaksanaan/{id}', 'PelaksanaanController@destroy');

Route::get('/forkomil-dan-conferences', function () {
    return view('forkomil-dan-conferences');
});

Route::get('/paten', function () {
    return view('paten');
});

Route::get('/hakcipta', function () {
    return view('hakcipta');
});

    Route::get('/download', function () {
    return view('download');
});

// Route::get('/admin', function () {
//     return view('berita-penelitian/admin');
// });

// Email related routes
// Route::get('/mail', function() {
//     Mail::to("felicia.funay@gmail.id")->send(new DemoEmail());
//     return new DemoEmail();
// });

// Auth::routes();

// Route::get('/admin/successlogin', 'AdminController@successlogin')->name('admin');

// === Admin API (untuk Electron Admin Panel) ===
Route::prefix('api/admin')->group(function () {
    Route::post('/verify', 'AdminApiController@verify');
    Route::get('/stats', 'AdminApiController@stats');
    Route::post('/upload-photo', 'AdminApiController@uploadPhoto');
    Route::post('/upload-file', 'AdminApiController@uploadFile');
    Route::get('/list/{table}', 'AdminApiController@list');
    Route::get('/show/{table}/{id}', 'AdminApiController@show');
    Route::post('/store/{table}', 'AdminApiController@store');
    Route::put('/update/{table}/{id}', 'AdminApiController@update');
    Route::delete('/delete/{table}/{id}', 'AdminApiController@destroy');
});

// =====================================================
// REGISTRASI DOSEN
// =====================================================
Route::get('/daftar-dosen', 'Auth\RegisterDosenController@showForm');
Route::post('/daftar-dosen', 'Auth\RegisterDosenController@register');

// =====================================================
// DOSEN DASHBOARD (redirect ke portal dosen)
// =====================================================
Route::get('/dosen/dashboard', function () {
    if (!Auth::check()) return redirect('/login');
    return redirect('/dosen/luaran-sinta');
})->middleware('auth');

// =====================================================
// DOSEN — LUARAN SINTA (Manual Input)
// =====================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dosen/luaran-sinta',                  'Dosen\LuaranSintaController@index');
    Route::get('/dosen/luaran-sinta/create',           'Dosen\LuaranSintaController@create');
    Route::post('/dosen/luaran-sinta',                 'Dosen\LuaranSintaController@store');
    Route::get('/dosen/luaran-sinta/{id}/edit',        'Dosen\LuaranSintaController@edit');
    Route::put('/dosen/luaran-sinta/{id}',             'Dosen\LuaranSintaController@update');
    Route::delete('/dosen/luaran-sinta/{id}',          'Dosen\LuaranSintaController@destroy');
});

// =====================================================
// DOSEN — PENGAJUAN PENELITIAN
// =====================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dosen/penelitian',         'Dosen\PenelitianSubmissionController@index');
    Route::get('/dosen/penelitian/create',  'Dosen\PenelitianSubmissionController@create');
    Route::post('/dosen/penelitian',        'Dosen\PenelitianSubmissionController@store');
});

// =====================================================
// DOSEN — PENGAJUAN PKM
// =====================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dosen/pkm',         'Dosen\PkmSubmissionController@index');
    Route::get('/dosen/pkm/create',  'Dosen\PkmSubmissionController@create');
    Route::post('/dosen/pkm',        'Dosen\PkmSubmissionController@store');
});

// =====================================================
// DOSEN — PENGAJUAN HKI
// =====================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dosen/hki',         'Dosen\HkiSubmissionController@index');
    Route::get('/dosen/hki/create',  'Dosen\HkiSubmissionController@create');
    Route::post('/dosen/hki',        'Dosen\HkiSubmissionController@store');
});




