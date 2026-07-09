@extends('layout/main')

@section('container')
    <section class="hero-banner d-flex align-items-center">
        <div class="container text-center">
            <h2>Publikasi Penelitian</h2>
        </div>
    </section>

    <section class="blog_area single-post-area area-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
        <div class="single-post">
            <div class="feature-img">
                <img class="img-fluid" src="img/blog/main-blog/m-blog-1.jpg" alt="">
            </div>
            <div class="blog_details">
                <h2>{{ $publications->title }}</h2>
                <ul class="blog-info-link mt-3 mb-4">
                    <li><i class="far fa-user"></i> {{ $publications->author ?: 'Tidak ada informasi penulis' }}</li>
                    <li><i class="far fa-calendar"></i> {{ $publications->date }}</li>
                </ul>
                <div style="background:#f8f9fa; padding:20px; border-radius:8px; border-left:4px solid #1a4d2e; margin-bottom:20px;">
                    <h5 style="color:#1a4d2e; margin-bottom:15px; font-size:16px;">Abstrak</h5>
                    <p class="excert" style="text-align:justify;">{{ $publications->abstract ?: 'Tidak ada abstrak yang tersedia untuk publikasi ini.' }}</p>
                </div>
                
                @if ($publications->file)
                <div style="margin-top: 30px;">
                    <a href="/download/publikasi/{{ $publications->file }}" style="display:inline-flex; align-items:center; gap:8px; background:#1a4d2e; color:#fff; padding:12px 24px; border-radius:6px; font-weight:600; text-decoration:none; transition:.2s;" onmouseover="this.style.background='#2d6b42'" onmouseout="this.style.background='#1a4d2e'">
                        <i class="fas fa-file-download" style="font-size:18px;"></i> Download File Publikasi
                    </a>
                </div>
                @endif
            </div>
        </div>


        <!-- <div class="blog-author">
            <div class="media align-items-center">
                <img src="img/blog/author.png" alt="">
                <div class="media-body">
                    <a href="#">
                        <h4>Harvard milan</h4>
                    </a>
                    <p>Second divided from form fish beast made. Every of seas all gathered use saying you're, he our dominion twon Second divided from</p>
                </div>
            </div>
        </div> -->

        <!-- <div class="comments-area">
            <h4>05 Comments</h4>
            <div class="comment-list">
                <div class="single-comment justify-content-between d-flex">
                    <div class="user justify-content-between d-flex">
                        <div class="thumb">
                            <img src="img/blog/c1.png" alt="">
                        </div>
                        <div class="desc">
                            <p class="comment">
                                Multiply sea night grass fourth day sea lesser rule open subdue female fill which them Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser 
                            </p>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h5>
                                        <a href="#">Emilly Blunt</a>
                                    </h5>
                                    <p class="date">December 4, 2017 at 3:12 pm </p>
                                </div>

                                <div class="reply-btn">
                                    <a href="#" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-list">
                <div class="single-comment justify-content-between d-flex">
                    <div class="user justify-content-between d-flex">
                        <div class="thumb">
                            <img src="img/blog/c2.png" alt="">
                        </div>
                        <div class="desc">
                            <p class="comment">
                                Multiply sea night grass fourth day sea lesser rule open subdue female fill which them Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser 
                            </p>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h5>
                                        <a href="#">Emilly Blunt</a>
                                    </h5>
                                    <p class="date">December 4, 2017 at 3:12 pm </p>
                                </div>

                                <div class="reply-btn">
                                    <a href="#" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-list">
                <div class="single-comment justify-content-between d-flex">
                    <div class="user justify-content-between d-flex">
                        <div class="thumb">
                            <img src="img/blog/c3.png" alt="">
                        </div>
                        <div class="desc">
                            <p class="comment">
                                Multiply sea night grass fourth day sea lesser rule open subdue female fill which them Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser 
                            </p>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h5>
                                        <a href="#">Emilly Blunt</a>
                                    </h5>
                                    <p class="date">December 4, 2017 at 3:12 pm </p>
                                </div>

                                <div class="reply-btn">
                                    <a href="#" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="comment-form">
            <h4>Leave a Reply</h4>
            <form class="form-contact comment_form" action="#" id="commentForm">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control" name="name" id="name" type="text" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control" name="email" id="email" type="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input class="form-control" name="website" id="website" type="text" placeholder="Website">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="button button-contactForm">Send Message</button>
                </div>
            </form>
        </div> -->
            
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

            
        </div>
    </div>
            </div>
        </div>
    </section>
@endsection