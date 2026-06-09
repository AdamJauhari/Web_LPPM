@extends('layout.main')
@section('title', 'Edit Data Publikasi - LPPM UCA')
@section('container')
<section class="submission-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="submission-card">
                    <div class="submission-header">
                        <i class="fas fa-edit"></i>
                        <h2>Edit Data Publikasi</h2>
                        <p>Perbarui data publikasi ilmiah Anda</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin: 0 24px;">
                        @foreach ($errors->all() as $error)<p style="margin:0">{{ $error }}</p>@endforeach
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/data-publikasi/'.$publikasi->id) }}" class="submission-form">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Judul Publikasi</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul', $publikasi->judul) }}" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-align-left"></i> Abstrak</label>
                            <textarea name="abstrak" class="form-control" rows="4" required>{{ old('abstrak', $publikasi->abstrak) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Jenis Publikasi</label>
                            <select name="jenis_publikasi" id="jenis_publikasi" class="form-control" required>
                                <option value="">-- Pilih Jenis Publikasi --</option>
                                <option value="Jurnal" {{ old('jenis_publikasi', $publikasi->jenis_publikasi) == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                                <option value="Prosiding" {{ old('jenis_publikasi', $publikasi->jenis_publikasi) == 'Prosiding' ? 'selected' : '' }}>Prosiding</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-award"></i> Kategori Reputasi</label>
                            <select name="kategori_reputasi" id="kategori_reputasi" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-link"></i> URL Jurnal/Prosiding (opsional)</label>
                            <input type="url" name="url_jurnal" class="form-control" value="{{ old('url_jurnal', $publikasi->url_jurnal) }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-database"></i> URL Repository Kampus (opsional)</label>
                            <input type="url" name="url_repository" class="form-control" value="{{ old('url_repository', $publikasi->url_repository) }}">
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui Publikasi</button>
                        <a href="{{ url('/data-publikasi') }}" class="btn-back-link"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
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

<script>
(function() {
    var kategoriOptions = {
        'Jurnal': [
            'Internasional Bereputasi (Q1)', 'Internasional Bereputasi (Q2)',
            'Internasional Bereputasi (Q3)', 'Internasional Bereputasi (Q4)',
            'Internasional',
            'Nasional Bereputasi (Sinta 1)', 'Nasional Bereputasi (Sinta 2)',
            'Nasional Bereputasi (Sinta 3)', 'Nasional Bereputasi (Sinta 4)',
            'Nasional Bereputasi (Sinta 5)', 'Nasional Bereputasi (Sinta 6)',
            'Nasional'
        ],
        'Prosiding': [
            'Internasional Scopus', 'Internasional', 'Nasional Garuda', 'Nasional'
        ]
    };

    var jenisSelect = document.getElementById('jenis_publikasi');
    var kategoriSelect = document.getElementById('kategori_reputasi');
    var currentKategori = '{{ old("kategori_reputasi", $publikasi->kategori_reputasi) }}';

    function updateKategori() {
        var jenis = jenisSelect.value;
        kategoriSelect.innerHTML = '';
        if (!jenis || !kategoriOptions[jenis]) {
            var opt = document.createElement('option');
            opt.value = ''; opt.textContent = '-- Pilih Jenis Publikasi Terlebih Dahulu --';
            kategoriSelect.appendChild(opt);
            return;
        }
        var ph = document.createElement('option');
        ph.value = ''; ph.textContent = '-- Pilih Kategori Reputasi --';
        kategoriSelect.appendChild(ph);
        kategoriOptions[jenis].forEach(function(item) {
            var opt = document.createElement('option');
            opt.value = item; opt.textContent = item;
            if (item === currentKategori) opt.selected = true;
            kategoriSelect.appendChild(opt);
        });
    }

    jenisSelect.addEventListener('change', function() {
        currentKategori = '';
        updateKategori();
    });
    updateKategori();
})();
</script>
@endsection
