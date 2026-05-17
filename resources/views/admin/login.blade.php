@if(isset(Auth::user()->email))
    <script>window.location="/admin/successlogin";</script>
@endif
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - LPPM UCA</title>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(13, 43, 26, 0.9) 0%, rgba(26, 77, 46, 0.85) 40%, rgba(42, 110, 66, 0.8) 100%), url('{{ asset("img/kampus-uca.jpg") }}') no-repeat center center;
            background-size: cover;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(196, 153, 42, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -40%;
            left: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(26, 77, 46, 0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo img {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .login-logo h2 {
            color: #1a4d2e;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .login-logo p {
            color: #999;
            font-size: 13px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            color: #1a4d2e;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }
        .form-group .input-wrapper {
            position: relative;
        }
        .form-group .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
            transition: color 0.3s;
        }
        .form-group .form-control {
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            padding: 12px 15px 12px 44px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .form-group .form-control:focus {
            border-color: #1a4d2e;
            box-shadow: 0 0 0 3px rgba(26, 77, 46, 0.1);
            background: #fff;
            outline: none;
        }
        .form-group .form-control:focus + i,
        .form-group .input-wrapper:focus-within i {
            color: #1a4d2e;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #1a4d2e, #2a6e42);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 77, 46, 0.3);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #2a6e42, #3a8e52);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 77, 46, 0.4);
        }
        .btn-login:active { transform: translateY(0); }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #999;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .back-link a:hover { color: #1a4d2e; }
        .back-link a i { margin-right: 5px; }
        .alert {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }
        .alert-danger { background: #fef2f2; color: #dc3545; border: 1px solid #fecaca; }
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #ccc;
            font-size: 12px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e8e8;
        }
        .divider span { padding: 0 12px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('img/logo-uca.jpg') }}" alt="Logo UCA">
                <h2>LPPM User</h2>
                <p>Universitas Cendekia Abditama</p>
            </div>

            @if(isset(Auth::user()->email))
                <script>window.location="/admin/successlogin";</script>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <form method="post" action="{{url( '/admin/checklogin' )}}">
                @csrf
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope" style="margin-right: 5px;"></i>Email</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan email Anda" name="email" value="{{ old('email') }}">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock" style="margin-right: 5px;"></i>Password</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan password Anda" name="password">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt" style="margin-right: 6px;"></i>Masuk
                </button>
            </form>

            <div class="back-link">
                <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>