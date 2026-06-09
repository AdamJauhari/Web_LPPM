@extends('layout.main')
@section('title', 'Data Publikasi - LPPM UCA')
@section('container')
<section class="hero-banner d-flex align-items-center">
    <div class="container text-center">
        <h2>Data Publikasi</h2>
    </div>
</section>

<section style="padding: 40px 0 60px; min-height: 60vh; background: #f0f3f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p style="color:#787878; margin:0;">Daftar publikasi ilmiah yang telah Anda/dosen input</p>
            <a href="{{ url('/data-publikasi/create') }}" class="btn-submit-sm">
                <i class="fas fa-plus" style="margin-right:5px;"></i>Tambah Publikasi
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if($publikasis->count())
        <div class="table-responsive" style="background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <table class="status-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Kategori Reputasi</th>
                        @if(Auth::user()->role === 'admin')<th>Pengupload</th>@endif
                        <th>Link</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($publikasis as $i => $pub)
                <tr>
                    <td>{{ $publikasis->firstItem() + $i }}</td>
                    <td style="max-width:250px;">{{ $pub->judul }}</td>
                    <td><span class="badge-status {{ $pub->jenis_publikasi === 'Jurnal' ? 'badge-approved' : 'badge-revision' }}">{{ $pub->jenis_publikasi }}</span></td>
                    <td>{{ $pub->kategori_reputasi }}</td>
                    @if(Auth::user()->role === 'admin')<td>{{ $pub->user->name ?? '-' }}</td>@endif
                    <td>
                        @if($pub->url_jurnal)
                        <a href="{{ $pub->url_jurnal }}" target="_blank" style="color:#1a4d2e; font-size:12px;"><i class="fas fa-external-link-alt"></i> Jurnal</a>
                        @endif
                        @if($pub->url_repository)
                        <a href="{{ $pub->url_repository }}" target="_blank" style="color:#c4992a; font-size:12px; margin-left:6px;"><i class="fas fa-database"></i> Repo</a>
                        @endif
                        @if(!$pub->url_jurnal && !$pub->url_repository) - @endif
                    </td>
                    <td>
                        <a href="{{ url('/data-publikasi/'.$pub->id.'/edit') }}" class="btn-edit-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('/data-publikasi/'.$pub->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">{{ $publikasis->links() }}</div>
        @else
        <div style="background:#fff; border-radius:12px; padding:50px; text-align:center; color:#aaa; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <i class="fas fa-book-open" style="font-size:48px; margin-bottom:12px;"></i>
            <p>Belum ada data publikasi</p>
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
.badge-approved { background:#d4edda; color:#155724; }
.badge-revision { background:#cce5ff; color:#004085; }
</style>
@endsection
