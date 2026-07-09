@extends('layout/penelitian')

@section('container')
    <div class="col-lg-8 posts-list">
        <div class="single-post">
            <div class="feature-img">
                @if ($research->thumbnail)
                    <img class="card-img rounded-0" src="../img/penelitian/{{ $research->thumbnail }}" alt="">
                @else
                    <img class="card-img rounded-0" src="../img/blog/causes/causes-2.jpg" alt="">
                @endif
            </div>
            <div class="blog_details">
                <h2>{{ $research->title }}</h2>
                <ul class="blog-info-link mt-3 mb-4">
                    <li><i class="far fa-user"></i> {{ $research->author }}</li>
                    <li><i class="far fa-calendar"></i> {{ $research->date }}</li>
                </ul>
                <p class="excert" style="white-space:pre-line">{{ $research->description }}</p>
            </div>
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

            
        </div>
    </div>
        
@endsection

    