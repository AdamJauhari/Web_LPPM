@extends('layout.main')

@section('title', 'Daftar Akun Dosen — LPPM UCA')

@section('container')
<section class="hero-banner d-flex align-items-center" style="background: linear-gradient(135deg, rgba(13, 43, 26, 0.95), rgba(26, 77, 46, 0.9)), url('{{ asset('img/kampus-uca.jpg') }}') center/cover; padding: 60px 0; color: #fff;">
    <div class="container text-center">
        <h2 style="color: #fff; font-weight: 700; margin-bottom: 8px;">Pendaftaran Akun Dosen</h2>
        <p style="color: #d4a94a; margin: 0; font-size: 15px;">Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) UCA</p>
    </div>
</section>

<section class="register-area" style="background: #f4f7f6; padding: 50px 0 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-body p-4 p-md-5">

                        <div class="alert alert-info d-flex align-items-center" style="background: #eef7f2; border: 1px solid #c7e5d3; color: #1a4d2e; border-radius: 12px; font-size: 13.5px; padding: 14px 18px; margin-bottom: 25px;">
                            <i class="fas fa-info-circle fa-2x mr-3" style="color: #c4992a;"></i>
                            <div>
                                <strong>Ketentuan Pendaftaran Dosen:</strong>
                                <p class="mb-0 mt-1" style="font-size: 13px; color: #4a6b55;">Akun Dosen yang didaftarkan akan berstatus <strong>Pending</strong> dan harus disetujui (<strong>Approve</strong>) oleh Administrator LPPM sebelum dapat digunakan untuk masuk ke sistem.</p>
                            </div>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ url('/daftar-dosen') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-user mr-1 text-muted"></i> Nama Lengkap beserta Gelar <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Contoh: Dr. Budi Santoso, M.Kom." style="border-radius: 8px; padding: 10px 14px;">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nidn" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-id-card mr-1 text-muted"></i> NIDN / NUPTK <span class="text-danger">*</span></label>
                                    <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                                           value="{{ old('nidn') }}" placeholder="Contoh: 0012345678" style="border-radius: 8px; padding: 10px 14px;">
                                    @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-envelope mr-1 text-muted"></i> Email Resmi Institusi <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="nama@uca.ac.id" style="border-radius: 8px; padding: 10px 14px;">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fakultas" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-university mr-1 text-muted"></i> Fakultas <span class="text-danger">*</span></label>
                                    <select id="fakultas" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" style="border-radius: 8px; padding: 10px 14px; height: auto;">
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach ($fakultasList as $key => $label)
                                            <option value="{{ $key }}" {{ old('fakultas') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan_fungsional" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-award mr-1 text-muted"></i> Jabatan Fungsional <span class="text-danger">*</span></label>
                                    <select id="jabatan_fungsional" name="jabatan_fungsional" class="form-control @error('jabatan_fungsional') is-invalid @enderror" style="border-radius: 8px; padding: 10px 14px; height: auto;">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatanList as $jabatan)
                                            <option value="{{ $jabatan }}" {{ old('jabatan_fungsional') === $jabatan ? 'selected' : '' }}>{{ $jabatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_fungsional')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-lock mr-1 text-muted"></i> Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimal 8 karakter" style="border-radius: 8px; padding: 10px 14px;">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation" style="font-weight: 600; color: #1a4d2e;"><i class="fas fa-lock mr-1 text-muted"></i> Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                           placeholder="Ulangi password" style="border-radius: 8px; padding: 10px 14px;">
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #1a4d2e, #2d6b42); color: #fff; border-radius: 10px; padding: 12px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px rgba(26, 77, 46, 0.25); border: none;">
                                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Pendaftaran Akun Dosen
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p style="font-size: 13.5px; color: #666;">Sudah memiliki akun terdaftar? <a href="{{ url('/login') }}" style="color: #c4992a; font-weight: 600;">Masuk di sini</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
