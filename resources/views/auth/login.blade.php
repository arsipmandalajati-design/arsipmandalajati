<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#006994">
    <title>Login Arsipedia</title>
</head>
<body>

    <div class="login-page">

        <!-- Bubble Background -->
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>

        <div class="login-wrapper">

            <!-- LEFT -->
            <div class="left-side">
                <img src="/images/logo.png" alt="Logo Kota Bandung" class="logo-kabupaten">

                <h1 class="judul">
                    E - ARSIP
                </h1>

                <h2 class="subjudul">
                    Sistem Informasi Pengelolaan Arsip
                </h2>

                <p class="deskripsi">
                    Membantu pengelolaan arsip surat masuk,
                    surat keluar, laporan, agenda,
                    serta penyimpanan dokumen digital
                    Kecamatan Mandalajati Kota Bandung.
                </p>

                <div class="arsip-icon" aria-hidden="true">
                    📂 📁 📑 📄
                </div>
            </div>

            <!-- RIGHT -->
            <div class="right-side">

                <h2 class="welcome">
                    Selamat Datang 👋
                </h2>

                <p class="sub-welcome">
                    Silakan login untuk masuk ke sistem.
                </p>

                <x-auth-session-status
                    class="mb-3"
                    :status="session('status')" />

                <!-- Alamat relatif supaya otomatis mengikuti https dari domain -->
                <form method="POST" action="/login" class="form-login">

                    @csrf

                    <!-- Email -->
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control"
                               autocomplete="username"
                               inputmode="email"
                               required
                               autofocus>

                        <x-input-error
                            :messages="$errors->get('email')" />
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="password-box">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="form-control"
                                   autocomplete="current-password"
                                   required>

                            <button type="button" id="togglePassword" aria-label="Tampilkan password">
                                👁
                            </button>
                        </div>

                        <x-input-error
                            :messages="$errors->get('password')" />
                    </div>

                    <!-- Remember -->
                    <div class="remember">
                        <label>
                            <input type="checkbox" name="remember">
                            Ingat Saya
                        </label>
                    </div>

                    <button class="btn-login" type="submit">
                        Masuk ke Sistem
                    </button>

                </form>

                <div class="footer-login">
                    © {{ date('Y') }}
                    E - ARSIP
                    <br>
                    Kecamatan Mandalajati
                </div>

            </div>

        </div>

    </div>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',system-ui,-apple-system,Roboto,'Helvetica Neue',Arial,sans-serif;
        }

        html{
            -webkit-text-size-adjust:100%;
        }

        body{
            min-height:100vh;
            min-height:100dvh;
        }

        /* Background */
        .login-page{
            width:100%;
            min-height:100vh;
            min-height:100dvh;
            display:flex;
            justify-content:center;
            align-items:center;
            position:relative;
            overflow:hidden;
            padding:
                max(24px, env(safe-area-inset-top))
                max(16px, env(safe-area-inset-right))
                max(24px, env(safe-area-inset-bottom))
                max(16px, env(safe-area-inset-left));
            background-image: radial-gradient(
                circle farthest-corner at 10% 20%,
                rgba(0,105,148,1) 15.6%,
                rgba(0,163,217,1) 51.9%,
                rgba(0,194,226,1) 81%);
        }

        /* Bubble */
        .circle{
            position:absolute;
            border-radius:50%;
            background:rgba(255,255,255,.12);
            backdrop-filter:blur(4px);
            animation:float 8s infinite ease-in-out;
            pointer-events:none;
        }

        .circle1{
            width:220px;
            height:220px;
            top:-60px;
            left:-60px;
        }

        .circle2{
            width:150px;
            height:150px;
            right:80px;
            top:80px;
        }

        .circle3{
            width:300px;
            height:300px;
            bottom:-120px;
            right:-100px;
        }

        @keyframes float{
            0%{ transform:translateY(0px); }
            50%{ transform:translateY(-25px); }
            100%{ transform:translateY(0px); }
        }

        /* Card */
        .login-wrapper{
            position:relative;
            display:flex;
            width:min(1050px, 100%);
            height:650px;
            overflow:hidden;
            border-radius:35px;
            box-shadow:0 30px 60px rgba(0,0,0,.25);
        }

        .left-side{
            width:48%;
            background:rgba(255,255,255,.12);
            backdrop-filter:blur(20px);
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            padding:50px;
            color:white;
            text-align:center;
        }

        .right-side{
            width:52%;
            padding:55px;
            background:white;
            color:#333;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        /* Logo */
        .logo-kabupaten{
            width:150px;
            max-width:100%;
            height:auto;
            padding:5px;
            margin-bottom:20px;
            filter:drop-shadow(0 8px 20px rgba(0,0,0,.2));
        }

        /* Judul */
        .judul{
            font-size:40px;
            font-weight:bold;
            letter-spacing:2px;
        }

        .subjudul{
            font-size:1.5rem;
            font-weight:700;
            line-height:1.3;
            margin-top:16px;
        }

        .deskripsi{
            margin-top:20px;
            line-height:30px;
            opacity:.9;
        }

        .arsip-icon{
            font-size:70px;
            margin-top:40px;
            animation:float 4s infinite;
        }

        .welcome{
            font-size:30px;
            font-weight:bold;
        }

        .sub-welcome{
            color:#6b7280;
            margin-top:6px;
        }

        .form-login{
            margin-top:36px;
        }

        .field{
            margin-bottom:18px;
        }

        .right-side label{
            font-weight:600;
            margin-bottom:8px;
            display:block;
            color:#444;
        }

        /* Input */
        .form-control{
            width:100%;
            height:52px;
            border-radius:14px;
            border:1px solid #dcdcdc;
            background:#f8f9fc;
            padding:0 18px;
            font-size:16px; /* 16px mencegah iPhone memperbesar halaman saat mengetik */
            color:#222;
            transition:.3s;
        }

        .form-control:focus{
            outline:none;
            border-color:#4f46e5;
            background:white;
            box-shadow:0 0 0 4px rgba(79,70,229,.15);
        }

        /* Password */
        .password-box{
            position:relative;
        }

        .password-box .form-control{
            padding-right:56px;
        }

        .password-box button{
            position:absolute;
            right:4px;
            top:50%;
            transform:translateY(-50%);
            width:44px;
            height:44px;
            border:none;
            background:none;
            cursor:pointer;
            font-size:18px;
            color:#666;
            border-radius:12px;
        }

        .password-box button:focus-visible{
            outline:2px solid #4f46e5;
        }

        /* Remember */
        .remember{
            margin:6px 0 4px;
            font-size:15px;
        }

        .right-side .remember label{
            display:flex;
            align-items:center;
            gap:10px;
            margin:0;
            padding:8px 0;
            font-weight:500;
            cursor:pointer;
        }

        .remember input[type="checkbox"]{
            width:20px;
            height:20px;
            accent-color:#4f46e5;
        }

        /* Button */
        .btn-login{
            width:100%;
            height:56px;
            margin-top:15px;
            border:none;
            border-radius:15px;
            background:linear-gradient(135deg,#4f46e5,#3b82f6);
            color:white;
            font-size:18px;
            font-weight:bold;
            transition:.35s;
            cursor:pointer;
        }

        .btn-login:focus-visible{
            outline:3px solid rgba(79,70,229,.45);
            outline-offset:3px;
        }

        .btn-login:active{
            transform:scale(.98);
        }

        @media (hover:hover){
            .btn-login:hover{
                transform:translateY(-5px);
                box-shadow:0 15px 30px rgba(59,130,246,.35);
            }
        }

        /* Footer */
        .footer-login{
            text-align:center;
            margin-top:30px;
            color:#777;
        }

        /* ---------- Tablet & HP ---------- */
        @media (max-width:900px){
            .login-wrapper{
                flex-direction:column;
                width:100%;
                max-width:520px;
                height:auto;
                border-radius:28px;
            }

            .left-side{
                width:100%;
                padding:32px 24px 28px;
            }

            .right-side{
                width:100%;
                padding:32px 28px 28px;
            }

            .logo-kabupaten{
                width:96px;
                margin-bottom:10px;
            }

            .judul{
                font-size:32px;
            }

            .subjudul{
                font-size:1.15rem;
                margin-top:10px;
            }

            .deskripsi{
                margin-top:14px;
                line-height:1.7;
                font-size:.95rem;
            }

            .arsip-icon{
                font-size:40px;
                margin-top:20px;
            }

            .form-login{
                margin-top:24px;
            }

            .circle2{
                right:20px;
                top:40px;
                width:110px;
                height:110px;
            }

            .circle3{
                width:220px;
                height:220px;
            }
        }

        /* ---------- HP kecil ---------- */
        @media (max-width:576px){
            .login-page{
                align-items:flex-start;
                padding:
                    max(14px, env(safe-area-inset-top))
                    max(12px, env(safe-area-inset-right))
                    max(14px, env(safe-area-inset-bottom))
                    max(12px, env(safe-area-inset-left));
            }

            .login-wrapper{
                margin:auto 0;
                border-radius:24px;
            }

            /* Bagian kiri diringkas supaya form login langsung terlihat */
            .left-side{
                padding:24px 20px 20px;
            }

            .deskripsi,
            .arsip-icon{
                display:none;
            }

            .logo-kabupaten{
                width:72px;
                margin-bottom:8px;
            }

            .judul{
                font-size:26px;
                letter-spacing:1.5px;
            }

            .subjudul{
                font-size:.95rem;
                font-weight:600;
                margin-top:6px;
            }

            .right-side{
                padding:26px 20px 22px;
            }

            .welcome{
                font-size:24px;
            }

            .sub-welcome{
                font-size:.95rem;
            }

            .form-login{
                margin-top:20px;
            }

            .field{
                margin-bottom:14px;
            }

            .form-control{
                height:50px;
            }

            .btn-login{
                height:52px;
                font-size:17px;
            }

            .footer-login{
                margin-top:22px;
                font-size:.9rem;
            }
        }

        /* Hormati pengaturan "kurangi animasi" di perangkat */
        @media (prefers-reduced-motion:reduce){
            .circle,
            .arsip-icon{
                animation:none;
            }

            .btn-login,
            .form-control{
                transition:none;
            }
        }
    </style>

    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        toggle.addEventListener('click', () => {
            if(password.type === "password"){
                password.type = "text";
                toggle.innerHTML = "🙈";
                toggle.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                password.type = "password";
                toggle.innerHTML = "👁";
                toggle.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    </script>
</body>
</html>