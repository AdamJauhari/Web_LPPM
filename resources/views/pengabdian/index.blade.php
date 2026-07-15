@extends('layout/main')

@section('title', 'Pengabdian LPPM - Universitas Cendekia Abditama')

@section('container')

{{-- Page Header --}}
<section class="hero-banner" style="padding: 120px 0 60px; min-height: auto;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" style="margin-bottom: 12px;">
                    <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">Beranda</a></li>
                        <li class="breadcrumb-item active" style="color: #c4992a;">Pengabdian</li>
                    </ol>
                </nav>
                <h1 style="color: #fff; font-size: 36px; font-weight: 800; margin: 0 0 10px;">Berita Pengabdian LPPM</h1>
                <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 15px;">Informasi terkini seputar kegiatan dan pengabdian masyarakat LPPM UCA</p>
            </div>
            <div class="col-lg-4 text-right d-none d-lg-block">
                <i class="fas fa-hands-helping" style="font-size: 80px; color: rgba(255,255,255,0.12);"></i>
            </div>
        </div>
    </div>
</section>

{{-- Filter Bar --}}
<section style="background: #fff; padding: 24px 0; border-bottom: 1px solid #eee; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <div class="container">
        <form method="GET" action="{{ url('/pengabdian') }}" class="d-flex flex-wrap align-items-center gap-2" style="gap: 12px;">
            {{-- Pencarian --}}
            <div style="flex: 1; min-width: 220px; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pengabdian..."
                    style="width: 100%; padding: 9px 12px 9px 36px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            {{-- Filter Kategori --}}
            <select name="kategori" style="padding: 9px 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; color: #555; outline: none; background: #fff;">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <button type="submit" style="background: #1a4d2e; color: #fff; border: none; padding: 9px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-filter"></i> Filter
            </button>
            @if(request('q') || request('kategori'))
            <a href="{{ url('/pengabdian') }}" style="color: #888; font-size: 13px; text-decoration: none; padding: 9px 10px;"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</section>

{{-- Daftar Pengabdian --}}
<section style="padding: 50px 0; background: #f9fafb; min-height: 60vh;">
    <div class="container">

        @if($comserv->isEmpty())
        <div style="text-align: center; padding: 80px 0; color: #aaa;">
            <i class="fas fa-hands-helping" style="font-size: 60px; margin-bottom: 16px; display: block; color: #ddd;"></i>
            <h4 style="color: #bbb; font-weight: 500;">Belum ada pengabdian yang tersedia.</h4>
            @if(request('q') || request('kategori'))
            <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; text-decoration: none; font-size: 14px; margin-top: 8px; display: inline-block;">← Lihat semua pengabdian</a>
            @endif
        </div>
        @else

        <div class="row">
            @foreach($comserv as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ url('/pengabdian/' . $item->slug) }}" style="text-decoration: none; display: block; height: 100%;">
                    <div style="background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column;"
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.12)'"
                         onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.06)'">

                        {{-- Gambar --}}
                        <div style="position: relative; overflow: hidden; height: 190px; background: linear-gradient(135deg, #1a4d2e, #2d6b42);">
                            @if($item->thumbnail)
                                <img src="{{ asset('img/pengabdian/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform=''">
                            @else
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-hands-helping" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                            {{-- Badge Kategori --}}
                            <span style="position: absolute; top: 12px; left: 12px; background: #c4992a; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $item->kategori ?? 'Pengabdian' }}
                            </span>
                        </div>

                        {{-- Konten Card --}}
                        <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                                <i class="fas fa-calendar-alt" style="color: #aaa; font-size: 12px;"></i>
                                <span style="color: #aaa; font-size: 12px;">{{ $item->tanggal ? $item->tanggal->format('d M Y') : \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                @if($item->penulis || $item->author)
                                <span style="color: #ddd;">•</span>
                                <i class="fas fa-user" style="color: #aaa; font-size: 12px;"></i>
                                <span style="color: #aaa; font-size: 12px;">{{ $item->penulis ?? $item->author }}</span>
                                @endif
                            </div>
                            <h5 style="color: #1a1a1a; font-size: 15px; font-weight: 700; line-height: 1.5; margin-bottom: 10px; flex: 1;">
                                {{ Str::limit($item->title, 70) }}
                            </h5>
                            <p style="color: #777; font-size: 13px; line-height: 1.6; margin-bottom: 16px;">
                                {{ $item->ringkasan_auto }}
                            </p>
                            <div style="margin-top: auto;">
                                <span style="color: #1a4d2e; font-size: 13px; font-weight: 600;">
                                    Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $comserv->links() }}
        </div>

        @endif
    </div>
</section>

@endsection