@extends('layout.main')
@section('title', 'Ajukan Proposal Penelitian')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/dosen/penelitian') }}" class="btn btn-sm btn-outline-secondary mr-3"><i class="fa fa-arrow-left"></i></a>
        <h3 class="mb-0">Form Pengajuan Proposal Penelitian</h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/dosen/penelitian') }}" method="POST">
                @csrf

                <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fa fa-info-circle mr-1"></i> Informasi Umum</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Fakultas <span class="text-danger">*</span></label>
                        <select name="fakultas" class="form-control @error('fakultas') is-invalid @enderror">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultasList as $f)
                                <option value="{{ $f }}" {{ old('fakultas', Auth::user()->fakultas) == $f ? 'selected' : '' }}>{{ $f }}</option>
                            @endforeach
                        </select>
                        @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Semester <span class="text-danger">*</span></label>
                        <select name="semester" class="form-control @error('semester') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach($semesterList as $s)
                                <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                               value="{{ old('tahun', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}">
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-2"><i class="fa fa-file-text mr-1"></i> Detail Proposal</h6>
                <div class="form-group">
                    <label>Judul Penelitian <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="Judul penelitian yang diajukan">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Jenis / Skema Penelitian <span class="text-danger">*</span></label>
                        <input type="text" name="research_type" class="form-control @error('research_type') is-invalid @enderror"
                               value="{{ old('research_type') }}" placeholder="Contoh: Penelitian Dasar, Penelitian Terapan">
                        @error('research_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Kategori Luaran</label>
                        <select name="kategori_luaran" class="form-control">
                            <option value="">-- Pilih (Opsional) --</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k }}" {{ old('kategori_luaran') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Abstrak <span class="text-danger">*</span></label>
                    <textarea name="abstract" rows="5" class="form-control @error('abstract') is-invalid @enderror"
                              placeholder="Tuliskan abstrak proposal penelitian Anda...">{{ old('abstract') }}</textarea>
                    @error('abstract')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Anggota Tim</label>
                    <input type="text" name="team_members" class="form-control" value="{{ old('team_members') }}"
                           placeholder="Nama anggota, pisahkan dengan koma">
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-2"><i class="fa fa-money mr-1"></i> Dana Penelitian</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Sumber Dana <span class="text-danger">*</span></label>
                        <select name="sumber_dana" class="form-control @error('sumber_dana') is-invalid @enderror">
                            @foreach($sumberDana as $d)
                                <option value="{{ $d }}" {{ old('sumber_dana') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('sumber_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-8">
                        <label>Total Dana Diajukan (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="total_dana" class="form-control @error('total_dana') is-invalid @enderror"
                               value="{{ old('total_dana') }}" placeholder="5000000" min="0">
                        @error('total_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa fa-paper-plane mr-1"></i> Kirim Pengajuan
                    </button>
                    <a href="{{ url('/dosen/penelitian') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
