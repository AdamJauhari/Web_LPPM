@extends('layout/main')
    
@section('title', 'Publikasi Lembaga Penelitian dan Pengabdian Kepada Masyarakat Universitas Cendekia Abditama')

@section('container')
    <section class="hero-banner d-flex align-items-center">
        <div class="container text-center">
            <h2>Publikasi Penelitian</h2>
        </div>
    </section>

    <section class="container mt-5 mb-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Judul</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Abstrak</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publications as $publication)
                    <tr>
                        <td>{{ $publication->title }}</td>
                        <td>{{ $publication->author }}</td>
                        <td>{{ $publication->date }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($publication->abstract, 50) }}</td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <a href="/publikasi/{{ $publication->slug }}" style="display:inline-flex; align-items:center; gap:4px; background:#17a2b8; color:#fff; padding:6px 12px; border-radius:4px; font-size:12px; text-decoration:none;">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                                @if ($publication->file)
                                <a href="/download/publikasi/{{ $publication->file }}" style="display:inline-flex; align-items:center; gap:4px; background:#28a745; color:#fff; padding:6px 12px; border-radius:4px; font-size:12px; text-decoration:none;">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav class="blog-pagination justify-content-center d-flex">
            <ul class="pagination">
                <li class="page-item">
                    {{ $publications->links() }}
                </li>
            </ul>
        </nav>
    </section>

@endsection