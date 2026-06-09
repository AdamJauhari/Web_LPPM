@if(isset(Auth::user()->email))
    @extends('layout/admin_dashboard')
@else
    <script>window.location="/admin";</script>
@endif 

@section('title', 'Tambah Data Pelaksanaan')

@section('main')
    @if(isset(Auth::user()->email))
        <div class="col">
            <div class="single-pricing">
                <div class="single-pricing-content">
                    <h5>Form Tambah Data Pelaksanaan</h5>
                    <p><i>* Wajib diisi</i></p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p style="margin:0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="post" action="{{ url('/admin/successlogin/kelola-pelaksanaan') }}">
                        @csrf
                        <div class="form-group">
                            <label for="jenis_kegiatan">Jenis Kegiatan*</label>
                            <select class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="jenis_kegiatan" name="jenis_kegiatan">
                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                <option value="Penelitian" {{ old('jenis_kegiatan') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                <option value="Pengabdian" {{ old('jenis_kegiatan') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                            </select>
                        </div>
                        @error('jenis_kegiatan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="judul">Judul*</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Masukkan judul kegiatan" name="judul" value="{{ old('judul') }}">
                        </div>
                        @error('judul')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="deskripsi_singkat">Deskripsi Singkat*</label>
                            <textarea class="form-control @error('deskripsi_singkat') is-invalid @enderror" id="deskripsi_singkat" placeholder="Masukkan deskripsi singkat kegiatan" name="deskripsi_singkat" rows="5">{{ old('deskripsi_singkat') }}</textarea>
                        </div>
                        @error('deskripsi_singkat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="sumber_dana">Sumber Dana*</label>
                            <select class="form-control @error('sumber_dana') is-invalid @enderror" id="sumber_dana" name="sumber_dana">
                                <option value="">-- Pilih Sumber Dana --</option>
                                <option value="Internasional" {{ old('sumber_dana') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                <option value="Nasional (Dikti/Saintek)" {{ old('sumber_dana') == 'Nasional (Dikti/Saintek)' ? 'selected' : '' }}>Nasional (Dikti/Saintek)</option>
                                <option value="Nasional (Kemenag)" {{ old('sumber_dana') == 'Nasional (Kemenag)' ? 'selected' : '' }}>Nasional (Kemenag)</option>
                                <option value="Internal" {{ old('sumber_dana') == 'Internal' ? 'selected' : '' }}>Internal</option>
                                <option value="Mitra" {{ old('sumber_dana') == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                            </select>
                        </div>
                        @error('sumber_dana')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="url">URL Laporan/Bukti</label>
                            <input type="url" class="form-control" id="url" placeholder="https://contoh.com/laporan/..." name="url" value="{{ old('url') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                        <a href="{{ url('/admin/successlogin/kelola-pelaksanaan') }}" class="btn btn-secondary ml-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    @else
        <script>window.location="/admin";</script>
    @endif
@endsection
