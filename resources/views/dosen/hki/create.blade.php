@extends('layout.main')
@section('title', 'Ajukan HKI')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/dosen/hki') }}" class="btn btn-sm btn-outline-secondary mr-3"><i class="fa fa-arrow-left"></i></a>
        <h3 class="mb-0">Form Pengajuan HKI (Hak Kekayaan Intelektual)</h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/dosen/hki') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Jenis HKI <span class="text-danger">*</span></label>
                        <select name="jenis_hki" class="form-control @error('jenis_hki') is-invalid @enderror">
                            <option value="">-- Pilih Jenis HKI --</option>
                            @foreach($jenisHki as $j)
                                <option value="{{ $j }}" {{ old('jenis_hki') == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenis_hki')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Fakultas <span class="text-danger">*</span></label>
                        <select name="fakultas" class="form-control @error('fakultas') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach($fakultasList as $f)
                                <option value="{{ $f }}" {{ old('fakultas', Auth::user()->fakultas) == $f ? 'selected' : '' }}>{{ $f }}</option>
                            @endforeach
                        </select>
                        @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tahun Pengajuan <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_pengajuan" class="form-control @error('tahun_pengajuan') is-invalid @enderror"
                               value="{{ old('tahun_pengajuan', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}">
                        @error('tahun_pengajuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Judul / Nama Karya <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}" placeholder="Judul paten / nama karya cipta">
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Deskripsi / Abstrak <span class="text-danger">*</span></label>
                    <textarea name="abstrak" rows="4" class="form-control @error('abstrak') is-invalid @enderror"
                              placeholder="Jelaskan karya / invensi secara singkat...">{{ old('abstrak') }}</textarea>
                    @error('abstrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tanggal Pengajuan ke DJKI</label>
                        <input type="date" name="tanggal_pengajuan" class="form-control" value="{{ old('tanggal_pengajuan') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nomor Pendaftaran (jika sudah ada)</label>
                        <input type="text" name="nomor_pendaftaran" class="form-control" value="{{ old('nomor_pendaftaran') }}"
                               placeholder="EC002023XXXXX">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Anggota Tim</label>
                        <input type="text" name="team_members" class="form-control" value="{{ old('team_members') }}"
                               placeholder="Nama anggota, pisahkan dengan koma">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa fa-paper-plane mr-1"></i> Kirim Pengajuan HKI
                    </button>
                    <a href="{{ url('/dosen/hki') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
