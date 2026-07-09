@extends('layout.main')
@section('title', 'Pengajuan HKI Saya')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold mb-0">Pengajuan HKI Saya</h3>
        <a href="{{ url('/dosen/hki/create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i> Ajukan HKI Baru</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr><th>#</th><th>Judul</th><th>Jenis HKI</th><th>Tahun</th><th>No. Pendaftaran</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $i => $s)
                        <tr>
                            <td>{{ $submissions->firstItem() + $i }}</td>
                            <td><strong>{{ Str::limit($s->judul, 60) }}</strong></td>
                            <td><span class="badge badge-secondary">{{ $s->jenis_hki }}</span></td>
                            <td>{{ $s->tahun_pengajuan }}</td>
                            <td><code>{{ $s->nomor_pendaftaran ?? '-' }}</code></td>
                            <td><span class="badge badge-{{ $s->status_badge }}">{{ $s->status_label }}</span>
                                @if($s->rejection_reason && $s->status === 'rejected')
                                    <br><small class="text-danger">{{ $s->rejection_reason }}</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">
                            Belum ada pengajuan HKI. <a href="{{ url('/dosen/hki/create') }}">Ajukan sekarang</a>.
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($submissions->hasPages())<div class="card-footer">{{ $submissions->links() }}</div>@endif
    </div>
</div>
</section>
@endsection
