@extends('layout/main')
    
@section('title', 'LPPM Cendekia Abditama')

@section('container')
    <!-- Hero Banner -->
    <section class="home_banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="../img/logo-uca.jpg" alt="Logo UCA" style="border-radius: 15px; max-width: 130px; width: 100%;">
                    </div>
                    <div class="col">
                        <div class="banner_content">
                            <h3>Universitas Cendekia Abditama</h3>
                            <h4>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT (LPPM) <br>(Center for Research and Community Service)</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Ringkasan -->
    <section style="padding: 60px 0; background: #fff;">
        <div class="container">
            <div class="row text-center">
                <div class="col-6 col-md-3 mb-4">
                    <div style="padding: 30px 15px; border-radius: 12px; background: #f0f7f2;">
                        <div style="width: 60px; height: 60px; background: #1a4d2e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-flask" style="color: #fff; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 32px; font-weight: 800; margin-bottom: 5px;">{{ count($researches) > 0 ? \App\Researche::count() : 0 }}</h3>
                        <p style="color: #777; font-size: 13px; margin: 0;">Penelitian</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div style="padding: 30px 15px; border-radius: 12px; background: #f0f7f2;">
                        <div style="width: 60px; height: 60px; background: #1a4d2e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-hands-helping" style="color: #fff; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 32px; font-weight: 800; margin-bottom: 5px;">{{ count($comserv) > 0 ? \App\CommunityService::count() : 0 }}</h3>
                        <p style="color: #777; font-size: 13px; margin: 0;">Pengabdian</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div style="padding: 30px 15px; border-radius: 12px; background: #f0f7f2;">
                        <div style="width: 60px; height: 60px; background: #c4992a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-book-open" style="color: #fff; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 32px; font-weight: 800; margin-bottom: 5px;">{{ \App\Publication::count() }}</h3>
                        <p style="color: #777; font-size: 13px; margin: 0;">Publikasi</p>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div style="padding: 30px 15px; border-radius: 12px; background: #f0f7f2;">
                        <div style="width: 60px; height: 60px; background: #c4992a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-user-graduate" style="color: #fff; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 32px; font-weight: 800; margin-bottom: 5px;">{{ \App\Expertise::count() }}</h3>
                        <p style="color: #777; font-size: 13px; margin: 0;">Kepakaran</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang LPPM -->
    <section style="padding: 80px 0; background: #f9fafb;" id="tentang">
        <div class="container">
            <!-- Tentang LPPM -->
            <div class="row mb-5">
                <div class="col-lg-5 mb-4">
                    <div style="background: #1a4d2e; border-radius: 12px; padding: 40px 30px; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                        <img src="../img/logo-uca.jpg" alt="Logo UCA" style="max-width: 120px; border-radius: 12px; margin-bottom: 25px;">
                        <h3 style="color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 15px;">LPPM Universitas Cendekia Abditama</h3>
                        <p style="color: rgba(255,255,255,0.8); font-size: 14px; line-height: 26px;">
                            Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) merupakan unit pengelola kegiatan 
                            penelitian dan pengabdian kepada masyarakat di lingkungan Universitas Cendekia Abditama.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 40px 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <h3 style="color: #1a4d2e; font-size: 22px; font-weight: 700; margin-bottom: 20px;">
                            <i class="fas fa-info-circle" style="margin-right: 10px;"></i>Profil LPPM
                        </h3>
                        <p style="color: #555; font-size: 14px; line-height: 26px; margin-bottom: 15px;">
                            LPPM UCA bertugas mengelola, mengkoordinasikan, memantau, dan menilai pelaksanaan kegiatan 
                            penelitian dan pengabdian kepada masyarakat yang dilakukan oleh dosen dan mahasiswa. 
                            LPPM menjadi wadah bagi pengembangan ilmu pengetahuan, teknologi, dan seni melalui 
                            penelitian yang berkualitas serta pengabdian yang berdampak bagi masyarakat.
                        </p>
                        <p style="color: #555; font-size: 14px; line-height: 26px;">
                            Sebagai lembaga yang berada di bawah Rektor, LPPM bertanggung jawab dalam mendorong 
                            produktivitas riset dan pengabdian yang sejalan dengan Tri Dharma Perguruan Tinggi, 
                            serta memfasilitasi publikasi ilmiah pada jurnal nasional maupun internasional.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="row mb-5">
                <div class="col-lg-6 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 40px 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <i class="fas fa-eye" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 22px; font-weight: 700; margin-bottom: 15px;">Visi</h3>
                        <p style="color: #555; font-size: 14px; line-height: 26px;">
                            Menjadi lembaga penelitian dan pengabdian kepada masyarakat yang unggul, inovatif, dan 
                            berdaya saing dalam pengembangan ilmu pengetahuan, teknologi, dan seni yang bermanfaat 
                            bagi masyarakat serta berkontribusi pada pembangunan nasional.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 40px 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <i class="fas fa-bullseye" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h3 style="color: #1a4d2e; font-size: 22px; font-weight: 700; margin-bottom: 15px;">Misi</h3>
                        <ul style="color: #555; font-size: 14px; line-height: 30px; padding-left: 18px;">
                            <li>Menyelenggarakan penelitian yang berkualitas dan berdaya saing nasional maupun internasional.</li>
                            <li>Melaksanakan pengabdian kepada masyarakat yang berbasis riset dan kebutuhan masyarakat.</li>
                            <li>Memfasilitasi publikasi ilmiah dosen pada jurnal bereputasi.</li>
                            <li>Mengembangkan kerjasama penelitian dengan institusi dalam dan luar negeri.</li>
                            <li>Mendukung perlindungan Hak Kekayaan Intelektual (HKI) hasil penelitian.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Struktur Organisasi -->
            <div class="row">
                <div class="col-12">
                    <div style="background: #fff; border-radius: 12px; padding: 40px 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                        <h3 style="color: #1a4d2e; font-size: 22px; font-weight: 700; margin-bottom: 10px; text-align: center;">
                            <i class="fas fa-sitemap" style="margin-right: 10px;"></i>Struktur Organisasi LPPM
                        </h3>
                        <p style="color: #888; text-align: center; font-size: 14px; margin-bottom: 30px;">Struktur organisasi Lembaga Penelitian dan Pengabdian kepada Masyarakat</p>
                        
                        @php
                            $rektor = $orgMembers->firstWhere('position', 'Rektor');
                            $ketua = $orgMembers->firstWhere('position', 'Ketua LPPM');
                            $divisi = $orgMembers->filter(function($m) { return !in_array($m->position, ['Rektor','Ketua LPPM']); });
                        @endphp

                        <div class="org-chart-wrapper">
                            <!-- Rektor -->
                            <div class="org-chart-node">
                                <div class="org-photo-frame org-photo-compact" style="margin:0 auto 8px;">
                                    @if($rektor && $rektor->photo)
                                    <img src="{{ asset('img/organisasi/' . $rektor->photo) }}" alt="{{ $rektor->name ?? 'Rektor' }}" style="object-position:{{ $rektor->photo_position ?? 'center' }}">
                                    @else
                                    <div class="org-photo-placeholder"><i class="fas fa-user-tie"></i></div>
                                    @endif
                                </div>
                                <div class="org-label org-label-primary">
                                    <i class="fas fa-user-tie" style="margin-right:6px;"></i>Rektor
                                </div>
                                @if($rektor && $rektor->name !== '-')
                                <div class="org-name">{{ $rektor->name }}</div>
                                @endif
                            </div>

                            <!-- Connector line -->
                            <div class="org-connector"></div>

                            <!-- Ketua LPPM -->
                            <div class="org-chart-node">
                                <div class="org-photo-frame org-photo-compact" style="margin:0 auto 8px; border-color:#c4992a;">
                                    @if($ketua && $ketua->photo)
                                    <img src="{{ asset('img/organisasi/' . $ketua->photo) }}" alt="{{ $ketua->name ?? 'Ketua LPPM' }}" style="object-position:{{ $ketua->photo_position ?? 'center' }}">
                                    @else
                                    <div class="org-photo-placeholder"><i class="fas fa-user-graduate"></i></div>
                                    @endif
                                </div>
                                <div class="org-label org-label-gold">
                                    <i class="fas fa-user-graduate" style="margin-right:6px;"></i>Ketua LPPM
                                </div>
                                @if($ketua && $ketua->name !== '-')
                                <div class="org-name">{{ $ketua->name }}</div>
                                @endif
                            </div>

                            <!-- Connector line (gold) -->
                            <div class="org-connector" style="background:#c4992a;"></div>

                            <!-- Divisi Row (horizontal line & vertical branches via CSS) -->
                            <div class="org-divisi-row">
                                @foreach($divisi as $member)
                                <div class="org-divisi-item">
                                    <div class="org-divisi-stem"></div>
                                    <div class="org-divisi-card">
                                        <div class="org-photo-frame org-photo-mini" style="margin:0 auto 8px;">
                                            @if($member->photo)
                                            <img src="{{ asset('img/organisasi/' . $member->photo) }}" alt="{{ $member->name }}" style="object-position:{{ $member->photo_position ?? 'center' }}">
                                            @else
                                            <div class="org-photo-placeholder"><i class="fas fa-user-circle"></i></div>
                                            @endif
                                        </div>
                                        <strong class="org-divisi-title">{{ $member->position }}</strong>
                                        @if($member->name !== '-')
                                        <small class="org-divisi-name">{{ $member->name }}</small>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Utama -->
    <section style="padding: 60px 0; background: #f9fafb;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 32px; color: #1a4d2e; font-weight: 700;">Layanan LPPM</h2>
                <p style="color: #7f7f7f; max-width: 500px; margin: 10px auto 0;">Jelajahi layanan penelitian, pengabdian, dan publikasi ilmiah dari LPPM UCA.</p>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; height: 100%; transition: transform 0.3s;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
                            <i class="fas fa-flask" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 10px;">Penelitian</h5>
                        <p style="color: #777; font-size: 13px; line-height: 22px; margin-bottom: 15px;">Skema, syarat, dan formulir proposal penelitian dosen.</p>
                        <a href="{{ url('/penelitian') }}" style="color: #1a4d2e; font-weight: 600; font-size: 13px; text-decoration: none;">Selengkapnya →</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; height: 100%; transition: transform 0.3s;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
                            <i class="fas fa-hands-helping" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 10px;">Pengabdian</h5>
                        <p style="color: #777; font-size: 13px; line-height: 22px; margin-bottom: 15px;">Galeri, kategori, dan kegiatan pengabdian masyarakat.</p>
                        <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; font-weight: 600; font-size: 13px; text-decoration: none;">Selengkapnya →</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; height: 100%; transition: transform 0.3s;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
                            <i class="fas fa-book-open" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 10px;">Publikasi & HKI</h5>
                        <p style="color: #777; font-size: 13px; line-height: 22px; margin-bottom: 15px;">Jurnal, paten, dan pencarian publikasi ilmiah.</p>
                        <a href="{{ url('/publikasi') }}" style="color: #1a4d2e; font-weight: 600; font-size: 13px; text-decoration: none;">Selengkapnya →</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; height: 100%; transition: transform 0.3s;">
                        <div style="width: 60px; height: 60px; background: #e8f0eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
                            <i class="fas fa-user-graduate" style="color: #1a4d2e; font-size: 24px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 10px;">Kepakaran</h5>
                        <p style="color: #777; font-size: 13px; line-height: 22px; margin-bottom: 15px;">Daftar kepakaran dosen dan peneliti UCA.</p>
                        <a href="{{ url('/kepakaran') }}" style="color: #1a4d2e; font-weight: 600; font-size: 13px; text-decoration: none;">Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan LPPM - Penelitian & Pengabdian Terbaru -->
    <section class="pricing_area" style="padding: 80px 0; background: #fff;">
        <div class="container">
            <style>
            .news-carousel {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 24px;
                margin-bottom: 60px;
            }
            .news-card {
                text-decoration: none !important;
                display: block;
                transition: transform 0.2s;
            }
            .news-card:hover {
                transform: translateY(-4px);
            }
            .news-img {
                width: 100%;
                aspect-ratio: 16/9;
                object-fit: cover;
                margin-bottom: 12px;
                border-radius: 4px;
                background: #e8f0eb;
            }
            .news-title {
                font-size: 15px;
                font-weight: 800;
                color: #000;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .news-section-title {
                font-size: 20px;
                font-weight: 800;
                color: #000;
                text-transform: uppercase;
                margin-bottom: 24px;
                position: relative;
            }
            .news-section-title::after {
                content: '';
                display: block;
                width: 35px;
                height: 4px;
                background: #174261; /* Warna biru gelap ala portal berita */
                margin-top: 10px;
            }
            @media(max-width: 991px) {
                .news-carousel { grid-template-columns: repeat(3, 1fr); }
            }
            @media(max-width: 767px) {
                .news-carousel { grid-template-columns: repeat(2, 1fr); }
            }
            @media(max-width: 575px) {
                .news-carousel { grid-template-columns: 1fr; }
            }
            </style>

            <div class="news-section-title">Semua Kegiatan Terbaru</div>
            
            @php
                $allActivity = collect();
                foreach($berita as $b) {
                    $allActivity->push((object)[
                        'type_label' => 'BERITA',
                        'type_color' => '#17a2b8',
                        'type_url'   => url('/berita/' . $b->slug),
                        'img_path'   => $b->gambar ? 'img/berita/' . $b->gambar : '',
                        'item_title' => $b->judul,
                        'item_desc'  => $b->ringkasan_auto,
                        'item_author'=> $b->penulis,
                        'item_date'  => isset($b->tanggal) ? \Carbon\Carbon::parse($b->tanggal) : \Carbon\Carbon::parse($b->created_at)
                    ]);
                }
                foreach($researches as $rsc) {
                    $allActivity->push((object)[
                        'type_label' => 'PENELITIAN',
                        'type_color' => '#28a745',
                        'type_url'   => url('/penelitian/' . $rsc->slug),
                        'img_path'   => $rsc->thumbnail ? 'img/penelitian/' . $rsc->thumbnail : '',
                        'item_title' => $rsc->title,
                        'item_desc'  => $rsc->ringkasan_auto,
                        'item_author'=> $rsc->penulis ?? $rsc->author,
                        'item_date'  => isset($rsc->tanggal) ? \Carbon\Carbon::parse($rsc->tanggal) : \Carbon\Carbon::parse($rsc->created_at ?? $rsc->date)
                    ]);
                }
                foreach($comserv as $cs) {
                    $allActivity->push((object)[
                        'type_label' => 'PENGABDIAN',
                        'type_color' => '#c4992a',
                        'type_url'   => url('/pengabdian/' . $cs->slug),
                        'img_path'   => $cs->thumbnail ? 'img/pengabdian/' . $cs->thumbnail : '',
                        'item_title' => $cs->title,
                        'item_desc'  => $cs->ringkasan_auto,
                        'item_author'=> $cs->penulis ?? $cs->author,
                        'item_date'  => isset($cs->tanggal) ? \Carbon\Carbon::parse($cs->tanggal) : \Carbon\Carbon::parse($cs->created_at ?? $cs->date)
                    ]);
                }
                // Urutkan dari yang terbaru (kiri) ke terlama (kanan)
                $sortedActivity = $allActivity->sortByDesc(function($item) {
                    return $item->item_date->timestamp;
                })->take(4);
            @endphp

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 60px;" class="kegiatan-grid">
                <style>
                    @media(max-width: 1200px) { .kegiatan-grid { grid-template-columns: repeat(3, 1fr) !important; } }
                    @media(max-width: 991px) { .kegiatan-grid { grid-template-columns: repeat(2, 1fr) !important; } }
                    @media(max-width: 767px) { .kegiatan-grid { grid-template-columns: 1fr !important; } }
                </style>
                
                @forelse($sortedActivity as $item)
                <a href="{{ $item->type_url }}" 
                   style="text-decoration: none; display: flex; flex-direction: column; background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s ease; height: 100%; position: relative; z-index: 1;"
                   onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.12)'"
                   onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.06)'">

                        {{-- Gambar --}}
                        <div style="position: relative; overflow: hidden; height: 190px; background: linear-gradient(135deg, #1a4d2e, #2d6b42); flex-shrink: 0;">
                            @if($item->img_path)
                                <img src="{{ asset($item->img_path) }}" alt="{{ $item->item_title }}"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform=''">
                            @else
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                            {{-- Badge Kategori di Kanan Atas --}}
                            <span style="position: absolute; top: 12px; right: 12px; background: {{ $item->type_color }}; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2;">
                                {{ $item->type_label }}
                            </span>
                        </div>

                        {{-- Konten Card --}}
                        <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                                <i class="fas fa-calendar-alt" style="color: #aaa; font-size: 12px;"></i>
                                <span style="color: #aaa; font-size: 12px;">{{ $item->item_date->translatedFormat('d M Y') }}</span>
                                @if($item->item_author)
                                <span style="color: #ddd;">•</span>
                                <i class="fas fa-user" style="color: #aaa; font-size: 12px;"></i>
                                <span style="color: #aaa; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">{{ explode(',', $item->item_author)[0] ?? $item->item_author }}</span>
                                @endif
                            </div>
                            <h5 style="color: #1a1a1a; font-size: 15px; font-weight: 700; line-height: 1.5; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->item_title }}
                            </h5>
                            <p style="color: #777; font-size: 13px; line-height: 1.6; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit($item->item_desc, 80) }}
                            </p>
                            <div style="margin-top: auto;">
                                <span style="color: #1a4d2e; font-size: 13px; font-weight: 600;">
                                    Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                                </span>
                            </div>
                        </div>
                </a>
                @empty
                <p style="color: #888; grid-column: 1/-1; text-align: center;">Belum ada kegiatan terbaru.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact-section" style="padding: 80px 0; background: #f4f7f5;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 36px; color: #1a4d2e; font-weight: 700;">Hubungi Kami</h2>
                <p style="color: #7f7f7f; max-width: 600px; margin: 10px auto 0;">Silakan hubungi LPPM Universitas Cendekia Abditama untuk informasi lebih lanjut mengenai penelitian dan pengabdian kepada masyarakat.</p>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 35px 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <div class="d-flex mb-4" style="align-items: flex-start;">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 18px;"><i class="fas fa-map-marker-alt" style="color: #1a4d2e; font-size: 20px;"></i></div>
                            <div><h5 style="font-size: 16px; color: #1d1d1d; margin-bottom: 5px; font-weight: 600;">Alamat</h5><p style="color: #7f7f7f; margin-bottom: 0; font-size: 14px;">Kompleks Pendidikan Islamic Village<br>Jl. Islamic Raya, Kelapa Dua<br>Tangerang - Banten, Indonesia</p></div>
                        </div>
                        <div class="d-flex mb-4" style="align-items: flex-start;">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 18px;"><i class="fas fa-envelope" style="color: #1a4d2e; font-size: 20px;"></i></div>
                            <div><h5 style="font-size: 16px; color: #1d1d1d; margin-bottom: 5px; font-weight: 600;">Email</h5><p style="color: #7f7f7f; margin-bottom: 0; font-size: 14px;"><a href="mailto:info@uca.ac.id" style="color: #1a4d2e;">info@uca.ac.id</a></p></div>
                        </div>
                        <div class="d-flex mb-4" style="align-items: flex-start;">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 18px;"><i class="fas fa-globe" style="color: #1a4d2e; font-size: 20px;"></i></div>
                            <div><h5 style="font-size: 16px; color: #1d1d1d; margin-bottom: 5px; font-weight: 600;">Website</h5><p style="color: #7f7f7f; margin-bottom: 0; font-size: 14px;"><a href="https://uca.ac.id" target="_blank" style="color: #1a4d2e;">uca.ac.id</a></p></div>
                        </div>
                        <div class="d-flex" style="align-items: flex-start;">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 18px;"><i class="fas fa-clock" style="color: #1a4d2e; font-size: 20px;"></i></div>
                            <div><h5 style="font-size: 16px; color: #1d1d1d; margin-bottom: 5px; font-weight: 600;">Jam Operasional</h5><p style="color: #7f7f7f; margin-bottom: 0; font-size: 14px;">Senin - Jumat: 08.00 - 16.00 WIB<br>Sabtu - Minggu: Tutup</p></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 mb-4">
                    <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2713968846056!2d106.6167849!3d-6.227905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fd2cd5fdb9ab%3A0xbc6faf50ca31cedd!2sUniversitas%20Cendekia%20Abditama!5e0!3m2!1sid!2sid!4v1778999487607!5m2!1sid!2sid" width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

<style>
/* === Org Chart Layout === */
.org-chart-wrapper {
    text-align: center;
    padding: 10px 0;
}
.org-chart-node {
    display: inline-block;
    margin-bottom: 4px;
}
.org-connector {
    width: 2px;
    height: 20px;
    background: #1a4d2e;
    margin: 0 auto;
}
.org-label {
    padding: 8px 22px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    color: #fff;
    display: inline-block;
}
.org-label-primary { background: #1a4d2e; }
.org-label-gold { background: #c4992a; }
.org-name {
    color: #555;
    font-size: 12px;
    margin-top: 4px;
    font-weight: 500;
}

/* === Divisi Row === */
.org-divisi-row {
    display: flex;
    justify-content: center;
    gap: 24px;
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    padding-top: 2px;
}
/* Horizontal bar across top */
.org-divisi-row::before {
    content: '';
    position: absolute;
    top: 0;
    height: 2px;
    background: #1a4d2e;
    left: calc(100% / 6);
    right: calc(100% / 6);
}

.org-divisi-item {
    flex: 1 1 200px;
    max-width: 240px;
    text-align: center;
}
/* Explicit vertical stem from horizontal bar to card */
.org-divisi-stem {
    width: 2px;
    height: 14px;
    background: #1a4d2e;
    margin: 0 auto;
}

.org-divisi-card {
    background: #e8f0eb;
    border: 2px solid #1a4d2e;
    padding: 16px 12px;
    border-radius: 12px;
    text-align: center;
    transition: transform .3s, box-shadow .3s;
}
.org-divisi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
.org-divisi-title {
    color: #1a4d2e;
    font-size: 13px;
    display: block;
    line-height: 1.3;
}
.org-divisi-name {
    color: #555;
    font-size: 12px;
}

/* === Photo Frames === */
.org-photo-frame {
    border: 3px solid #c4992a;
    border-radius: 16px;
    overflow: hidden;
    background: #1a4d2e;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
    transition: transform .3s, box-shadow .3s;
}
.org-photo-frame:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.2);
}
.org-photo-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.org-photo-compact {
    width: 90px;
    height: 110px;
}
.org-photo-mini {
    width: 70px;
    height: 85px;
}
.org-photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1a4d2e, #2d6b42);
}
.org-photo-placeholder i {
    font-size: 30px;
    color: rgba(255,255,255,.5);
}
.org-photo-mini .org-photo-placeholder i {
    font-size: 24px;
}

/* Responsive */
@media (max-width: 576px) {
    .org-divisi-row {
        flex-direction: column;
        align-items: center;
        gap: 0;
        padding-top: 0;
    }
    .org-divisi-item {
        flex: 0 0 auto;
        width: 100%;
    }
    .org-divisi-row::before { display: none; }
    .org-divisi-stem {
        height: 25px;
    }
}
</style>

@endsection