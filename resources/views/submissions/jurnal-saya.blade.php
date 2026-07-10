@extends('layout.main')
@section('title', 'Jurnal Saya - LPPM UCA')
@section('container')
<section class="hero-banner d-flex align-items-center">
    <div class="container text-center">
        <h2>Jurnal Saya</h2>
    </div>
</section>
<section style="padding: 40px 0 60px; min-height: 60vh; background: #f0f3f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p style="color:#787878; margin:0;">Daftar jurnal yang telah Anda ajukan</p>
            <a href="{{ url('/ajukan-jurnal') }}" class="btn-submit-sm">
                <i class="fas fa-plus" style="margin-right:5px;"></i>Ajukan Jurnal
            </a>
        </div>

        @if($journals->count())
        <div class="table-responsive" style="background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <table class="status-table">
                <thead><tr><th>No</th><th>Judul</th><th>Jurnal Tujuan</th><th>Penulis</th><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($journals as $i => $j)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $j->title }}</td>
                    <td>{{ $j->journal_name }}</td>
                    <td>{{ $j->authors ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($j->created_at)->format('d M Y') }}</td>
                    <td><span class="badge-status badge-{{ $j->status }}">{{ ucfirst($j->status) }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="background:#fff; border-radius:12px; padding:50px; text-align:center; color:#aaa; box-shadow:0 2px 10px rgba(0,0,0,.06);">
            <i class="fas fa-inbox" style="font-size:48px; margin-bottom:12px;"></i>
            <p>Belum ada jurnal yang diajukan</p>
            <p style="font-size:12px;">Ajukan jurnal melalui halaman <a href="{{ url('/status-peninjauan') }}" style="color:#c4992a; font-weight:600;">Status Peninjauan</a> setelah proposal disetujui</p>
        </div>
        @endif
    </div>
</section>
<style>
.btn-submit-sm { background:#1a4d2e; color:#fff; padding:8px 18px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:.2s; }
.btn-submit-sm:hover { background:#2d6b42; color:#fff; text-decoration:none; }
.status-table { width:100%; border-collapse:collapse; }
.status-table th { background:#1a4d2e; color:#fff; padding:10px 14px; font-size:12px; text-transform:uppercase; }
.status-table td { padding:10px 14px; border-bottom:1px solid #f0f0f0; font-size:13px; }
.status-table tr:hover { background:rgba(196,153,42,.08); }
.badge-status { padding:4px 12px; border-radius:12px; font-size:11px; font-weight:600; }
.badge-pending { background:#fff3cd; color:#856404; }
.badge-approved { background:#d4edda; color:#155724; }
.badge-rejected { background:#f8d7da; color:#721c24; }
.badge-revision { background:#cce5ff; color:#004085; }
</style>
@endsection
