@extends('layout.main')
@section('title', 'Luaran SINTA Saya')

@section('main')
<section class="section-padding">
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Luaran Publikasi Saya</h3>
            <p class="text-muted mb-0">Jurnal, Prosiding, Buku, dan HKI yang pernah Anda input</p>
        </div>
        <a href="{{ url('/dosen/luaran-sinta/create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i> Tambah Luaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-3 mb-0">
                    <label class="small text-muted">Jenis</label>
                    <select name="jenis" class="form-control form-control-sm">
                        <option value="">-- Semua Jenis --</option>
                        @foreach(['Jurnal','Prosiding','Buku','HKI'] as $j)
                            <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 mb-0">
                    <label class="small text-muted">Tahun</label>
                    <input type="number" name="tahun" class="form-control form-control-sm"
                           value="{{ request('tahun') }}" placeholder="{{ date('Y') }}" min="2000" max="{{ date('Y') }}">
                </div>
                <div class="form-group col-md-3 mb-0">
                    <label class="small text-muted">Status Verifikasi</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">-- Semua Status --</option>
                        <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Menunggu</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-0">
                    <button type="submit" class="btn btn-secondary btn-sm btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($luarans as $i => $l)
                        <tr>
                            <td>{{ $luarans->firstItem() + $i }}</td>
                            <td>
                                <strong>{{ Str::limit($l->judul, 60) }}</strong>
                                @if($l->doi)
                                    <br><small class="text-muted">DOI: {{ $l->doi }}</small>
                                @endif
                            </td>
                            <td><span class="badge badge-secondary">{{ $l->jenis_publikasi }}</span></td>
                            <td><small>{{ $l->kategori_reputasi }}</small></td>
                            <td>{{ $l->tahun_publikasi ?? '-' }}</td>
                            <td>
                                @if($l->status_verifikasi === 'verified')
                                    <span class="badge badge-success"><i class="fa fa-check mr-1"></i>Terverifikasi</span>
                                @elseif($l->status_verifikasi === 'rejected')
                                    <span class="badge badge-danger"><i class="fa fa-times mr-1"></i>Ditolak</span>
                                    @if($l->catatan_admin)
                                        <br><small class="text-danger">{{ $l->catatan_admin }}</small>
                                    @endif
                                @else
                                    <span class="badge badge-warning text-dark"><i class="fa fa-clock-o mr-1"></i>Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($l->status_verifikasi === 'pending')
                                <a href="{{ url('/dosen/luaran-sinta/'.$l->id.'/edit') }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ url('/dosen/luaran-sinta/'.$l->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus luaran ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada luaran. <a href="{{ url('/dosen/luaran-sinta/create') }}">Tambahkan sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($luarans->hasPages())
        <div class="card-footer">{{ $luarans->links() }}</div>
        @endif
    </div>

</div>
</section>
@endsection
