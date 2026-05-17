@extends('layout/main')
    
@section('title', 'Penelitian')

@section('container')
    <section class="hero-banner d-flex align-items-center">
        <div class="container text-center">
            <h2>Penelitian</h2>
        </div>
    </section>

    <section class="blog_area area-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        <!-- Deskripsi Halaman Penelitian -->
                        <div style="background: #f0f7f2; border-left: 4px solid #1a4d2e; border-radius: 0 8px 8px 0; padding: 25px 30px; margin-bottom: 35px;">
                            <h4 style="color: #1a4d2e; font-size: 18px; font-weight: 700; margin-bottom: 10px;">
                                <i class="fas fa-flask" style="margin-right: 8px;"></i>Tentang Penelitian
                            </h4>
                            <p style="color: #555; font-size: 14px; line-height: 24px; margin-bottom: 0;">
                                Halaman ini menampilkan daftar kegiatan penelitian yang dilakukan oleh dosen dan peneliti 
                                Universitas Cendekia Abditama. Penelitian yang dipublikasikan mencakup berbagai bidang ilmu 
                                sesuai dengan program studi yang tersedia di universitas. Setiap penelitian telah melalui 
                                proses review dan persetujuan oleh LPPM.
                            </p>
                        </div>

                        @if(Auth::check())
                        <div style="display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap;">
                            <a href="{{ url('/ajukan-penelitian') }}" style="display:inline-flex; align-items:center; gap:6px; background:#1a4d2e; color:#fff; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:.2s;" onmouseover="this.style.background='#2d6b42'" onmouseout="this.style.background='#1a4d2e'">
                                <i class="fas fa-paper-plane"></i> Ajukan Proposal Penelitian
                            </a>
                        </div>
                        @endif

                        @forelse( $researches as $rsc )
                        <article class="blog_item">
                            <div class="blog_item_img">
                                @if ($rsc->thumbnail)
                                    <img class="card-img rounded-0" src="img/penelitian/{{ $rsc->thumbnail }}" alt="">
                                @else
                                    <img class="card-img rounded-0" src="img/blog/causes/causes-2.jpg" alt="">
                                @endif
                                
                                <a href="/penelitian/{{ $rsc->slug }}" class="blog_item_date">
                                    <h3>{{ $rsc->date }}</h3>
                                </a>
                            </div>
                        
                            <div class="blog_details">
                                <a class="d-inline-block" href="/penelitian/{{ $rsc->slug }}">
                                    <h2>{{ $rsc->title }}</h2>
                                </a>
                                <p>{{ $rsc->description }} <a href="/penelitian/{{ $rsc->slug }}" class="blog_item_date">read more</a></p>
                                <ul class="blog-info-link">
                                    <li><i class="far fa-user"></i> {{ $rsc->author }}</li>
                                </ul>
                            </div>
                        </article>
                        @empty
                        <!-- Empty State -->
                        <div style="text-align: center; padding: 60px 30px; background: #fff; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
                            <div style="width: 100px; height: 100px; background: #e8f0eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas fa-microscope" style="font-size: 40px; color: #1a4d2e;"></i>
                            </div>
                            <h4 style="color: #1d1d1d; font-size: 20px; margin-bottom: 12px;">Belum Ada Penelitian</h4>
                            <p style="color: #888; font-size: 14px; max-width: 400px; margin: 0 auto 20px; line-height: 24px;">
                                Saat ini belum ada data penelitian yang dipublikasikan. 
                                Data penelitian akan muncul di sini setelah ditambahkan oleh administrator melalui panel admin.
                            </p>
                            <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                                <a href="{{ url('/') }}" style="color: #fff; background: #1a4d2e; font-size: 13px; font-weight: 600; text-decoration: none; padding: 10px 24px; border-radius: 6px;">
                                    <i class="fas fa-home" style="margin-right: 6px;"></i>Kembali ke Beranda
                                </a>
                                <a href="{{ url('/pengabdian') }}" style="color: #1a4d2e; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #1a4d2e; padding: 10px 24px; border-radius: 6px;">
                                    Lihat Pengabdian →
                                </a>
                            </div>
                        </div>
                        @endforelse
                    
                        <nav class="blog-pagination justify-content-center d-flex">
                            <ul class="pagination">
                                <li class="page-item">
                                    {{ $researches->links() }}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                <li>
                                    <a href="{{ url('/penelitian') }}" class="d-flex">
                                        <p>Penelitian</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/pengabdian') }}" class="d-flex">
                                        <p>Pengabdian Kepada Masyarakat</p>
                                    </a>
                                </li>
                                <li>
                                    <!-- <a href="{{ url('/forkomil-dan-conferences') }}" class="d-flex"> -->
                                        <p>Forum Komunikasi Ilmiah dan Conferences</p>
                                    <!-- </a> -->
                                </li>
                            </ul>
                        </aside>

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h4 class="widget_title">e-Jurnal Universitas Cendekia Abditama</h4>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post1.jpg" alt="post"> -->
                                <div class="media-body">
                                    <a href="https://jurnal.machung.ac.id/index.php/kurawal">
                                        <h5>Kurawal - Jurnal Teknologi, Informasi dan Industri</h5>
                                    </a>
                                    <!-- <p>2020-03-10</p> -->
                                </div>
                            </div>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post2.jpg" alt="post">                               -->
                                <div class="media-body">
                                    <a href="https://jurnal.machung.ac.id/index.php/parsimonia">
                                        <h5>Parsimonia - Jurnal Ekonomi dan Bisnis</h5>
                                    </a>
                                    <!-- <p>2018-08-12</p> -->
                                </div>
                            </div>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post2.jpg" alt="post">                               -->
                                <div class="media-body">
                                    <a href="https://ejournal.mrcpp.machung.ac.id/index.php/ijnp">
                                        <h5>IJNP - Indonesian Journal of Natural Pigments</h5>
                                    </a>
                                    <!-- <p>2019-11-04</p> -->
                                </div>
                            </div>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post2.jpg" alt="post">                               -->
                                <div class="media-body">
                                    <a href="https://jurnal.machung.ac.id/index.php/klausa">
                                        <h5>KLAUSA (Kajian Linguistik, Pembelajaran Bahasa, dan Sastra)</h5>
                                    </a>
                                    <!-- <p>2019-11-04</p> -->
                                </div>
                            </div>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post2.jpg" alt="post">                               -->
                                <div class="media-body">
                                    <a href="https://jurnal.machung.ac.id/index.php/citradirga">
                                        <h5>Citradirga - Jurnal Desain Komunikasi Visual dan Intermedia</h5>
                                    </a>
                                    <!-- <p>2019-11-04</p> -->
                                </div>
                            </div>
                            <div class="media post_item">
                                <!-- <img src="img/blog/popular-post/post2.jpg" alt="post">                               -->
                                <div class="media-body">
                                    <a href="https://jacips.machung.ac.id/">
                                        <h5>JACIPS - Journal of Community Practice and Social Welfare</h5>
                                    </a>
                                    <!-- <p>2019-11-04</p> -->
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

    