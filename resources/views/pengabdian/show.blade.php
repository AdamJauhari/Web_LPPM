@extends('layout/main')

@section('title', $comserv->title . ' - Pengabdian LPPM UCA')

@section('container')

{{-- Page Header --}}
<section style="background: linear-gradient(135deg, #1a4d2e 0%, #2d6b42 100%); padding: 50px 0 35px;">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom: 16px;">
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/pengabdian') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">Pengabdian</a></li>
                <li class="breadcrumb-item active" style="color: #c4992a;">{{ Str::limit($comserv->title, 40) }}</li>
            </ol>
        </nav>
        <span style="background: #c4992a; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 14px;">
            {{ $comserv->kategori ?? 'Pengabdian' }}
        </span>
        <h1 style="color: #fff; font-size: 30px; font-weight: 800; line-height: 1.4; margin: 0 0 14px; max-width: 800px;">{{ $comserv->title }}</h1>
        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.75); font-size: 13px;">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ $comserv->tanggal ? $comserv->tanggal->format('d F Y') : \Carbon\Carbon::parse($comserv->created_at)->format('d F Y') }}</span>
            </div>
            @if($comserv->penulis || $comserv->author)
            <div style="display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.75); font-size: 13px;">
                <i class="fas fa-user-edit"></i>
                <span>{{ $comserv->penulis ?? $comserv->author }}</span>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Konten Utama --}}
<section style="padding: 50px 0; background: #f9fafb;">
    <div class="container">
        <div class="row">

            {{-- Konten Pengabdian --}}
            <div class="col-lg-8 mb-4">
                <div style="background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07);">

                    {{-- Gambar Utama --}}
                    @if($comserv->thumbnail)
                    <div style="overflow: hidden; max-height: 420px;">
                        <img src="{{ asset('img/pengabdian/' . $comserv->thumbnail) }}" alt="{{ $comserv->title }}"
                            style="width: 100%; object-fit: cover; max-height: 420px;">
                    </div>
                    @endif

                    {{-- Ringkasan --}}
                    @if($comserv->ringkasan)
                    <div style="padding: 28px 32px 0;">
                        <p style="font-size: 16px; line-height: 1.8; color: #444; border-left: 4px solid #c4992a; padding-left: 16px; margin: 0; font-style: italic;">
                            {{ $comserv->ringkasan }}
                        </p>
                    </div>
                    @endif

                    {{-- Isi Pengabdian --}}
                    <div style="padding: 28px 32px 36px;">
                        <div class="berita-konten" style="font-size: 15px; line-height: 1.9; color: #333;">
                            {!! nl2br(e($comserv->body)) !!}
                        </div>
                    </div>

                    {{-- Footer Card --}}
                    <div style="padding: 16px 32px; border-top: 1px solid #f0f0f0; background: #fafafa; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: #aaa; font-size: 13px;">
                            <i class="fas fa-clock"></i> Dipublikasikan {{ $comserv->tanggal ? $comserv->tanggal->format('d M Y') : \Carbon\Carbon::parse($comserv->created_at)->format('d M Y') }}
                        </span>
                        <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; font-size: 13px; font-weight: 600; text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengabdian
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Pengabdian Terkait --}}
                @if($terkait->isNotEmpty())
                <div style="background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-bottom: 24px;">
                    <h5 style="color: #1a4d2e; font-weight: 700; font-size: 15px; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
                        <i class="fas fa-list-ul" style="color: #c4992a;"></i> Pengabdian Terkait
                    </h5>
                    @foreach($terkait as $item)
                    <a href="{{ url('/pengabdian/' . $item->slug) }}" style="display: flex; gap: 12px; margin-bottom: 16px; text-decoration: none;"
                       onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        <div style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: linear-gradient(135deg, #1a4d2e, #2d6b42);">
                            @if($item->thumbnail)
                                <img src="{{ asset('img/pengabdian/' . $item->thumbnail) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-hands-helping" style="color: rgba(255,255,255,0.4); font-size: 20px;"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p style="color: #222; font-size: 13px; font-weight: 600; line-height: 1.4; margin: 0 0 4px;">{{ Str::limit($item->title, 60) }}</p>
                            <span style="color: #aaa; font-size: 11px;"><i class="fas fa-calendar-alt"></i> {{ $item->tanggal ? $item->tanggal->format('d M Y') : \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Navigasi Kategori --}}
                <div style="background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                    <h5 style="color: #1a4d2e; font-weight: 700; font-size: 15px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
                        <i class="fas fa-tags" style="color: #c4992a;"></i> Kategori Pengabdian
                    </h5>
                    @foreach(\App\CommunityService::where('status', 'published')->whereNotNull('kategori')->distinct()->pluck('kategori') as $kat)
                    @php $count = \App\CommunityService::where('status', 'published')->where('kategori', $kat)->count(); @endphp
                    @if($count > 0)
                    <a href="{{ url('/pengabdian?kategori=' . $kat) }}"
                       style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; text-decoration: none; border-bottom: 1px solid #f5f5f5; color: #555; font-size: 14px;"
                       onmouseover="this.style.color='#1a4d2e'" onmouseout="this.style.color='#555'">
                        <span><i class="fas fa-chevron-right" style="font-size: 10px; color: #c4992a; margin-right: 6px;"></i>{{ $kat }}</span>
                        <span style="background: #f0f4f1; color: #1a4d2e; padding: 2px 8px; border-radius: 10px; font-size: 12px; font-weight: 600;">{{ $count }}</span>
                    </a>
                    @endif
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

@endsection