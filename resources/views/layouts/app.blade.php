@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>E-Arsip Kecamatan Mandalajati</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>

/*=================================================
E-ARSIP KECAMATAN MANDALAJATI
Premium Dashboard V2
=================================================*/

:root{

--primary:#003844;
--secondary:#c6ddf0;

--primary-hover:#002c36;

--bg:#eef5fb;

--white:#ffffff;

--border:#d9e7f2;

--text:#2f3e46;

--shadow:
0 10px 30px rgba(0,56,68,.08);

--shadow-hover:
0 18px 35px rgba(0,56,68,.12);

--radius:20px;

}

/*========================================
RESET
========================================*/

*{

margin:0;
padding:0;
box-sizing:border-box;

}

html{

scroll-behavior:smooth;

}

body{

    font-family:'Poppins',sans-serif;

background:#edf4fa;

color:var(--text);

overflow-x:hidden;

transition:.35s;

}

/*========================================
SCROLLBAR
========================================*/

::-webkit-scrollbar{

width:10px;

}

::-webkit-scrollbar-track{

background:#eef2f7;

}

::-webkit-scrollbar-thumb{

    background:#7aa9cf;

border-radius:30px;

}

::-webkit-scrollbar-thumb:hover{

    background:#003844;

}

/*========================================
LINK
========================================*/

a{

text-decoration:none;

transition:.3s;

}

/*========================================
IMAGE
========================================*/

img{

max-width:100%;

display:block;

}

/*========================================
SIDEBAR
========================================*/

.sidebar{

position:fixed;

top:0;

left:0;

width:270px;

height:100vh;

background:#003844;

border-right:none;

display:flex;

flex-direction:column;

box-shadow:var(--shadow);

z-index:1;

overflow:hidden;

}

/*========================================
LOGO
========================================*/

.logo{

display:flex;

align-items:center;

gap:15px;

padding:25px;

border-bottom:1px solid var(--border);

}

.logo img{

width:55px;

height:55px;

object-fit:contain;

}

.logo-title{

display:flex;

flex-direction:column;

}

.logo-title h4{

font-size:20px;

font-weight:700;

color:white;

margin:0;

}

.logo-title small{

font-size:12px;

color:#c6ddf0;

}

/*========================================
SIDEBAR MENU
========================================*/

.sidebar-menu{

flex:1;

overflow-y:auto;

padding:18px;

}

.sidebar-menu::-webkit-scrollbar{

width:5px;

}

.sidebar-menu::-webkit-scrollbar-thumb{

    background:#7aa9cf;

border-radius:30px;

}

.sidebar-menu>a{

display:flex;

justify-content:space-between;

align-items:center;

padding:13px 15px;

margin-bottom:8px;

border-radius:14px;

color:white;

font-weight:500;

}

.sidebar-menu>a span{

display:flex;

align-items:center;

gap:12px;

}

.sidebar-menu>a i{

font-size:18px;

}

.sidebar-menu>a:hover{

    background:rgba(198,221,240,.15);

color:white;

transform:translateX(5px);

}

.sidebar-menu>a.active{

    background:#c6ddf0;

color:#003844;

font-weight:600;

box-shadow:0 12px 25px rgba(0,56,68,.18);

}

.sidebar-menu>a.active i{

color:white;

}

/*========================================
SUBMENU
========================================*/

.sidebar-menu .collapse{

margin-top:5px;

margin-bottom:10px;

}

.sidebar-menu .collapse a{

display:flex;
align-items:center;
gap:12px;
padding:11px 15px 11px 48px;
border-radius:10px;
font-size:14px;
color:#d9ebf8;
margin-bottom:4px;
transition:.3s;

}

.sidebar-menu .collapse a:hover{

background:rgba(198,221,240,.15);
color:#ffffff;

}

.sidebar-menu .collapse a.active{

background:#c6ddf0;
color:#003844;
font-weight:600;

}

/*========================================
PROFILE
========================================*/

.profile-box{

    padding:20px;
border-top:1px solid rgba(255,255,255,.15);
background:#003844;

}

.profile-box img{

width:55px;

height:55px;

border-radius:50%;

object-fit:cover;

border:3px solid #dff5ef;

}

.profile-box strong{

    font-size:15px;
display:block;
color:white;

}

.profile-box small{

    color:#c6ddf0;

}

/*========================================
MAIN CONTENT
========================================*/

.main-content{

margin-left:270px;

width:calc(100% - 270px);

min-height:100vh;

padding:30px;

background:#edf4fa;

}

/*=========================================
TOPBAR
=========================================*/

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    padding:15px 25px;

    background:rgba(255,255,255,.75);
    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);

    border:1px solid rgba(198,221,240,.8);
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,56,68,.08);

    position:relative;
    z-index:9999;
}

/*==========================================
PAGE HEADER
==========================================*/

.page-header{

background:linear-gradient(135deg,#003844 0%, #0b4f60 100%);

border-radius:25px;

padding:35px;

color:white;

box-shadow:0 18px 35px rgba(0,56,68,.18);

margin-bottom:30px;

overflow:hidden;

position:relative;

animation:slideDown .6s ease;

}

.page-header::before{

content:"";

position:absolute;

width:320px;

height:320px;

right:-120px;

top:-120px;

border-radius:50%;

background:rgba(255,255,255,.07);

}

.page-header::after{

content:"";

position:absolute;

width:180px;

height:180px;

left:-60px;

bottom:-60px;

border-radius:50%;

background:rgba(255,255,255,.05);

}
@keyframes slideDown{

from{

opacity:0;

transform:translateY(-20px);

}

to{

opacity:1;

transform:translateY(0);

}

}

.header-icon{

width:75px;

height:75px;

border-radius:20px;

background:rgba(255,255,255,.15);

display:flex;

justify-content:center;

align-items:center;

font-size:32px;

}

.header-shape{

font-size:90px;

opacity:.12;

}

.page-header h2{

font-size:34px;

font-weight:700;

margin-bottom:10px;

letter-spacing:.5px;

}

.page-header h5{

margin-top:8px;

font-weight:600;

}

.page-header p{

font-size:15px;

opacity:.92;

max-width:620px;

line-height:1.8;

margin:0;

}

.page-header-icon{

width:90px;

height:90px;

border-radius:22px;

background:rgba(255,255,255,.15);

display:flex;

justify-content:center;

align-items:center;

font-size:40px;

backdrop-filter:blur(8px);

}

.page-header .d-flex{

justify-content:space-between;

align-items:center;

}

.page-title{

font-size:30px;

font-weight:700;

color:#003844;

letter-spacing:.5px;

margin:0;

}

.breadcrumb{

background:transparent;

padding:0;

margin-top:5px;

}

.breadcrumb-item{

font-size:14px;

}

.breadcrumb-item a{

color:#5f7487;

font-weight:500;
}

.breadcrumb-item.active{

    color:#003844;

font-weight:600;

}

/*========================*/

.dropdown{
    position:relative;
}

.dropdown-menu{
    z-index:99999 !important;

border:none;

border-radius:18px;

box-shadow:0 15px 40px rgba(0,0,0,.08);
    z-index:99999 !important;
}

.dropdown-item{

padding:12px 18px;

transition:.25s;

}

.dropdown-item:hover{

background:#effcf9;

color:var(--secondary);

}

.fade-up{

animation:fadeUp .45s ease;

}

@keyframes fadeUp{

from{

opacity:0;

transform:translateY(18px);

}

to{

opacity:1;

transform:translateY(0);

}

}

/*==================================
BUTTON
==================================*/

.btn{

border:none;

border-radius:14px;

font-weight:600;

padding:10px 20px;

transition:all .3s ease;

box-shadow:0 5px 15px rgba(0,56,68,.08);

}

.btn:hover{

transform:translateY(-3px);

box-shadow:0 10px 25px rgba(0,56,68,.15);

}

.btn-primary{

background:#003844 !important;

color:white;

}

.btn-primary:hover{

background:#002b35 !important;

color:white;

}

.btn-success{

background:#0b6b65 !important;

border:none;

}

.btn-success:hover{

background:#095952 !important;

}

.btn-warning{

background:#f4b942 !important;

color:#003844 !important;

border:none;

}

.btn-warning:hover{

background:#e6a92d !important;

}

.btn-danger{

background:#dc3545 !important;

border:none;

}

.btn-danger:hover{

background:#bb2d3b !important;

}

.btn-outline-primary{

border:2px solid #003844;

color:#003844;

}

.btn-outline-primary:hover{

background:#003844;

color:white;

}

.btn i{

margin-right:6px;

}
/*==================================
CARD
==================================*/

.card{

border:none;

border-radius:22px;

background:#ffffff;

overflow:hidden;

box-shadow:0 10px 30px rgba(0,56,68,.08);

transition:all .35s ease;

}

.card:hover{

transform:translateY(-6px);

box-shadow:0 20px 40px rgba(0,56,68,.12);

}

.card-header{

background:#003844;

color:white;

border:none;

padding:18px 25px;

font-size:17px;

font-weight:600;

}

.card-body{

padding:25px;

}


/*==================================
TABLE
==================================*/

.table{

margin-bottom:0;

}

.table thead th{

    background:#003844 !important;

color:white;

border:none;

padding:15px;

font-weight:600;

}

.table tbody td{

    border-color:#edf2f7;

padding:15px;


}

.table tbody tr{

transition:.25s;

}

.table tbody tr:hover{

    background:#edf5fb;

transition:.3s;


}

/*==================================
FORM
==================================*/

.form-control,

.form-select{

border-radius:12px;

padding:12px 15px;

border:1px solid #dce5e8;

}

.form-control:focus,

.form-select:focus{

    border-color:#003844;

box-shadow:0 0 0 .15rem rgba(0,56,68,.15);

}

/*==================================
BADGE
==================================*/

.badge{

padding:8px 14px;

border-radius:50px;

font-size:12px;

font-weight:600;

letter-spacing:.3px;

}

/*==================================
PAGE
==================================*/

.page-header h3{

margin:0;

font-weight:700;

}

.page-header p{

margin-top:6px;

opacity:.9;

}

/*==================================
ANIMATION
==================================*/

.hover-lift{

transition:.3s;

}

.hover-lift:hover{

transform:translateY(-6px);

}

/*==================================
RESPONSIVE MOBILE
==================================*/

.sidebar-overlay{

display:none;

}

@media(max-width:991px){

.sidebar{

position:fixed;

top:0;

left:-280px;

width:270px;

height:100vh;

transition:.35s;

z-index:1050;

}

.sidebar.show{

left:0;

}

.sidebar-overlay{

display:block;

position:fixed;

top:0;

left:0;

width:100%;

height:100%;

background:rgba(0,0,0,.45);

opacity:0;

visibility:hidden;

transition:.3s;

z-index:1040;

}

.sidebar-overlay.show{

opacity:1;

visibility:visible;

}

.main-content{

margin-left:0;

width:100%;

padding:18px;

}

.topbar{

flex-wrap:wrap;

gap:15px;

padding:15px;

}

.topbar,
.main-content{

transition:.35s;

}

.main-content.shift{

transform:translateX(270px);

}

.topbar.shift{

transform:translateX(270px);

}

.page-header{

padding:25px;

}

.page-header h2{

font-size:24px;

}

.page-title{

font-size:24px;

}

}

.running-box{

    background:white;

border-left:5px solid #003844;

border-radius:15px;

padding:14px 18px;

margin-bottom:25px;

box-shadow:0 6px 18px rgba(0,0,0,.08);

overflow:hidden;

}

.running-text{

overflow:hidden;

width:100%;

white-space:nowrap;

}

.running-text span{

display:inline-block;

padding-left:100%;

animation:marquee 45s linear infinite;

color:#374151;

font-weight:600;

}

@keyframes marquee{

0%{

    transform:translateX(0);

}

100%{

    transform:translateX(-100%);

}

}

.page-header-card{

background:linear-gradient(135deg,#004d61,#26b6b6,#67d6c7);

padding:30px;

border-radius:25px;

color:white;

box-shadow:0 15px 35px rgba(0,0,0,.12);

margin-bottom:25px;

position:relative;

overflow:hidden;

}

.page-header-card::after{

content:"";

position:absolute;

right:-50px;

top:-50px;

width:180px;

height:180px;

border-radius:50%;

background:rgba(255,255,255,.12);

}

.page-header-card h2{

font-weight:700;

margin-bottom:8px;

}

/*==========================
THEME SWITCH
==========================*/

.theme-box{

padding:20px;

background:#003844;

border-top:1px solid rgba(255,255,255,.15);

}

.theme-title{

font-size:14px;

font-weight:600;

margin-bottom:15px;

color:#ffffff;

}

.theme-switch{

display:flex;

justify-content:center;

align-items:center;

gap:15px;

}

.sun-icon{

font-size:20px;

color:#f59e0b;

}

.moon-icon{

font-size:20px;

color:#6366f1;

}

/* SWITCH */

.switch{

position:relative;

display:inline-block;

width:62px;

height:32px;

}

.switch input{

opacity:0;

width:0;

height:0;

}

.slider{

position:absolute;

cursor:pointer;

top:0;

left:0;

right:0;

bottom:0;

background:#d1d5db;

transition:.4s;

border-radius:50px;

}

.slider:before{

position:absolute;

content:"";

height:24px;

width:24px;

left:4px;

bottom:4px;

background:white;

transition:.4s;

border-radius:50%;

box-shadow:0 2px 8px rgba(0,0,0,.2);

}

input:checked + .slider{

    background:#003844;

}

input:checked + .slider:before{

transform:translateX(30px);

}

.dark-mode .theme-box{

background:#1e293b;

border-color:#334155;

}

.dark-mode .theme-title{

color:#cbd5e1;

}

.dark-mode .theme-switch{

color:white;

}

/*==============================
DARK MODE FULL
==============================*/

body.dark-mode{
    background:#0f172a !important;
    color:#f8fafc !important;
}

/* area utama */
body.dark-mode .main-content{
    background:#0f172a !important;
}

/* sidebar */
body.dark-mode .sidebar{
    background:#111827 !important;
    border-right:1px solid #374151 !important;
}

/* logo */
body.dark-mode .logo{
    background:#111827;
    border-bottom:1px solid #374151;
}

body.dark-mode .logo-title h4{
    color:#fff;
}

body.dark-mode .logo-title small{
    color:#cbd5e1;
}

/* menu */
body.dark-mode .sidebar-menu a{
    color:#e5e7eb;
}

body.dark-mode .sidebar-menu a:hover{
    background:#1f2937;
}

body.dark-mode .sidebar-menu .collapse a{
    color:#cbd5e1;
}

body.dark-mode .sidebar-menu .collapse a:hover{
    background:#374151;
}

/* card */
body.dark-mode .card{
    background:#1f2937 !important;
    color:white !important;
}

/* semua container putih */
body.dark-mode .running-box,
body.dark-mode .profile-box,
body.dark-mode .theme-box,
body.dark-mode .dropdown-menu{
    background:#1f2937 !important;
    color:white;
}

/* input */
body.dark-mode .form-control,
body.dark-mode .form-select{
    background:#111827 !important;
    color:white !important;
    border-color:#374151 !important;
}

body.dark-mode .form-control::placeholder{
    color:#94a3b8;
}

/* tabel */
body.dark-mode table{
    color:white;
}

body.dark-mode .table{
    color:white;
}

body.dark-mode .table thead{
    background:#374151;
}

body.dark-mode .table tbody tr{
    background:#1f2937;
}

body.dark-mode .table tbody tr:hover{
    background:#273549;
}

/* dropdown */
body.dark-mode .dropdown-item{
    color:white;
}

body.dark-mode .dropdown-item:hover{
    background:#334155;
}

/* topbar */
body.dark-mode .topbar{
    background:transparent;
}

/* breadcrumb */
body.dark-mode .breadcrumb-item,
body.dark-mode .breadcrumb-item a{
    color:#cbd5e1 !important;
}

body.dark-mode .page-title{
    color:white !important;
}

</style>

</head>

<body>

    <!-- ==========================================================
    SIDEBAR
    =========================================================== -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="sidebar" id="sidebar">
    
        <!-- ================= LOGO ================= -->
    
        <div class="logo">
    
            <img src="{{ asset('images/foto1.png') }}" alt="Logo" width="55">
    
            <div class="logo-title">
    
                <h4>E-ARSIP</h4>
    
                <small>Kecamatan Mandalajati</small>
    
            </div>
    
        </div>
    
        <!-- ================= MENU ================= -->
    
        <div class="sidebar-menu">
    
            <!-- Dashboard -->
    
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    
                <span>
    
                    <i class="bi bi-grid-fill"></i>
    
                    Dashboard
    
                </span>
    
            </a>
    
            <!-- ================= SURAT ================= -->
    
            <a
                data-bs-toggle="collapse"
                href="#suratMenu"
                role="button"
    
                @if(
                    request()->routeIs('suratmasuk.*') ||
                    request()->routeIs('suratkeluar.*')
                )
    
                aria-expanded="true"
    
                @else
    
                aria-expanded="false"
    
                @endif>
    
                <span>
    
                    <i class="bi bi-envelope-paper"></i>
    
                    Surat
    
                </span>
    
                <i class="bi bi-chevron-down"></i>
    
            </a>
    
    
            <div
                class="collapse
                @if(
                    request()->routeIs('suratmasuk.*') ||
                    request()->routeIs('suratkeluar.*')
                )
                show
                @endif"
    
                id="suratMenu">
    
                <a href="{{ route('suratmasuk.index') }}"
                   class="{{ request()->routeIs('suratmasuk.*') ? 'active' : '' }}">
    
                    <i class="bi bi-envelope-open"></i>
    
                    Surat Masuk
    
                </a>
    
                <a href="{{ route('suratkeluar.index') }}"
                   class="{{ request()->routeIs('suratkeluar.*') ? 'active' : '' }}">
    
                    <i class="bi bi-send"></i>
    
                    Surat Keluar
    
                </a>
    
            </div>
    
    
            <!-- Agenda -->
    
            <a href="{{ route('agenda.index') }}"
               class="{{ request()->routeIs('agenda.*') ? 'active' : '' }}">
    
                <span>
    
                    <i class="bi bi-calendar-event"></i>
    
                    Agenda
    
                </span>
    
            </a>
    
    
            <!-- Laporan -->
    
            @if(Auth::user()->role_id==1)
    
            <a href="{{ route('laporan.index') }}"
               class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
    
                <span>
    
                    <i class="bi bi-file-earmark-bar-graph"></i>
    
                    Laporan
    
                </span>
    
            </a>
    
            @endif
            
            <!-- ================= MASTER DATA ================= -->
    
            <a
                data-bs-toggle="collapse"
                href="#masterMenu"
                role="button"
    
                @if(
                    request()->routeIs('users.*') ||
                    request()->routeIs('pejabat.*') ||
                    request()->routeIs('arsip.*')
                )
    
                aria-expanded="true"
    
                @else
    
                aria-expanded="false"
    
                @endif
            >
    
                <span>
    
                    <i class="bi bi-folder2-open"></i>
    
                    Master Data
    
                </span>
    
                <i class="bi bi-chevron-down"></i>
    
            </a>
    
            <div
                class="collapse
                @if(
                    request()->routeIs('users.*') ||
                    request()->routeIs('pejabat.*') ||
                    request()->routeIs('arsip.*')
                )
                show
                @endif"
    
                id="masterMenu">
    
                @if(Auth::user()->role_id==1)
    
                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
    
                    <i class="bi bi-people"></i>
    
                    Data User
    
                </a>
    
                <a href="{{ route('pejabat.index') }}"
                   class="{{ request()->routeIs('pejabat.*') ? 'active' : '' }}">
    
                    <i class="bi bi-person-badge"></i>
    
                    Data Pejabat
    
                </a>
    
                @endif
    
                <a href="{{ route('arsip.index') }}"
                   class="{{ request()->routeIs('arsip.*') ? 'active' : '' }}">
    
                    <i class="bi bi-folder-fill"></i>
    
                    Data Arsip
    
                </a>
    
            </div>
    
        </div>

<!-- ================= THEME ================= -->

<div class="theme-box">

    <div class="theme-title">

        <i class="bi bi-palette-fill me-2"></i>

        Tampilan

    </div>

    <div class="theme-switch">

        <i class="bi bi-sun-fill sun-icon"></i>

        <label class="switch">

            <input
                type="checkbox"
                id="themeToggle">

            <span class="slider"></span>

        </label>

        <i class="bi bi-moon-stars-fill moon-icon"></i>

    </div>

</div>

        <!-- ================= PROFILE ================= -->
    
        <div class="profile-box">
    
            <div class="d-flex align-items-center">
    
                @if(Auth::user()->photo)
    
                <img
                src="{{ asset('storage/profile/user_1.png') }}"
                style="width:42px;height:42px;border-radius:50%;">
    
                @else
    
                    <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003844&color=ffffff"
                    alt="Profile">
    
                @endif
    
                <div class="ms-3">
    
                    <strong>
    
                        {{ Auth::user()->name }}
    
                    </strong>
    
                    <small>
    
                        ● {{ Auth::user()->role_id==1 ? 'Administrator' : 'Pegawai' }}
    
                    </small>
    
                </div>
    
            </div>
    
        </div>
    
    </div>
    
    <!-- ==========================================================
    MAIN CONTENT
    =========================================================== -->
    
    <div class="main-content">

<!-- =====================================================
TOPBAR
====================================================== -->

<div class="topbar">
    <button
    class="btn btn-primary d-lg-none me-3"
    id="toggleSidebar">
    
    <i class="bi bi-list fs-4"></i>
    
    </button>
    <!-- ================= LEFT ================= -->

    <div>

        <h3 class="page-title mb-1">
            @yield('page-title','Dashboard')
        </h3>
        
        <nav>
            <ol class="breadcrumb mb-0">
        
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
        
                <li class="breadcrumb-item active">
                    @yield('page-title','Dashboard')
                </li>
        
            </ol>
        </nav>

    </div>

    <!-- ================= RIGHT ================= -->

    <div class="d-flex align-items-center ms-auto">

        @php

        $count=\App\Models\Notification::where('user_id',Auth::id())
                ->where('is_read',0)
                ->count();

        $notifications=\App\Models\Notification::where('user_id',Auth::id())
                        ->latest()
                        ->take(5)
                        ->get();

        @endphp

        <!-- NOTIFICATION -->

        <div class="dropdown me-3">

            <button

            class="btn btn-light rounded-circle position-relative"

            style="width:50px;
            height:50px;
            border:1px solid #c6ddf0;
            box-shadow:0 5px 15px rgba(0,56,68,.08);"

                data-bs-toggle="dropdown">

                <i class="bi bi-bell fs-5"></i>

                @if($count)

                <span

                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                    {{ $count }}

                </span>

                @endif

            </button>

            <div class="dropdown-menu dropdown-menu-end p-0 shadow border-0"

                 style="width:360px;border-radius:18px;overflow:hidden;">

                <div

                    class="p-3 text-white"

                    style="background:var(--gradient);">

                    <h6 class="mb-0 fw-bold">

                        <i class="bi bi-bell-fill me-2"></i>

                        Notifikasi

                    </h6>

                </div>

                @forelse($notifications as $item)

                @php

            if($item->jenis == 'surat'){

                $url = route('suratmasuk.show', $item->reference_id);

            }elseif($item->jenis == 'agenda' && $item->reference_id){

                $url = route('agenda.show', $item->reference_id);

            }else{

                $url = route('notifications.index');

            }

        @endphp

        <a href="{{ $url }}"
        class="dropdown-item py-3 border-bottom">

                    <div class="fw-semibold">

                        {{ $item->judul }}

                    </div>

                    <small class="text-muted d-block">

                        {{ $item->pesan }}

                    </small>

                    <small class="text-secondary">

                        {{ $item->created_at->diffForHumans() }}

                    </small>

                </a>

                @empty

                <div class="text-center p-4 text-muted">

                    <i class="bi bi-bell-slash fs-1"></i>

                    <br>

                    Belum ada notifikasi

                </div>

                @endforelse

                <div class="text-center">

                    <a

                        href="{{ route('notifications.index') }}"

                        class="dropdown-item fw-bold">

                        Lihat Semua

                    </a>

                </div>

            </div>

        </div>

        <!-- PROFILE -->

        <div class="dropdown">

            <button

            class="btn bg-white px-3"

            style="
            border-radius:50px;
            border:1px solid #c6ddf0;
            box-shadow:0 5px 18px rgba(0,56,68,.08);
            "

                data-bs-toggle="dropdown">

                <div class="d-flex align-items-center">

                    @if(Auth::user()->photo)


                    <img
    src="{{ asset('storage/profile/user_1.png') }}"
    style="width:42px;height:42px;border-radius:50%;">

                    @else

                    <img

                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003844&color=fff"

                        style="width:42px;height:42px;border-radius:50%;">

                    @endif

                    <div class="ms-3 text-start">

                        <div class="fw-bold">

                            {{ Auth::user()->name }}

                        </div>

                        <small class="text-muted">

                            {{ Auth::user()->role_id==1 ? 'Administrator' : 'Pegawai' }}

                        </small>

                    </div>

                    <i class="bi bi-chevron-down ms-3"></i>

                </div>

            </button>

            <ul

                class="dropdown-menu dropdown-menu-end shadow border-0"

                style="border-radius:18px;">

                <li>

                    <a

                        class="dropdown-item"

                        href="{{ route('profile.edit') }}">

                        <i class="bi bi-person-circle me-2"></i>

                        Profil Saya

                    </a>

                </li>

                <li>

                    <hr class="dropdown-divider">

                </li>

                <li>

                    <form

                        method="POST"

                        action="{{ route('logout') }}">

                        @csrf

                        <button

                            class="dropdown-item">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</div>

<!-- =====================================================
CONTENT
====================================================== -->
    <div class="page-header">

        <div class="d-flex">
    
            <div>
    
                <h2>
    
                    @yield('page-title','Dashboard')
    
                </h2>
    
                <p>
    
                    @yield('page-description','Selamat datang di Sistem E-Arsip Kecamatan Mandalajati')
    
                </p>
    
            </div>
    
            <div class="page-header-icon">
    
                @yield('page-icon')
    
            </div>
    
        </div>
    
    </div>
    @php

$route = Route::currentRouteName();

switch ($route) {

    case 'dashboard':
        $runningText = "👋 Selamat datang di Dashboard Sistem Informasi E-Arsip Kecamatan Mandalajati • Pantau statistik surat, agenda, arsip dan aktivitas terbaru secara real-time.";
        break;

    case 'suratmasuk.index':
        $runningText = "📥 Kelola Surat Masuk dengan mudah • Pastikan seluruh surat telah diverifikasi dan didisposisikan kepada pegawai yang bersangkutan.";
        break;

    case 'suratkeluar.index':
        $runningText = "📤 Kelola Surat Keluar • Pastikan nomor surat, tujuan dan lampiran telah sesuai sebelum dicetak atau dikirim.";
        break;

    case 'arsip.index':
        $runningText = "📂 Arsip Digital memudahkan pencarian dokumen • Simpan seluruh dokumen secara aman dan terstruktur.";
        break;

    case 'agenda.index':
        $runningText = "📅 Jangan lupa memeriksa Agenda Kegiatan • Pastikan jadwal rapat maupun kegiatan telah sesuai.";
        break;

    case 'users.index':
        $runningText = "👥 Kelola Data Pengguna berdasarkan hak akses (RBAC) • Admin memiliki akses penuh sedangkan Pegawai hanya dapat mengakses menu sesuai kewenangannya.";
        break;

    case 'laporan.index':
        $runningText = "📊 Gunakan menu Laporan untuk melihat rekap Surat Masuk, Surat Keluar, Arsip dan Agenda.";
        break;

    case 'pejabat.index':
        $runningText = "🏢 Kelola Data Pejabat Kecamatan Mandalajati agar informasi penanggung jawab selalu diperbarui.";
        break;

    default:
        $runningText = "📢 Selamat Datang di Sistem Informasi E-Arsip Kecamatan Mandalajati • Terima kasih telah menggunakan aplikasi ini.";
        break;
}

@endphp

    @yield('content')
</div>

<!-- ============================================
JQUERY
============================================= -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Select2 -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SweetAlert -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).ready(function(){

    //=========================
    // SELECT2
    //=========================

    if($('#kode_arsip_id').length){

        $('#kode_arsip_id').select2({

            placeholder:"Pilih Kode Arsip",

            allowClear:true,

            width:'100%'

        });

    }

    //=========================
    // ACTIVE MENU
    //=========================

    let url=window.location.href;

    $('.sidebar-menu a').each(function(){

        if(this.href==url){

            $(this).addClass('active');

        }

    });

    //=========================
    // ROTATE ARROW
    //=========================

    $('.collapse').on('show.bs.collapse',function(){

        $(this)

        .prev('a')

        .find('.bi-chevron-down')

        .css({

            transform:'rotate(180deg)',

            transition:'.3s'

        });

    });

    $('.collapse').on('hide.bs.collapse',function(){

        $(this)

        .prev('a')

        .find('.bi-chevron-down')

        .css({

            transform:'rotate(0deg)',

            transition:'.3s'

        });

    });

});

</script>

<!-- ============================================
SWEET ALERT
============================================= -->

@if(session('success'))

<script>

Swal.fire({

icon:'success',

title:'Berhasil',

text:'{{ session("success") }}',

confirmButtonColor:'#003844'

});

</script>

@endif

@if(session('error'))

<script>

Swal.fire({

icon:'error',

title:'Gagal',

text:'{{ session("error") }}',

confirmButtonColor:'#dc3545'

});

</script>
@endif

<script>
document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("themeToggle");

    function setTheme(dark) {

        if (dark) {
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }

        if (toggle) {
            toggle.checked = dark;
        }
    }

    // Load theme yang tersimpan
    const isDark = localStorage.getItem("theme") === "dark";
    setTheme(isDark);

    // Jika toggle ada
    if (toggle) {

        toggle.addEventListener("change", function () {

            const dark = this.checked;

            setTheme(dark);

            localStorage.setItem("theme", dark ? "dark" : "light");

        });

    }

});
</script>
<script>

    document.addEventListener("DOMContentLoaded",function(){
    
    const sidebar=document.getElementById("sidebar");
    const topbar=document.querySelector(".topbar");
    const content=document.querySelector(".main-content");
    
    const overlay=document.getElementById("sidebarOverlay");
    
    const toggle=document.getElementById("toggleSidebar");
    
    // buka sidebar
    toggle.addEventListener("click",function(){
    
        sidebar.classList.toggle("show");
overlay.classList.toggle("show");

topbar.classList.toggle("shift");
content.classList.toggle("shift");
    
    });
    
    // klik overlay
    overlay.addEventListener("click",function(){
    
    sidebar.classList.remove("show");
    
    overlay.classList.remove("show");
    
    });
    
    // klik menu
    document.querySelectorAll(".sidebar-menu a").forEach(function(menu){
    
    menu.addEventListener("click",function(){
    
    if(window.innerWidth<992){
    
    sidebar.classList.remove("show");
    
    overlay.classList.remove("show");
    topbar.classList.remove("shift");
content.classList.remove("shift");
    }
    
    });
    
    });
    
    });
    
    </script>
</body>

</html>