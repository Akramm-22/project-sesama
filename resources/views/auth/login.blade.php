@extends('layouts.auth')

@section('content')
    <style>
        body {
            background: radial-gradient(circle at top left, #184c9c 0%, #0d2e6e 40%, #09255c 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            background: #fff;
            width: 950px;
            border-radius: 25px;
            display: flex;
            overflow: hidden;
            margin: 60px auto;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
            animation: fadeInUp 0.7s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-left {
            flex: 1;
            padding: 60px 55px;
            background: #fff;
        }

        .login-right {
            flex: 1;
            background: linear-gradient(145deg, #0e3382 0%, #133E87 50%, #09255c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .login-right::before {
            content: "";
            position: absolute;
            top: 0;
            left: -50px;
            width: 80px;
            height: 100%;
            background: linear-gradient(to right, rgba(255, 255, 255, 0.25), transparent);
            filter: blur(8px);
        }

        .login-right img {
            width: 85%;
            max-width: 420px;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.35));
            transition: transform 0.4s ease, filter 0.4s ease;
        }

        .login-right img:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 25px 35px rgba(0, 0, 0, 0.45));
        }

        .login-title {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 10px;
            color: #000;
            letter-spacing: 0.3px;
        }

        .login-subtitle {
            color: #777;
            font-weight: 400;
            font-size: 15px;
            margin-bottom: 35px;
        }

        label.form-label {
            font-weight: 500;
            font-size: 15px;
            margin-bottom: 6px;
            color: #333;
        }

        .form-control {
            border-radius: 12px;
            height: 48px;
            padding-left: 20px;
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .input-group-text {
            position: absolute;
            left: 15px;
            top: 12px;
            border: none;
            background: transparent;
            color: #777;
        }

        .btn-login {
            background-color: #133E87;
            border: none;
            height: 48px;
            font-weight: 500;
            font-size: 16px;
            border-radius: 12px;
            transition: 0.3s ease;
            width: 100%;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(19, 62, 135, 0.4);
        }

        .btn-login:hover {
            background-color: #0b2f6b;
            box-shadow: 0 6px 14px rgba(19, 62, 135, 0.6);
        }

        @media (max-width: 768px) {
            body {
                background: linear-gradient(145deg, #133E87 0%, #0b2f6b 100%);
            }

            .login-wrapper {
                flex-direction: column;
                width: 90%;
            }

            .login-right {
                display: none;
            }
        }
        /* ======================================================
   ✨ PREMIUM LOGIN POLISH (FINAL FINISHING)
======================================================*/

/* Glow brand background effect */
body::after{
    content:"";
    position:fixed;
    inset:0;
    background:
        radial-gradient(circle at 15% 20%,
            rgba(255,255,255,.08),
            transparent 40%),
        radial-gradient(circle at 80% 65%,
            rgba(59,130,246,.15),
            transparent 45%);
    pointer-events:none;
}

/* Floating login card */
.login-wrapper{
    background: linear-gradient(180deg,#ffffff,#f9fafb);
    box-shadow:
        0 25px 55px rgba(0,0,0,.25),
        0 8px 18px rgba(0,0,0,.12);
}

/* Logo depth */
.login-left img{
    filter: drop-shadow(0 6px 12px rgba(0,0,0,.2));
}

/* Subtitle refine */
.login-subtitle{
    opacity:.75;
    letter-spacing:.04em;
}

/* Inputs */
.form-control{
    background:#f8fafc;
    border:1px solid #e2e8f0;
}

.form-control:focus{
    background: white;
    border-color:#2563eb;
}

/* Input icon spacing fix */
.input-group-text{
    left:16px;
}
.form-control{
    padding-left:48px;
}

/* Soft input hover */
.form-control:hover{
    background:#ffffff;
}

/* Login button premium */
.btn-login{
    background: linear-gradient(135deg,#133E87,#2563eb);
    letter-spacing:.08em;
}

.btn-login:hover{
    background: linear-gradient(135deg,#09255c,#133E87);
}

/* Right illustration glow */
.login-right img{
    position:relative;
}
.login-right img::after{
    content:"";
}

/* ================
   MOBILE UPGRADE
================ */
@media (max-width: 768px){
    body{
        background: linear-gradient(155deg,#0e3382,#09255c);
    }

    .login-wrapper{
        border-radius:18px;
    }

    .login-left{
        padding:36px 30px;
    }

    .login-title{
        font-size:20px;
    }

    .login-subtitle{
        font-size:13px;
    }

    .btn-login{
        height:52px;
        font-size:15px;
        letter-spacing:.06em;
    }
}

/* Tap micro interaction */
.btn-login:active{
    transform:scale(.98);
}

    </style>


    <div class="login-wrapper">
        {{-- Kiri: Form Login --}}
        <div class="login-left">
            <div class="text-center mb-4">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Pertamina"
                    style="height: 100px; display:block; margin:0 auto;" class="mb-2"
                    onerror="this.onerror=null;this.src='{{ asset('image/foto.png') }}';">
                <p class="login-subtitle">Masuk ke sistem administrasi Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4 position-relative text-start">
                    <label for="email" class="form-label">Nama Anda</label>
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Masukkan email Anda">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4 position-relative text-start">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                    <span class="position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor:pointer;"
                        onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Tombol Login --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-login">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Kanan: Gambar Ilustrasi --}}
        <div class="login-right">
            <img src="{{ asset('image/foto.png') }}" alt="Ilustrasi Admin"
                onerror="this.onerror=null;this.src='{{ asset('image/logo.png') }}';">
        </div>
    </div>

    {{-- Icon Bootstrap + Script Toggle Password --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
@endsection
