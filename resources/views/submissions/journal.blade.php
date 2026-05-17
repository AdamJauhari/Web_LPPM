@extends('layout.main')
@section('title', 'Ajukan Jurnal Penelitian - LPPM UCA')
@section('container')
<section class="submission-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="submission-card">
                    <div class="submission-header">
                        <i class="fas fa-file-alt"></i>
                        <h2>Ajukan Jurnal Penelitian</h2>
                        <p>Submit jurnal penelitian Anda untuk ditinjau</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin: 0 24px;">
                        @foreach ($errors->all() as $error)<p style="margin:0">{{ $error }}</p>@endforeach
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/ajukan-jurnal') }}" class="submission-form" enctype="multipart/form-data">
                        @csrf
                        @if(request('proposal_id'))
                        <input type="hidden" name="proposal_id" value="{{ request('proposal_id') }}">
                        <div style="background:#d4edda; color:#155724; padding:10px 14px; border-radius:8px; margin-bottom:16px; font-size:13px;">
                            <i class="fas fa-check-circle"></i> Berdasarkan proposal yang disetujui: <strong>{{ request('title') }}</strong>
                        </div>
                        @endif
                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Judul Jurnal</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', request('title')) }}" required placeholder="Masukkan judul jurnal">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-book"></i> Nama Jurnal Tujuan</label>
                            <input type="text" name="journal_name" class="form-control" value="{{ old('journal_name') }}" required placeholder="Contoh: Jurnal Teknologi Informasi">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-file-pdf"></i> Upload File Jurnal (PDF)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="file" id="file-input" class="file-input" accept=".pdf" required>
                                <label for="file-input" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="file-name">Klik untuk pilih file PDF</span>
                                </label>
                            </div>
                            <small style="color:#888; font-size:11px;">Format: PDF, Maks: 10MB</small>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-users"></i> Penulis</label>
                            <input type="text" name="authors" class="form-control" value="{{ old('authors') }}" placeholder="Pisahkan dengan koma">
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Ajukan Jurnal</button>
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
.submission-header { background:linear-gradient(135deg,#1a4d2e,#2d6b42); padding:30px; text-align:center; color:#fff; }
.submission-header i { font-size:36px; color:#c4992a; margin-bottom:10px; }
.submission-header h2 { font-size:22px; margin:0; } .submission-header p { color:rgba(255,255,255,.7); font-size:13px; margin-top:4px; }
.submission-form { padding:24px; }
.submission-form .form-group { margin-bottom:16px; }
.submission-form label { font-weight:600; font-size:13px; color:#333; margin-bottom:4px; display:block; }
.submission-form label i { color:#c4992a; margin-right:4px; }
.submission-form .form-control { border-radius:8px; border:1px solid #ddd; padding:10px 14px; font-size:14px; transition:.2s; }
.submission-form .form-control:focus { border-color:#c4992a; box-shadow:0 0 0 3px rgba(196,153,42,.15); }
.file-upload-wrapper { position: relative; }
.file-input { position:absolute; opacity:0; width:100%; height:100%; cursor:pointer; z-index:2; }
.file-upload-label {
    display:flex; align-items:center; gap:10px; justify-content:center;
    border:2px dashed #c4992a; border-radius:8px; padding:20px;
    cursor:pointer; transition:.2s; background:rgba(196,153,42,.05); color:#888;
}
.file-upload-label:hover { background:rgba(196,153,42,.1); border-color:#d4a94a; }
.file-upload-label i { font-size:24px; color:#c4992a; }
.btn-submit { width:100%; padding:12px; background:#1a4d2e; color:#fff; border:none; border-radius:8px; font-size:15px; font-weight:600; cursor:pointer; transition:.2s; }
.btn-submit:hover { background:#2d6b42; }
</style>
<script>
document.getElementById('file-input').addEventListener('change', function() {
    const name = this.files[0] ? this.files[0].name : 'Klik untuk pilih file PDF';
    document.getElementById('file-name').textContent = name;
});
</script>
@endsection
