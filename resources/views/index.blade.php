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
            <div class="text-center mb-5">
                <h2 style="font-size: 32px; color: #1a4d2e; font-weight: 700;">Kegiatan Terbaru</h2>
                <p style="color: #7f7f7f; max-width: 600px; margin: 10px auto 0;">Penelitian dan pengabdian terbaru dari dosen dan peneliti Universitas Cendekia Abditama.</p>
            </div>
            <div class="row">   
                <div class="col-sm-6 col-lg-6 mb-4">
                    <div style="background: #f9fafb; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <div class="d-flex align-items-center mb-4">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                <i class="fas fa-flask" style="color: #1a4d2e; font-size: 20px;"></i>
                            </div>
                            <div>
                                <a href="{{ url('/penelitian') }}" style="color: #1a4d2e; font-weight: 700; font-size: 20px; text-decoration: none;">Penelitian</a>
                                <p style="color: #7f7f7f; margin: 0; font-size: 13px;">Riset ilmiah dosen & peneliti UCA</p>
                            </div>
                        </div>
                        <hr style="border-color: #e8f0eb;">
                        @forelse( $researches as $rsc )
                        <div style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                            <a href="/penelitian/{{ $rsc->slug }}" style="color: #1d1d1d; font-size: 15px; font-weight: 500; text-decoration: none; display: block; margin-bottom: 4px;">{{ $rsc->title }}</a>
                            <span style="color: #999; font-size: 12px;"><i class="far fa-calendar-alt" style="margin-right: 5px;"></i>{{ $rsc->date }} &bull; {{ $rsc->author }}</span>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-book-open" style="font-size: 40px; color: #d4e2d9; margin-bottom: 15px;"></i>
                            <p style="color: #aaa; margin-bottom: 15px; font-size: 14px;">Belum ada data penelitian yang dipublikasikan.<br>Data akan tampil setelah ditambahkan melalui panel admin.</p>
                            <a href="{{ url('/penelitian') }}" style="color: #1a4d2e; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #1a4d2e; padding: 8px 20px; border-radius: 6px;">Lihat Halaman Penelitian →</a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6 mb-4">
                    <div style="background: #f9fafb; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%;">
                        <div class="d-flex align-items-center mb-4">
                            <div style="min-width: 50px; height: 50px; background: #e8f0eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                <i class="fas fa-hands-helping" style="color: #1a4d2e; font-size: 20px;"></i>
                            </div>
                            <div>
                                <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; font-weight: 700; font-size: 20px; text-decoration: none;">Pengabdian</a>
                                <p style="color: #7f7f7f; margin: 0; font-size: 13px;">Pengabdian kepada masyarakat UCA</p>
                            </div>
                        </div>
                        <hr style="border-color: #e8f0eb;">
                        @forelse( $comserv as $cs )
                        <div style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                            <a href="/pengabdian/{{ $cs->slug }}" style="color: #1d1d1d; font-size: 15px; font-weight: 500; text-decoration: none; display: block; margin-bottom: 4px;">{{ $cs->title }}</a>
                            <span style="color: #999; font-size: 12px;"><i class="far fa-calendar-alt" style="margin-right: 5px;"></i>{{ $cs->date }} &bull; {{ $cs->author }}</span>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-users" style="font-size: 40px; color: #d4e2d9; margin-bottom: 15px;"></i>
                            <p style="color: #aaa; margin-bottom: 15px; font-size: 14px;">Belum ada data pengabdian yang dipublikasikan.<br>Data akan tampil setelah ditambahkan melalui panel admin.</p>
                            <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #1a4d2e; padding: 8px 20px; border-radius: 6px;">Lihat Halaman Pengabdian →</a>
                        </div>
                        @endforelse
                    </div>
                </div>
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

@endsection