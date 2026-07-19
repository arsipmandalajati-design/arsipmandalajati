<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
        <br>
        <br>
                    <img src="{{ asset('images/logo.png') }}"
                         class="logo-kabupaten">
        
                    <h1 class="judul">
                        E - ARSIP
                    </h1>
        
                    <h2 class="mt-3">
                        Sistem Informasi Pengelolaan Arsip
                    </h2>
        
                    <p class="mt-3">
        
                        Membantu pengelolaan arsip surat masuk,
                        surat keluar, laporan, agenda,
                        serta penyimpanan dokumen digital
                        Kecamatan Mandalajati Kota Bandung.
        
                    </p>
        
                    <div class="arsip-icon">
        
                        📂 📁 📑 📄
        
                    </div>
        
                </div>
        
                <!-- RIGHT -->
                <div class="right-side">
        
                    <h2 class="welcome">
                        Selamat Datang 👋
                    </h2>
        
                    <p class="text-muted mb-4">
                        Silakan login untuk masuk ke sistem.
                    </p>
        
                    <x-auth-session-status
                        class="mb-3"
                        :status="session('status')" />
        
                    <form method="POST"
                          action="{{ route('login') }}">
        
                        @csrf
        <br>
        <br>
        <br>
                        <!-- Email -->
                        <div class="mb-3">
        
                            <label>Email</label>
        
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control"
                                   required
                                   autofocus>
        
                            <x-input-error
                                :messages="$errors->get('email')" />
        
                        </div>
        
                        <!-- Password -->
                        <div class="mb-3">
        
                            <label>Password</label>
        
                            <div class="password-box">
        
                                <input id="password"
                                       type="password"
                                       name="password"
                                       class="form-control"
                                       required>
        
                                <button type="button"
                                        id="togglePassword">
        
                                    👁
        
                                </button>
        
                            </div>
        
                            <x-input-error
                                :messages="$errors->get('password')" />
        
                        </div>
        
                        <!-- Remember -->
                        <div class="remember">
        
                            <label>
        
                                <input type="checkbox"
                                       name="remember">
        
                                Ingat Saya
        
                            </label>
        
                        </div>
        
                        <button class="btn-login">
        
                            <i class="bi bi-box-arrow-in-right"></i>
        
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
                font-family:'Segoe UI',sans-serif;
            }
            
            body{
            
                min-height:100vh;
            
                display:flex;
            
                justify-content:center;
            
                align-items:center;
            
                overflow:hidden;
            
                background-image: radial-gradient(
                circle farthest-corner at 10% 20%,
                rgba(0,105,148,1) 15.6%,
                rgba(0,163,217,1) 51.9%,
                rgba(0,194,226,1) 81%);
            
            }
            
            /* Background */
            
            .login-page{
            
                width:100%;
                height:100vh;
            
                display:flex;
            
                justify-content:center;
            
                align-items:center;
            
                position:relative;
            
            }
            
            /* Bubble */
            
            .circle{
            
                position:absolute;
            
                border-radius:50%;
            
                background:rgba(255,255,255,.12);
            
                backdrop-filter:blur(4px);
            
                animation:float 8s infinite ease-in-out;
            
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
            
            0%{
            transform:translateY(0px);
            }
            
            50%{
            transform:translateY(-25px);
            }
            
            100%{
            transform:translateY(0px);
            }
            
            }
            
            /* Card */
            
            .right-side{

width:52%;

padding:55px;

background:white;

color:#333;

display:flex;

flex-direction:column;

justify-content:center;

}
            .login-wrapper{

display:flex;

width:1050px;

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

.left-side h5{

font-size:25px;

font-weight:bold;

margin-top:20px;

}

.left-side p{

margin-top:20px;

line-height:30px;

opacity:.9;

}

.arsip-icon{

font-size:70px;

margin-top:40px;

animation:float 4s infinite;

}
            
            @keyframes fadeUp{
            
            from{
            
            opacity:0;
            
            transform:translateY(50px);
            
            }
            
            to{
            
            opacity:1;
            
            transform:translateY(0);
            
            }
            
            }
            
            /* Logo */
            
            .logo-kabupaten{
            
            width:150px;
            padding: 5px;
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
            
            opacity:.9;
            
            font-size:15px;
            
            margin-top:8px;
            
            }
            
            .welcome{
            
            font-size:30px;
            
            font-weight:bold;
            
            }

            .right-side label{

font-weight:600;
margin-bottom:8px;
display:block;
color:#444;

}
            
            /* Label */
            
            .form-label{
            
            font-weight:600;
            
            margin-bottom:8px;
            
            }
            
            /* Input */
            
            .form-control{

width:100%;
height:52px;
border-radius:14px;
border:1px solid #dcdcdc;
background:#f8f9fc;
padding:0 18px;
transition:.3s;

}
            
.form-control:focus{

border-color:#4f46e5;
background:white;
box-shadow:0 0 0 4px rgba(79,70,229,.15);

}
            
            /* Password */
            
            .password-box{

position:relative;

}

.password-box button{

position:absolute;
right:15px;
top:50%;
transform:translateY(-50%);
border:none;
background:none;
cursor:pointer;
font-size:18px;
color:#666;

}
            
            /* Remember */
            
            .remember{
            
            margin:18px 0;
            
            font-size:15px;
            
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

}

.btn-login:hover{

transform:translateY(-5px);

box-shadow:0 15px 30px rgba(59,130,246,.35);

}
            
            /* Footer */
            
            .footer-login{

text-align:center;
margin-top:30px;
color:#777;

}
            
            /* Responsive */
            
            @media(max-width:576px){
            
            .login-card{
            
            width:92%;
            
            padding:30px;
            
            }
            
            .judul{
            
            font-size:30px;
            
            }
            
            .welcome{
            
            font-size:24px;
            
            }
            
            }
            @media(max-width:900px){

.login-wrapper{

flex-direction:column;

width:95%;

height:auto;

}

.left-side{

width:100%;

padding:40px;

}

.login-card{

width:100%;

}

}


            
            </style>
            
            <script>

                const toggle=document.getElementById('togglePassword');
                
                const password=document.getElementById('password');
                
                toggle.addEventListener('click',()=>{
                
                if(password.type==="password"){
                
                password.type="text";
                
                toggle.innerHTML="🙈";
                
                }else{
                
                password.type="password";
                
                toggle.innerHTML="👁";
                
                }
                
                });
                
                </script>