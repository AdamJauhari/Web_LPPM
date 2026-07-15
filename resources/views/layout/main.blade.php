<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/owl-carousel/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/animate-css/animate.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('font-awesome.min.css')}}">
</head>
<body>

    <style>
        html, body { overflow-x: hidden; width: 100%; }
        .navbar-brand-custom { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .navbar-brand-custom img { height: 40px; width: 40px; border-radius: 8px; object-fit: cover; }
        .navbar-brand-custom span { color: #fff; font-size: 22px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        .menu_nav .nav-item .nav-link { position: relative; transition: color 0.3s ease; }
        .menu_nav .nav-item .nav-link:not(.btn-login-nav)::after { content: ''; position: absolute; bottom: 25px; left: 50%; width: 0; height: 2px; background: #c4992a; transition: all 0.3s ease; transform: translateX(-50%); }
        .menu_nav .nav-item:hover .nav-link:not(.btn-login-nav)::after, .menu_nav .nav-item.active .nav-link:not(.btn-login-nav)::after { width: 60%; display: block !important; }
        .btn-login-nav { background: linear-gradient(135deg, #c4992a, #d4a94a) !important; color: #fff !important; border: none !important; border-radius: 22px !important; padding: 8px 22px !important; font-size: 13px !important; font-weight: 600 !important; letter-spacing: 0.5px; transition: all 0.3s ease !important; box-shadow: 0 2px 8px rgba(196, 153, 42, 0.3); line-height: normal !important; margin-top: 20px !important; display: inline-flex !important; align-items: center; gap: 6px; }
        .btn-login-nav:hover { background: linear-gradient(135deg, #d4a94a, #e0bc5e) !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(196, 153, 42, 0.4); }
        @media (max-width: 991px) {
            .menu_nav .nav-item .nav-link:not(.btn-login-nav)::after,
            .menu_nav .nav-item:hover .nav-link:not(.btn-login-nav)::after,
            .menu_nav .nav-item.active .nav-link:not(.btn-login-nav)::after { display: none !important; width: 0 !important; }
            .btn-login-nav { margin-top: 8px !important; margin-bottom: 12px !important; }
        }
    </style>

    <header class="header_area">	
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand-custom" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo-uca.jpg') }}" alt="Logo UCA">
                        <span>LPPM</span>
                    </a>
                    <div class="d-flex align-items-center ml-auto d-lg-none">
                        @if(Auth::check())
                        <div class="nav-item dropdown" style="list-style: none;">
                            <a class="nav-link btn-profile-nav dropdown-toggle" href="#" id="profileDropdownMobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px !important; margin-right: 12px; margin-top: 0 !important;">
                                <i class="fas fa-user-circle"></i> <span class="d-none d-sm-inline">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown" aria-labelledby="profileDropdownMobile" style="position: absolute;">
                                <div class="dropdown-header-profile">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                    <div>
                                        <strong>{{ Auth::user()->name }}</strong>
                                        <small>{{ ucfirst(Auth::user()->role ?? 'mahasiswa') }} — {{ Auth::user()->nim_nip ?? '-' }}</small>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/status-peninjauan') }}"><i class="fas fa-clipboard-check"></i> Status Peninjauan</a>
                                <a class="dropdown-item" href="{{ url('/jurnal-saya') }}"><i class="fas fa-file-alt"></i> Jurnal Saya</a>
                                <a class="dropdown-item" href="{{ url('/data-publikasi') }}"><i class="fas fa-book-open"></i> Data Publikasi</a>
                                <a class="dropdown-item" href="{{ url('/data-pelaksanaan') }}"><i class="fas fa-clipboard-list"></i> Data Pelaksanaan</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/login/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                        @else
                        <a class="btn-login-nav" href="{{ url('/login') }}" style="margin-top: 0 !important; margin-right: 12px !important; padding: 6px 15px !important; margin-bottom: 0 !important;">Login</a>
                        @endif

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/berita') }}">Berita</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/penelitian') }}">Penelitian</a></li> 
                            <li class="nav-item"><a class="nav-link" href="{{ url('/pengabdian') }}">Pengabdian</a></li> 
                            <li class="nav-item"><a class="nav-link" href="{{ url('/publikasi') }}">Publikasi</a></li>
                            @if(Auth::check())
                            <li class="nav-item dropdown d-none d-lg-flex">
                                <a class="nav-link btn-profile-nav dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown" aria-labelledby="profileDropdown">
                                    <div class="dropdown-header-profile">
                                        <i class="fas fa-user-circle fa-2x"></i>
                                        <div>
                                            <strong>{{ Auth::user()->name }}</strong>
                                            <small>{{ ucfirst(Auth::user()->role ?? 'mahasiswa') }} — {{ Auth::user()->nim_nip ?? '-' }}</small>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('/status-peninjauan') }}"><i class="fas fa-clipboard-check"></i> Status Peninjauan</a>
                                    <a class="dropdown-item" href="{{ url('/jurnal-saya') }}"><i class="fas fa-file-alt"></i> Jurnal Saya</a>
                                    <a class="dropdown-item" href="{{ url('/data-publikasi') }}"><i class="fas fa-book-open"></i> Data Publikasi</a>
                                    <a class="dropdown-item" href="{{ url('/data-pelaksanaan') }}"><i class="fas fa-clipboard-list"></i> Data Pelaksanaan</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('/login/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            </li>
                            @else
                            <li class="nav-item d-none d-lg-block"><a class="nav-link btn-login-nav" href="{{ url('/login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @yield('container')

    <footer class="footer-area" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
                    <img src="../img/logo-uca.jpg" alt="" class="img-icon mb-20" style="max-width: 100px; border-radius: 8px;">
                    <p>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT (LPPM) <br>UNIVERSITAS CENDEKIA ABDITAMA</p>
                    <ul>
                        <li><a href="mailto:info@uca.ac.id">Email: info@uca.ac.id</a></li>
                        <li><a href="https://uca.ac.id">Website: uca.ac.id</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ url('/tentang') }}">Tentang LPPM</a></li>
                        <li><a href="{{ url('/berita') }}">Berita</a></li>
                        <li><a href="{{ url('/penelitian') }}">Penelitian</a></li>
                        <li><a href="{{ url('/pengabdian') }}">Pengabdian</a></li>
                        <li><a href="{{ url('/publikasi') }}">Publikasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
                    <h4>Lokasi</h4>
                    <p>Kompleks Pendidikan Islamic Village <br>Jl. Islamic Raya, Kelapa Dua <br>Tangerang - Banten <br>Indonesia</p>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
                    <h4>Tautan</h4>
                    <ul>
                        <li><a href="https://uca.ac.id">Universitas Cendekia Abditama</a></li>
                        <li><a href="http://sinta.ristekbrin.go.id/">SINTA</a></li>
                        <li><a href="http://simlitabmas.ristekdikti.go.id/">SIMLITABMAS</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom row align-items-center text-center text-lg-left no-gutters">
                <p class="footer-text m-0 col-lg-8 col-md-12">Copyright &copy;<script>document.write(new Date().getFullYear());</script> Universitas Cendekia Abditama</p>
                <div class="col-lg-4 col-md-12 text-center text-lg-right footer-social">
                    <a href="https://uca.ac.id"><i class="ti-world"></i></a>
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-instagram"></i></a>
                    <a href="#"><i class="ti-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/popper.js')}}"></script>
    <script src="{{asset('vendors/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('js/waypoints.min.js')}}"></script>
    <script src="{{asset('js/mail-script.js')}}"></script>
    <script src="{{asset('js/contact.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/theme.js')}}"></script>

    {{-- Slow Parallax like uca.ac.id --}}
    <script>
    (function() {
        var overlay = document.querySelector('.home_banner_area .banner_inner .overlay');
        var heroBanner = document.querySelector('.hero-banner');
        var speed = 0.5;
        var ticking = false;

        function onScroll() {
            var scrollY = window.pageYOffset;

            if (overlay) {
                overlay.style.transform = 'translate3d(0, ' + (scrollY * speed) + 'px, 0)';
            }

            if (heroBanner) {
                var rect = heroBanner.getBoundingClientRect();
                if (rect.bottom > 0) {
                    heroBanner.style.backgroundPositionY = 'calc(30% + ' + (scrollY * speed) + 'px)';
                }
            }

            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(onScroll);
                ticking = true;
            }
        }, { passive: true });
    })();
    </script>

</body>
</html>