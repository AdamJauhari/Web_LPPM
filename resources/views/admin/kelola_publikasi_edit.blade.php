@if(isset(Auth::user()->email))
    @extends('layout/admin_dashboard')
@else
    <script>window.location="/admin";</script>
@endif 

@section('title', 'Edit Data Publikasi')

@section('main')
    @if(isset(Auth::user()->email))
        <div class="col">
            <div class="single-pricing">
                <div class="single-pricing-content">
                    <h5>Form Edit Data Publikasi</h5>
                    <p><i>* Wajib diisi</i></p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p style="margin:0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="post" action="{{ url('/admin/successlogin/kelola-publikasi/'.$publikasi->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="judul">Judul Publikasi*</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Masukkan judul publikasi" name="judul" value="{{ old('judul') ? old('judul') : $publikasi->judul }}">
                        </div>
                        @error('judul')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="abstrak">Abstrak*</label>
                            <textarea class="form-control @error('abstrak') is-invalid @enderror" id="abstrak" placeholder="Masukkan abstrak publikasi" name="abstrak" rows="5">{{ old('abstrak') ? old('abstrak') : $publikasi->abstrak }}</textarea>
                        </div>
                        @error('abstrak')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="jenis_publikasi">Jenis Publikasi*</label>
                            <select class="form-control @error('jenis_publikasi') is-invalid @enderror" id="jenis_publikasi" name="jenis_publikasi">
                                <option value="">-- Pilih Jenis Publikasi --</option>
                                <option value="Jurnal" {{ old('jenis_publikasi', $publikasi->jenis_publikasi) == 'Jurnal' ? 'selected' : '' }}>Jurnal</option>
                                <option value="Prosiding" {{ old('jenis_publikasi', $publikasi->jenis_publikasi) == 'Prosiding' ? 'selected' : '' }}>Prosiding</option>
                            </select>
                        </div>
                        @error('jenis_publikasi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="kategori_reputasi">Kategori Reputasi*</label>
                            <select class="form-control @error('kategori_reputasi') is-invalid @enderror" id="kategori_reputasi" name="kategori_reputasi">
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>
                        @error('kategori_reputasi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="url_jurnal">URL Jurnal/Prosiding</label>
                            <input type="url" class="form-control" id="url_jurnal" placeholder="https://contoh-jurnal.com/artikel/..." name="url_jurnal" value="{{ old('url_jurnal') ? old('url_jurnal') : $publikasi->url_jurnal }}">
                        </div>

                        <div class="form-group">
                            <label for="url_repository">URL Repository Kampus</label>
                            <input type="url" class="form-control" id="url_repository" placeholder="https://repository.uca.ac.id/..." name="url_repository" value="{{ old('url_repository') ? old('url_repository') : $publikasi->url_repository }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Ubah Publikasi</button>
                        <a href="{{ url('/admin/successlogin/kelola-publikasi') }}" class="btn btn-secondary ml-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    @else
        <script>window.location="/admin";</script>
    @endif

    @section('script')
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
@endsection
