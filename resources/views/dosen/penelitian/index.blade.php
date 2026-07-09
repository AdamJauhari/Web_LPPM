@extends('layout.main')
@section('title', 'Pengajuan Penelitian Saya')

@section('main')
<section class="section-padding">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Pengajuan Penelitian</h3>
            <p class="text-muted mb-0">Daftar proposal penelitian yang telah Anda ajukan</p>
        </div>
        <a href="{{ url('/dosen/penelitian/create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i> Ajukan Proposal Baru
        </a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th><th>Judul</th><th>Semester/Tahun</th>
                            <th>Sumber Dana</th><th>Total Dana</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $i => $s)
                        <tr>
                            <td>{{ $submissions->firstItem() + $i }}</td>
                            <td>
                                <strong>{{ Str::limit($s->title, 60) }}</strong>
                                <br><small class="text-muted">{{ $s->research_type }}</small>
                            </td>
                            <td>{{ $s->semester }} {{ $s->tahun }}</td>
                            <td>{{ $s->sumber_dana ?? '-' }}</td>
                            <td>Rp {{ $s->total_dana ? number_format($s->total_dana, 0, ',', '.') : '-' }}</td>
                            <td><span class="badge badge-{{ $s->status_badge }}">{{ $s->status_label }}</span>
                                @if($s->rejection_reason && $s->status === 'rejected')
                                    <br><small class="text-danger">{{ $s->rejection_reason }}</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">
                            Belum ada pengajuan. <a href="{{ url('/dosen/penelitian/create') }}">Ajukan sekarang</a>.
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
