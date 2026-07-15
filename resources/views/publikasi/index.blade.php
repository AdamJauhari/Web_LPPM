@extends('layout/main')
    
@section('title', 'Publikasi Lembaga Penelitian dan Pengabdian Kepada Masyarakat Universitas Cendekia Abditama')

@section('container')
    <section class="hero-banner" style="padding: 160px 0 100px; min-height: auto;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" style="margin-bottom: 12px;">
                        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">Beranda</a></li>
                            <li class="breadcrumb-item active" style="color: #c4992a;">Publikasi</li>
                        </ol>
                    </nav>
                    <h1 style="color: #fff; font-size: 36px; font-weight: 800; margin: 0 0 10px;">Publikasi Penelitian</h1>
                    <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 15px;">Daftar jurnal dan publikasi ilmiah LPPM UCA</p>
                </div>
                <div class="col-lg-4 text-right d-none d-lg-block">
                    <i class="fas fa-book" style="font-size: 80px; color: rgba(255,255,255,0.12);"></i>
                </div>
            </div>
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