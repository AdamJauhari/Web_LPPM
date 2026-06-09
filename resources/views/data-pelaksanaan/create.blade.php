@extends('layout.main')
@section('title', 'Tambah Data Pelaksanaan - LPPM UCA')
@section('container')
<section class="submission-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="submission-card">
                    <div class="submission-header">
                        <i class="fas fa-clipboard-list"></i>
                        <h2>Tambah Data Pelaksanaan</h2>
                        <p>Isi formulir berikut untuk menambahkan data pelaksanaan penelitian atau pengabdian</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin: 0 24px;">
                        @foreach ($errors->all() as $error)<p style="margin:0">{{ $error }}</p>@endforeach
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/data-pelaksanaan') }}" class="submission-form">
                        @csrf
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Jenis Kegiatan</label>
                            <select name="jenis_kegiatan" class="form-control" required>
                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                <option value="Penelitian" {{ old('jenis_kegiatan') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                <option value="Pengabdian" {{ old('jenis_kegiatan') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Masukkan judul kegiatan">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-align-left"></i> Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" class="form-control" rows="4" required placeholder="Tuliskan deskripsi singkat kegiatan">{{ old('deskripsi_singkat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-money-bill-wave"></i> Sumber Dana</label>
                            <select name="sumber_dana" class="form-control" required>
                                <option value="">-- Pilih Sumber Dana --</option>
                                <option value="Internasional" {{ old('sumber_dana') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                <option value="Nasional (Dikti/Saintek)" {{ old('sumber_dana') == 'Nasional (Dikti/Saintek)' ? 'selected' : '' }}>Nasional (Dikti/Saintek)</option>
                                <option value="Nasional (Kemenag)" {{ old('sumber_dana') == 'Nasional (Kemenag)' ? 'selected' : '' }}>Nasional (Kemenag)</option>
                                <option value="Internal" {{ old('sumber_dana') == 'Internal' ? 'selected' : '' }}>Internal</option>
                                <option value="Mitra" {{ old('sumber_dana') == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-link"></i> URL Laporan/Bukti (opsional)</label>
                            <input type="url" name="url" class="form-control" value="{{ old('url') }}" placeholder="https://contoh.com/laporan/...">
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Data</button>
                        <a href="{{ url('/data-pelaksanaan') }}" class="btn-back-link"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.submission-page { padding: 120px 0 60px; min-height: 80vh; background: linear-gradient(135deg, rgba(13,43,26,.88) 0%, rgba(26,77,46,.82) 40%, rgba(42,110,66,.78) 100%), url('{{ asset("img/kampus-uca.jpg") }}') no-repeat center center; background-size: cover; position: relative; }
.submission-page::before { content: ''; position: absolute; top: -50%; right: -30%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(196,153,42,.12) 0%, transparent 70%); border-radius: 50%; }
.submission-card { background:rgba(255,255,255,.97); border-radius:16px; box-shadow:0 8px 40px rgba(0,0,0,.2); overflow:hidden; position:relative; z-index:1; }
.submission-header { background:linear-gradient(135deg,#1a4d2e,#2d6b42); padding:30px; text-align:center; color:#fff; }
.submission-header i { font-size:36px; color:#c4992a; margin-bottom:10px; }
.submission-header h2 { font-size:22px; margin:0; } .submission-header p { color:rgba(255,255,255,.7); font-size:13px; margin-top:4px; }
.submission-form { padding:24px; }
.submission-form .form-group { margin-bottom:16px; }
.submission-form label { font-weight:600; font-size:13px; color:#333; margin-bottom:4px; display:block; }
.submission-form label i { color:#c4992a; margin-right:4px; }
.submission-form .form-control { border-radius:8px; border:1px solid #ddd; padding:10px 14px; font-size:14px; transition:.2s; }
.submission-form .form-control:focus { border-color:#c4992a; box-shadow:0 0 0 3px rgba(196,153,42,.15); }
.btn-submit { width:100%; padding:12px; background:#1a4d2e; color:#fff; border:none; border-radius:8px; font-size:15px; font-weight:600; cursor:pointer; transition:.2s; }
.btn-submit:hover { background:#2d6b42; }
.btn-back-link { display:block; text-align:center; margin-top:12px; color:#888; font-size:13px; text-decoration:none; }
.btn-back-link:hover { color:#1a4d2e; }
</style>
@endsection
