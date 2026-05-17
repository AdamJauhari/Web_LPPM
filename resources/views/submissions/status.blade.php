@extends('layout.main')
@section('title', 'Status Peninjauan - LPPM UCA')
@section('container')
<section class="hero-banner d-flex align-items-center">
    <div class="container text-center">
        <h2>Status Peninjauan</h2>
    </div>
</section>
<section style="padding: 40px 0 60px; min-height: 60vh; background: #f0f3f0;">
    <div class="container">
        <p style="color:#787878; margin-bottom:24px;">Pantau status ajuan proposal dan jurnal Anda</p>

        @if (session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <!-- Proposal Penelitian -->
        <div class="status-section">
            <h4><i class="fas fa-flask" style="color:#c4992a;"></i> Ajuan Proposal Penelitian</h4>
            @if($proposals->count())
            <div class="table-responsive">
                <table class="status-table">
                    <thead><tr><th>No</th><th>Judul</th><th>Jenis</th><th>Tanggal</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @foreach($proposals as $i => $p)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $p->title }}</td>
                        <td>{{ $p->research_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                        <td><span class="badge-status badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td>{{ $p->admin_notes ?? '-' }}</td>
                        <td>
                            @if($p->status === 'approved')
                            <a href="{{ url('/ajukan-jurnal?proposal_id=' . $p->id . '&title=' . urlencode($p->title)) }}" class="btn-ajukan-jurnal">
                                <i class="fas fa-file-alt"></i> Ajukan Jurnal
                            </a>
                            @else
                            <span style="color:#aaa; font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada ajuan proposal</p></div>
            @endif
        </div>

        <!-- Jurnal Penelitian -->
        <div class="status-section">
            <h4><i class="fas fa-file-alt" style="color:#c4992a;"></i> Ajuan Jurnal Penelitian</h4>
            @if($journals->count())
            <div class="table-responsive">
                <table class="status-table">
                    <thead><tr><th>No</th><th>Judul</th><th>Jurnal Tujuan</th><th>Tanggal</th><th>Status</th><th>Catatan</th></tr></thead>
                    <tbody>
                    @foreach($journals as $i => $j)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $j->title }}</td>
                        <td>{{ $j->journal_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->created_at)->format('d M Y') }}</td>
                        <td><span class="badge-status badge-{{ $j->status }}">{{ ucfirst($j->status) }}</span></td>
                        <td>{{ $j->admin_notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada ajuan jurnal</p></div>
            @endif
        </div>
    </div>
</section>
<style>
.status-section { background:#fff; border-radius:12px; padding:20px; margin-bottom:20px; box-shadow:0 2px 10px rgba(0,0,0,.06); }
.status-section h4 { font-size:16px; color:#1a4d2e; margin-bottom:14px; }
.status-table { width:100%; border-collapse:collapse; }
.status-table th { background:#1a4d2e; color:#fff; padding:10px 14px; font-size:12px; text-transform:uppercase; }
.status-table td { padding:10px 14px; border-bottom:1px solid #f0f0f0; font-size:13px; }
.status-table tr:hover { background:rgba(196,153,42,.08); }
.badge-status { padding:4px 12px; border-radius:12px; font-size:11px; font-weight:600; }
.badge-pending { background:#fff3cd; color:#856404; }
.badge-approved { background:#d4edda; color:#155724; }
.badge-rejected { background:#f8d7da; color:#721c24; }
.badge-revision { background:#cce5ff; color:#004085; }
.empty-state { text-align:center; padding:30px; color:#aaa; }
.empty-state i { font-size:36px; margin-bottom:8px; }
.btn-ajukan-jurnal {
    display:inline-flex; align-items:center; gap:5px;
    background:#c4992a; color:#fff; padding:5px 14px; border-radius:6px;
    font-size:12px; font-weight:600; text-decoration:none; transition:.2s; white-space:nowrap;
}
.btn-ajukan-jurnal:hover { background:#d4a94a; color:#fff; text-decoration:none; }
</style>
@endsection
