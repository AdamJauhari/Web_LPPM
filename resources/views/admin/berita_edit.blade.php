@extends('layout/admin_dashboard')

@section('title', 'Admin - Edit Berita')

@section('main')
<div class="col">
    <div class="mt-4" style="max-width: 860px;">

        <div class="d-flex align-items-center gap-2 mb-4" style="gap: 12px;">
            <a href="{{ url('/admin/successlogin/berita') }}" style="color: #888; font-size: 13px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <span style="color: #ddd;">|</span>
            <h4 style="font-weight: 700; color: #1a4d2e; margin: 0; font-size: 18px;">
                <i class="fas fa-edit" style="color: #c4992a;"></i> Edit Berita
            </h4>
        </div>

        @if($errors->any())
        <div class="alert alert-danger" style="border-radius: 8px; border: none;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                <li style="font-size: 13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="background: #fff; border-radius: 14px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.07);">
            <form action="{{ url('/admin/successlogin/berita/' . $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="form-group mb-3">
                    <label style="font-weight: 600; color: #333; font-size: 14px;">Judul Berita <span style="color:#e74c3c">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required
                        style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                </div>

                {{-- Baris: Kategori, Status, Tanggal --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #333; font-size: 14px;">Kategori <span style="color:#e74c3c">*</span></label>
                        <select name="kategori" class="form-control" required
                            style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                            @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $berita->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #333; font-size: 14px;">Status <span style="color:#e74c3c">*</span></label>
                        <select name="status" class="form-control" required
                            style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #333; font-size: 14px;">Tanggal <span style="color:#e74c3c">*</span></label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ old('tanggal', $berita->tanggal->format('Y-m-d')) }}" required
                            style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                    </div>
                </div>

                {{-- Penulis --}}
                <div class="form-group mb-3">
                    <label style="font-weight: 600; color: #333; font-size: 14px;">Penulis / Sumber</label>
                    <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $berita->penulis) }}"
                        style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                </div>

                {{-- Gambar --}}
                <div class="form-group mb-3">
                    <label style="font-weight: 600; color: #333; font-size: 14px;">Gambar Berita</label>
                    @if($berita->gambar)
                    <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('img/berita/' . $berita->gambar) }}" alt="Gambar saat ini"
                            style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #888;">Gambar saat ini. Upload baru untuk menggantinya.</span>
                    </div>
                    @endif
                    <input type="file" name="gambar" class="form-control" accept="image/*"
                        style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px;">
                    <small style="color: #aaa; font-size: 12px; margin-top: 4px; display: block;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                {{-- Ringkasan --}}
                <div class="form-group mb-3">
                    <label style="font-weight: 600; color: #333; font-size: 14px;">Ringkasan</label>
                    <textarea name="ringkasan" class="form-control" rows="3"
                        style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px; resize: vertical;">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                {{-- Konten --}}
                <div class="form-group mb-4">
                    <label style="font-weight: 600; color: #333; font-size: 14px;">Isi Berita <span style="color:#e74c3c">*</span></label>
                    <textarea name="konten" class="form-control" rows="14" required
                        style="border-radius: 8px; padding: 10px 14px; border: 1px solid #ddd; font-size: 14px; line-height: 1.7; resize: vertical;">{{ old('konten', $berita->konten) }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="d-flex gap-2" style="gap: 10px;">
                    <button type="submit"
                        style="background: linear-gradient(135deg, #c4992a, #d4a94a); color: #fff; border: none; padding: 11px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-save"></i> Update Berita
                    </button>
                    <a href="{{ url('/berita/' . $berita->slug) }}" target="_blank"
                        style="background: #e8f5e9; color: #1a4d2e; border: none; padding: 11px 18px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="fas fa-eye" style="margin-right: 5px;"></i> Preview
                    </a>
                    <a href="{{ url('/admin/successlogin/berita') }}"
                        style="background: #f0f0f0; color: #555; border: none; padding: 11px 18px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
