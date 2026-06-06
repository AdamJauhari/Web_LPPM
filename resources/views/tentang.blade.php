@extends('layout/main')
    
@section('title', 'Tentang LPPM - Universitas Cendekia Abditama')

@section('container')
    <section class="hero-banner d-flex align-items-center">
        <div class="container text-center">
            <h2>Tentang LPPM</h2>
        </div>
    </section>

    <section style="padding: 80px 0; background: #f9fafb;">
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
            <div class="row mb-5">
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

            <!-- Tugas & Fungsi -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%; text-align: center;">
                        <div style="width: 70px; height: 70px; background: #e8f0eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-search" style="color: #1a4d2e; font-size: 28px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 12px;">Penelitian</h5>
                        <p style="color: #777; font-size: 13px; line-height: 24px;">Mengelola dan memfasilitasi kegiatan penelitian dosen serta mendorong publikasi ilmiah pada jurnal nasional dan internasional bereputasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%; text-align: center;">
                        <div style="width: 70px; height: 70px; background: #e8f0eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-users" style="color: #1a4d2e; font-size: 28px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 12px;">Pengabdian</h5>
                        <p style="color: #777; font-size: 13px; line-height: 24px;">Mengkoordinasikan program pengabdian kepada masyarakat yang berbasis riset untuk memberikan kontribusi nyata pada permasalahan sosial.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div style="background: #fff; border-radius: 12px; padding: 30px 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%; text-align: center;">
                        <div style="width: 70px; height: 70px; background: #e8f0eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-certificate" style="color: #1a4d2e; font-size: 28px;"></i>
                        </div>
                        <h5 style="color: #1a4d2e; font-weight: 700; margin-bottom: 12px;">Publikasi & HKI</h5>
                        <p style="color: #777; font-size: 13px; line-height: 24px;">Mendukung perlindungan Hak Kekayaan Intelektual atas hasil riset berupa paten, hak cipta, dan pencatatan karya intelektual lainnya.</p>
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
        gap: 10px;
        padding-top: 0;
    }
    .org-divisi-row::before { display: none; }
    .org-divisi-item::before { display: none; }
}
</style>

@endsection
