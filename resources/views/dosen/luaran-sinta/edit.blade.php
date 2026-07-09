@extends('layout.main')
@section('title', 'Edit Luaran — ' . Str::limit($luaran->judul, 40))

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/dosen/luaran-sinta') }}" class="btn btn-sm btn-outline-secondary mr-3">
            <i class="fa fa-arrow-left"></i>
        </a>
        <h3 class="mb-0">Edit Luaran</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/dosen/luaran-sinta/' . $luaran->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label><strong>Judul Luaran</strong> <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul', $luaran->judul) }}">
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong>Jenis Publikasi</strong> <span class="text-danger">*</span></label>
                        <select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
                            @foreach(['Jurnal','Prosiding','Buku','HKI'] as $j)
                                <option value="{{ $j }}" {{ old('jenis_publikasi', $luaran->jenis_publikasi) == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenis_publikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-5">
                        <label><strong>Kategori / Reputasi</strong> <span class="text-danger">*</span></label>
                        <select name="kategori_reputasi" class="form-control @error('kategori_reputasi') is-invalid @enderror">
                            @foreach($kategoriList as $k)
                                <option value="{{ $k }}" {{ old('kategori_reputasi', $luaran->kategori_reputasi) == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori_reputasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label><strong>Tahun</strong> <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_publikasi" class="form-control"
                               value="{{ old('tahun_publikasi', $luaran->tahun_publikasi) }}" min="2000" max="{{ date('Y') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Abstrak</strong> <span class="text-danger">*</span></label>
                    <textarea name="abstrak" rows="4" class="form-control @error('abstrak') is-invalid @enderror">{{ old('abstrak', $luaran->abstrak) }}</textarea>
                    @error('abstrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Jurnal / Konferensi</label>
                        <input type="text" name="nama_jurnal" class="form-control" value="{{ old('nama_jurnal', $luaran->nama_jurnal) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Volume / Edisi</label>
                        <input type="text" name="volume_edisi" class="form-control" value="{{ old('volume_edisi', $luaran->volume_edisi) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>DOI</label>
                        <input type="text" name="doi" class="form-control" value="{{ old('doi', $luaran->doi) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>URL Jurnal</label>
                        <input type="url" name="url_jurnal" class="form-control" value="{{ old('url_jurnal', $luaran->url_jurnal) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>URL Repository</label>
                        <input type="url" name="url_repository" class="form-control" value="{{ old('url_repository', $luaran->url_repository) }}">
                    </div>
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i> Simpan Perubahan</button>
                    <a href="{{ url('/dosen/luaran-sinta') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
