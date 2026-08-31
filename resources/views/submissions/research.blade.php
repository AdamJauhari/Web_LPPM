@extends('layout.main')
@section('title', 'Ajukan Proposal Penelitian - LPPM UCA')
@section('container')
<section class="submission-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="submission-card">
                    <div class="submission-header" style="position: relative;">
                        <a href="{{ url('/status-peninjauan') }}" class="btn-back-header" title="Kembali ke Status Peninjauan">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <i class="fas fa-flask"></i>
                        <h2>Ajukan Proposal Penelitian</h2>
                        <p>Isi formulir berikut untuk mengajukan proposal penelitian Anda</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin: 0 24px;">
                        @foreach ($errors->all() as $error)<p style="margin:0">{{ $error }}</p>@endforeach
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/ajukan-penelitian') }}" class="submission-form">
                        @csrf
                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Judul Penelitian</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Masukkan judul penelitian">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Jenis Penelitian</label>
                            <select name="research_type" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Penelitian Dasar">Penelitian Dasar</option>
                                <option value="Penelitian Terapan">Penelitian Terapan</option>
                                <option value="Penelitian Pengembangan">Penelitian Pengembangan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-align-left"></i> Abstrak</label>
                            <textarea name="abstract" class="form-control" rows="5" required placeholder="Tuliskan abstrak penelitian Anda">{{ old('abstract') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-users"></i> Anggota Tim (opsional)</label>
                            <input type="text" name="team_members" class="form-control" value="{{ old('team_members') }}" placeholder="Pisahkan dengan koma">
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Ajukan Proposal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
.submission-page {
    padding: 120px 0 60px;
    min-height: 80vh;
    background: linear-gradient(135deg, rgba(13,43,26,.88) 0%, rgba(26,77,46,.82) 40%, rgba(42,110,66,.78) 100%), url('{{ asset("img/kampus-uca.jpg") }}') no-repeat center center;
    background-size: cover;
    position: relative;
}
.submission-page::before {
    content: '';
    position: absolute;
    top: -50%; right: -30%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(196,153,42,.12) 0%, transparent 70%);
    border-radius: 50%;
}
.submission-card { background:rgba(255,255,255,.97); border-radius:16px; box-shadow:0 8px 40px rgba(0,0,0,.2); overflow:hidden; position:relative; z-index:1; }
.submission-header { background:linear-gradient(135deg,#1a4d2e,#2d6b42); padding:30px; text-align:center; color:#fff; position:relative; }
.submission-header > i { font-size:36px; color:#c4992a; margin-bottom:10px; }
.submission-header h2 { font-size:22px; margin:0; } .submission-header p { color:rgba(255,255,255,.7); font-size:13px; margin-top:4px; }
.btn-back-header {
    position: absolute;
    top: 22px;
    left: 22px;
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff !important;
    font-size: 15px;
    text-decoration: none !important;
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    z-index: 10;
}
.btn-back-header:hover {
    background: #c4992a;
    transform: translateX(-3px);
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(196, 153, 42, 0.4);
}
.btn-back-header i { margin: 0 !important; font-size: 14px !important; }
.submission-form { padding:24px; }
.submission-form .form-group { margin-bottom:16px; }
.submission-form label { font-weight:600; font-size:13px; color:#333; margin-bottom:4px; display:block; }
.submission-form label i { color:#c4992a; margin-right:4px; }
.submission-form .form-control { border-radius:8px; border:1px solid #ddd; padding:10px 14px; font-size:14px; transition:.2s; }
.submission-form .form-control:focus { border-color:#c4992a; box-shadow:0 0 0 3px rgba(196,153,42,.15); }
.btn-submit { width:100%; padding:12px; background:#1a4d2e; color:#fff; border:none; border-radius:8px; font-size:15px; font-weight:600; cursor:pointer; transition:.2s; }
.btn-submit:hover { background:#2d6b42; }
</style>
@endsection
