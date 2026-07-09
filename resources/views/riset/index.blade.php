@extends('layout/main')
    
@section('title', 'Daftar Riset Lembaga Penelitian dan Pengabdian Kepada Masyarakat Universitas Cendekia Abditama')

@section('container')
    <section class="hero-banner d-flex align-items-center">
        <div class="container text-center">
            <h2>Daftar Riset</h2>
        </div>
    </section>

    <section class="blog_area area-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">                        
                        <article class="blog_item">
                            <div class="blog_item_img">
                            <img class="card-img rounded-0" src="img/blog/main-blog/m-blog-1.jpg" alt="">
                            <a href="/riset/judul-riset" class="blog_item_date">
                                <h3>2019-10-09 </h3>
                            </a>
                            </div>
                        
                            <div class="blog_details">
                                <a class="d-inline-block" href="/riset/judul-riset">
                                    <h2>Judul Riset</h2>
                                </a>
                                <p>Deskripsi Riset<a href="/riset/judul-riset" class="blog_item_date"> read more</a></p>
                                <ul class="blog-info-link">
                                    <li><i class="far fa-user"></i> Penemu</li>
                                </ul>
                            </div>
                        </article>
                    
                        <nav class="blog-pagination justify-content-center d-flex">
                            <ul class="pagination">
                                <li class="page-item">
                                    1
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
                                        <p>(5)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/pengabdian-kepada-masyarakat') }}" class="d-flex">
                                        <p>Pengabdian Kepada Masyarakat</p>
                                        <p>(10)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/forkomil-dan-conferences') }}" class="d-flex">
                                        <p>Forum Komunikasi Ilmiah dan Conferences</p>
                                        <p>(3)</p>
                                    </a>
                                </li>
                            </ul>
                        </aside>

                        
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection