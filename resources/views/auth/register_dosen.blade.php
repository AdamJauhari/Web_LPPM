@extends('layout.main')

@section('title', 'Daftar Akun Dosen — LPPM UCA')

@section('main')
<section class="register-area section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 mt-5 mb-5">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <h2 class="font-weight-bold" style="color: #0d47a1;">Daftar Akun Dosen</h2>
                            <p class="text-muted">LPPM Universitas Cendekia Abditama</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ url('/daftar-dosen') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name"><strong>Nama Lengkap</strong> <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="Dr. Budi Santoso, M.Kom.">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nidn"><strong>NIDN / NUPTK</strong> <span class="text-danger">*</span></label>
                                    <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                                           value="{{ old('nidn') }}" placeholder="0123456789">
                                    @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email"><strong>Email Resmi Institusi</strong> <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="nama@uca.ac.id">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fakultas"><strong>Fakultas</strong> <span class="text-danger">*</span></label>
                                    <select id="fakultas" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror">
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach ($fakultasList as $key => $label)
                                            <option value="{{ $key }}" {{ old('fakultas') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan_fungsional"><strong>Jabatan Fungsional</strong> <span class="text-danger">*</span></label>
                                    <select id="jabatan_fungsional" name="jabatan_fungsional" class="form-control @error('jabatan_fungsional') is-invalid @enderror">
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
                                    <label for="password"><strong>Password</strong> <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimal 8 karakter">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation"><strong>Konfirmasi Password</strong> <span class="text-danger">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                           placeholder="Ulangi password">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fa fa-user-plus mr-2"></i> Daftar Sekarang
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
