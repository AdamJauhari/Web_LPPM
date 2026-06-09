@extends('layout.main')
@section('title', 'Data Pelaksanaan - LPPM UCA')
@section('container')
<section class="hero-banner d-flex align-items-center">
    <div class="container text-center">
        <h2>Data Pelaksanaan</h2>
    </div>
</section>

<section style="padding: 40px 0 60px; min-height: 60vh; background: #f0f3f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p style="color:#787878; margin:0;">Daftar pelaksanaan penelitian & pengabdian kepada masyarakat</p>
            <a href="{{ url('/data-pelaksanaan/create') }}" class="btn-submit-sm">
                <i class="fas fa-plus" style="margin-right:5px;"></i>Tambah Data
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if($pelaksanaans->count())
        <div class="table-responsive" style="background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <table class="status-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Sumber Dana</th>
                        @if(Auth::user()->role === 'admin')<th>Pengupload</th>@endif
                        <th>Link</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pelaksanaans as $i => $plk)
                <tr>
                    <td>{{ $pelaksanaans->firstItem() + $i }}</td>
                    <td style="max-width:280px;">{{ $plk->judul }}</td>
                    <td>
                        <span class="badge-status {{ $plk->jenis_kegiatan === 'Penelitian' ? 'badge-penelitian' : 'badge-pengabdian' }}">
                            {{ $plk->jenis_kegiatan }}
                        </span>
                    </td>
                    <td>{{ $plk->sumber_dana }}</td>
                    @if(Auth::user()->role === 'admin')<td>{{ $plk->user->name ?? '-' }}</td>@endif
                    <td>
                        @if($plk->url)
                        <a href="{{ $plk->url }}" target="_blank" style="color:#1a4d2e; font-size:12px;"><i class="fas fa-external-link-alt"></i> Lihat</a>
                        @else - @endif
                    </td>
                    <td>
                        <a href="{{ url('/data-pelaksanaan/'.$plk->id.'/edit') }}" class="btn-edit-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('/data-pelaksanaan/'.$plk->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">{{ $pelaksanaans->links() }}</div>
        @else
        <div style="background:#fff; border-radius:12px; padding:50px; text-align:center; color:#aaa; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <i class="fas fa-clipboard-list" style="font-size:48px; margin-bottom:12px;"></i>
            <p>Belum ada data pelaksanaan</p>
        </div>
        @endif
    </div>
</section>

<style>
.btn-submit-sm { background:#1a4d2e; color:#fff; padding:8px 18px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:.2s; display:inline-flex; align-items:center; }
.btn-submit-sm:hover { background:#2d6b42; color:#fff; text-decoration:none; }
.btn-edit-sm { color:#c4992a; font-size:14px; margin-right:6px; }
.btn-delete-sm { background:none; border:none; color:#dc3545; font-size:14px; cursor:pointer; }
.status-table { width:100%; border-collapse:collapse; }
.status-table th { background:#1a4d2e; color:#fff; padding:10px 14px; font-size:12px; text-transform:uppercase; }
.status-table td { padding:10px 14px; border-bottom:1px solid #f0f0f0; font-size:13px; }
.status-table tr:hover { background:rgba(196,153,42,.08); }
.badge-status { padding:4px 12px; border-radius:12px; font-size:11px; font-weight:600; }
.badge-penelitian { background:#d4edda; color:#155724; }
.badge-pengabdian { background:#cce5ff; color:#004085; }
</style>
@endsection
