@extends('layout.main')
@section('title', 'Tambah Luaran Publikasi')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/dosen/luaran-sinta') }}" class="btn btn-sm btn-outline-secondary mr-3">
            <i class="fa fa-arrow-left"></i>
        </a>
        <h3 class="mb-0">Tambah Luaran Publikasi</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/dosen/luaran-sinta') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><strong>Judul Luaran</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}" placeholder="Judul jurnal / buku / karya ilmiah">
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong>Jenis Publikasi</strong> <span class="text-danger">*</span></label>
                        <select name="jenis_publikasi" id="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach(['Jurnal','Prosiding','Buku','HKI'] as $j)
                                <option value="{{ $j }}" {{ old('jenis_publikasi') == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenis_publikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-5">
                        <label><strong>Kategori / Reputasi</strong> <span class="text-danger">*</span></label>
                        <select name="kategori_reputasi" class="form-control @error('kategori_reputasi') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k }}" {{ old('kategori_reputasi') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori_reputasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label><strong>Tahun Publikasi</strong> <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_publikasi" class="form-control @error('tahun_publikasi') is-invalid @enderror"
                               value="{{ old('tahun_publikasi', date('Y')) }}" min="2000" max="{{ date('Y') }}">
                        @error('tahun_publikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Abstrak</strong> <span class="text-danger">*</span></label>
                    <textarea name="abstrak" rows="4" class="form-control @error('abstrak') is-invalid @enderror"
                              placeholder="Abstrak / deskripsi singkat karya">{{ old('abstrak') }}</textarea>
                    @error('abstrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Jurnal / Konferensi / Penerbit</label>
                        <input type="text" name="nama_jurnal" class="form-control @error('nama_jurnal') is-invalid @enderror"
                               value="{{ old('nama_jurnal') }}" placeholder="Contoh: Journal of Information Systems">
                        @error('nama_jurnal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Volume / Edisi</label>
                        <input type="text" name="volume_edisi" class="form-control" value="{{ old('volume_edisi') }}" placeholder="Vol. 12, No. 3">
                    </div>
                    <div class="form-group col-md-3">
                        <label>DOI</label>
                        <input type="text" name="doi" class="form-control" value="{{ old('doi') }}" placeholder="10.xxxxx/xxxxx">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>URL Jurnal / Publikasi</label>
                        <input type="url" name="url_jurnal" class="form-control @error('url_jurnal') is-invalid @enderror"
                               value="{{ old('url_jurnal') }}" placeholder="https://...">
                        @error('url_jurnal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>URL Repository Institusi</label>
                        <input type="url" name="url_repository" class="form-control @error('url_repository') is-invalid @enderror"
                               value="{{ old('url_repository') }}" placeholder="https://...">
                        @error('url_repository')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="alert alert-info small">
                    <i class="fa fa-info-circle mr-1"></i>
                    Luaran yang Anda input akan masuk status <strong>Menunggu Verifikasi</strong>.
                    Admin LPPM/UPPM akan memeriksa dan memverifikasi data Anda.
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i> Simpan Luaran
                    </button>
                    <a href="{{ url('/dosen/luaran-sinta') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
