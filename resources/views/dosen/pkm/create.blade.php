@extends('layout.main')
@section('title', 'Ajukan Proposal PKM')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/dosen/pkm') }}" class="btn btn-sm btn-outline-secondary mr-3"><i class="fa fa-arrow-left"></i></a>
        <h3 class="mb-0">Form Pengajuan Pengabdian Kepada Masyarakat (PKM)</h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/dosen/pkm') }}" method="POST">
                @csrf

                <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fa fa-info-circle mr-1"></i> Informasi Umum</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Fakultas <span class="text-danger">*</span></label>
                        <select name="fakultas" class="form-control @error('fakultas') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
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
                        <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}">
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-2"><i class="fa fa-file-text mr-1"></i> Detail Kegiatan PKM</h6>
                <div class="form-group">
                    <label>Judul PKM <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}" placeholder="Judul program pengabdian kepada masyarakat">
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Abstrak <span class="text-danger">*</span></label>
                    <textarea name="abstrak" rows="4" class="form-control @error('abstrak') is-invalid @enderror"
                              placeholder="Abstrak / latar belakang singkat kegiatan PKM">{{ old('abstrak') }}</textarea>
                    @error('abstrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Deskripsi Pelaksanaan <span class="text-danger">*</span></label>
                    <textarea name="pelaksanaan" rows="4" class="form-control @error('pelaksanaan') is-invalid @enderror"
                              placeholder="Jelaskan rencana pelaksanaan kegiatan PKM secara detail...">{{ old('pelaksanaan') }}</textarea>
                    @error('pelaksanaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Target Luaran Jurnal</label>
                        <select name="luaran_jurnal" class="form-control">
                            <option value="">-- Pilih Target (Opsional) --</option>
                            @foreach($luaranList as $l)
                                <option value="{{ $l }}" {{ old('luaran_jurnal') == $l ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Anggota Tim</label>
                        <input type="text" name="team_members" class="form-control" value="{{ old('team_members') }}"
                               placeholder="Nama anggota, pisahkan dengan koma">
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-2"><i class="fa fa-money mr-1"></i> Dana Kegiatan</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Sumber Dana <span class="text-danger">*</span></label>
                        <select name="sumber_dana" id="sumber-dana-pkm" class="form-control @error('sumber_dana') is-invalid @enderror">
                            @foreach($sumberDana as $d)
                                <option value="{{ $d }}" {{ old('sumber_dana') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('sumber_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Dana (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="total_dana" class="form-control @error('total_dana') is-invalid @enderror"
                               value="{{ old('total_dana') }}" placeholder="5000000" min="0">
                        @error('total_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4" id="ext-dana-field">
                        <label>Nama/Lembaga Sumber Dana Eksternal</label>
                        <input type="text" name="sumber_dana_eksternal" class="form-control"
                               value="{{ old('sumber_dana_eksternal') }}" placeholder="Ristekdikti, BRIN, dll.">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa fa-paper-plane mr-1"></i> Kirim Pengajuan PKM
                    </button>
                    <a href="{{ url('/dosen/pkm') }}" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@section('script')
<script>
    // Tampilkan/sembunyikan field sumber dana eksternal
    document.getElementById('sumber-dana-pkm').addEventListener('change', function() {
        var field = document.getElementById('ext-dana-field');
        field.style.display = this.value === 'Eksternal' ? 'block' : 'none';
    });
    document.getElementById('sumber-dana-pkm').dispatchEvent(new Event('change'));
</script>
@endsection
@endsection
