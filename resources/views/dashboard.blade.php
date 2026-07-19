@extends('layouts.app')

@section('title','Dashboard')

@section('page-title')
Dashboard
@endsection

@section('page-description')
{{ $greeting }}, {{ Auth::user()->name }} 👋
@endsection

@section('page-icon')
<i class="bi bi-grid-fill"></i>
@endsection

@section('content')

<style>

:root{

--primary:#003844;

--secondary:#A3D9B9;

--cream:#FFFCF7;

--shadow:0 15px 35px rgba(0,0,0,.12);

--radius:25px;

}

.dashboard-wrapper{

animation:fadeDashboard .6s ease;

}

@keyframes fadeDashboard{

from{

opacity:0;

transform:translateY(30px);

}

to{

opacity:1;

transform:translateY(0);

}

}

/* =====================================
WELCOME CARD
===================================== */

.welcome-box{

    background-image:
    radial-gradient(
    circle 1292px at -13.6% 51.7%,
    rgba(0,56,68,1) 0%,
    rgba(163,217,185,1) 51.5%,
    rgba(255,252,247,1) 88.6%
    );

    border-radius:30px;
    padding:45px;

    position:relative;
    z-index:1;

    overflow:hidden;
    box-shadow:var(--shadow);
    color:white;
    margin-bottom:35px;

}

.welcome-box::before{

content:"";

position:absolute;

width:220px;

height:220px;

border-radius:50%;

background:rgba(255,255,255,.08);

right:-70px;

top:-70px;

}

.welcome-box::after{

content:"📂";

position:absolute;

font-size:120px;

right:35px;

bottom:15px;

opacity:.08;

}

.welcome-title{

font-size:34px;

font-weight:700;

margin-bottom:12px;

}

.welcome-subtitle{

font-size:16px;

opacity:.95;

max-width:650px;

line-height:1.8;

}

/* ==========================
CLOCK
========================== */

.clock-card{

background:rgba(255,255,255,.15);

backdrop-filter:blur(12px);

padding:20px;

border-radius:20px;

min-width:220px;

text-align:center;

border:1px solid rgba(255,255,255,.25);

}

#clockLive{

font-size:32px;

font-weight:bold;

margin-bottom:5px;

color:white;

}

#dateLive{

font-size:14px;

color:#fff;

}


/* =====================
BOX
===================== */

.chart-box,
.activity-box,
.progress-box{

animation:fadeDashboard .8s ease;

}

.progress-item{
    margin-bottom:28px;
}

.progress-item:last-child{
    margin-bottom:0;
}

.progress-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    font-size:15px;
    font-weight:600;
}

.progress-title span:last-child{
    font-size:20px;
    color:#003844;
    font-weight:700;
}

.progress{
    height:12px;
    border-radius:20px;
    background:#edf2f7;
}

.progress-bar{
    border-radius:20px;
    transition:1.2s ease;
}

.chart-box h5,

.activity-box h5,

.progress-box h5{

font-weight:700;

margin-bottom:25px;

color:#003844;

}

.activity-box{

height:100%;

overflow:auto;

max-height:500px;

}

.activity-item{
    display:flex;
    align-items:flex-start;
    gap:18px;
    padding:18px;
    border-radius:18px;
    background:#fff;
    border:1px solid #edf2f7;
    transition:.3s;
    margin-bottom:18px;
    position:relative;
}

.activity-item:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(0,0,0,.08);
}

.activity-icon{
    width:55px;
    height:55px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    background:#e8f5f3;
    flex-shrink:0;
}

.activity-content{
    flex:1;
}

.activity-title{
    font-size:16px;
    font-weight:700;
    color:#003844;
}

.activity-desc{
    color:#6b7280;
    margin-top:4px;
}

.activity-time{
    font-size:13px;
    color:#9ca3af;
    margin-top:8px;
}

.quick-card{

background:#fff;

border-radius:24px;

padding:30px 20px;

text-align:center;

text-decoration:none;

display:block;

color:#1f2937;

border:1px solid #eef2ff;

transition:.35s;

height:170px;

display:flex;

flex-direction:column;

justify-content:center;

align-items:center;

box-shadow:0 8px 25px rgba(0,0,0,.06);

}

.quick-card:hover{

transform:translateY(-10px);

box-shadow:0 20px 35px rgba(0,56,68,.18);

border-color:#3f8f7d;

}

.quick-card i{

font-size:48px;

margin-bottom:18px;

color:#005c66;

transition:.35s;

}

.quick-card:hover i{

transform:scale(1.15);

color:#0f766e;

}

.quick-card h6{

font-size:17px;

font-weight:700;

margin:0;

}

/* ===========================================
RUNNING TEXT GLOBAL
=========================================== */

.running-box{

    background:#ffffff;
    border-left:5px solid #0f766e;
    border-radius:15px;
    padding:12px 18px;
    margin-bottom:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);

    position:relative;
    z-index:1;

    overflow:hidden;

}

.running-box .icon{

color:#0f766e;

font-size:20px;

margin-right:12px;

}

.running-text{

overflow:hidden;

width:100%;

white-space:nowrap;

}

.running-text span{

display:inline-block;

padding-left:100%;

animation:runningText 55s linear infinite;
/* semakin besar angkanya semakin lambat */

font-weight:500;

color:#374151;

}

@keyframes runningText{

from{

    transform:translateX(0);

}

to{

    transform:translateX(-100%);

}

}

.dark-mode .chart-box{

background:#1f2937;

}

.chart-box{
    height:360px;
}

.chart-box canvas{
    max-width:350px;
    max-height:350px;
    margin:auto;
}

/* ===========================
STATISTIC CARD
=========================== */

.stat-card{
    background:#003844;
    border-radius:20px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    transition:.35s;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    min-height:185px;
}

.stat-card:hover{
    transform:translateY(-8px);
    box-shadow:0 18px 35px rgba(0,56,68,.18);
}

.stat-icon{
    width:60px;
    height:60px;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    margin-bottom:18px;
}

.stat-number{
    font-size:38px;
    font-weight:700;
    color:#a8efff;
    line-height:1;
}

.stat-title{
    font-size:17px;
    font-weight:600;
    color:#ffffff;
    margin-bottom:10px;
}

.stat-footer{
    margin-top:15px;
    color:#6b7280;
    font-size:14px;
}

.bg-primary-soft{
    background:#dbeafe;
    color:#2563eb;
}

.bg-success-soft{
    background:#dcfce7;
    color:#16a34a;
}

.bg-info-soft{
    background:#cffafe;
    color:#0891b2;
}

.bg-warning-soft{
    background:#fef3c7;
    color:#d97706;
}

.bg-danger-soft{
    background:#fee2e2;
    color:#dc2626;
}

.bg-dark-soft{
    background:#e5e7eb;
    color:#374151;
}
@media(max-width:992px){

    .chart-box,
.activity-box,
.progress-box{

animation:fadeDashboard .8s ease;

}

}

@media(max-width:768px){

.stat-card{

margin-bottom:20px;

}

.quick-card{

height:145px;

}

.chart-box{

height:auto;

}

}
</style>

<div class="dashboard-wrapper">

    <div class="running-box">

        <div class="d-flex align-items-center">
    
            <div class="icon">
                <i class="bi bi-megaphone-fill"></i>
            </div>
    
            <div class="running-text">
    
                <span>
    
                    📢 Selamat Datang di Sistem Informasi E-Arsip Kecamatan Mandalajati •
                    📥 Silakan cek Surat Masuk secara berkala •
                    📤 Pastikan Surat Keluar telah diverifikasi •
                    📂 Arsip digital disimpan dengan aman •
                    📅 Jangan lupa memeriksa Agenda kegiatan setiap hari •
                    👥 Kelola data pengguna sesuai hak akses (Role Based Access Control) •
                    📊 Gunakan menu Laporan untuk melihat rekapitulasi data •
                    🔒 Jaga keamanan akun Anda dan jangan membagikan password kepada siapa pun •
                    🌟 Terima kasih telah menggunakan Sistem Informasi E-Arsip.
    
                </span>
    
            </div>
    
        </div>
    
    </div>
    
    @yield('content')

    <div class="row g-4">

        <!-- Surat Masuk -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-primary-soft">
                    <i class="bi bi-envelope-fill"></i>
                </div>
    
                <div class="stat-title">
                    Surat Masuk
                </div>
    
                <div class="stat-number counter"
                data-target="{{ $totalSuratMasuk }}">
               0
           </div>
                <div class="stat-footer">
                    Total Surat Masuk
                </div>
    
            </div>
    
        </div>
    
        <!-- Surat Keluar -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-success-soft">
                    <i class="bi bi-send-fill"></i>
                </div>
    
                <div class="stat-title">
                    Surat Keluar
                </div>
    
                <div class="stat-number counter"
                     data-target="{{ $totalSuratKeluar }}">
                    0
                </div>
    
                <div class="stat-footer">
                    Total Surat Keluar
                </div>
    
            </div>
    
        </div>
    
        <!-- Arsip -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-info-soft">
                    <i class="bi bi-folder-fill"></i>
                </div>
    
                <div class="stat-title">
                    Data Arsip
                </div>
    
                <div class="stat-number counter"
                     data-target="{{ $totalArsip }}">
                    0
                </div>
    
                <div class="stat-footer">
                    Total Arsip Digital
                </div>
    
            </div>
    
        </div>
    
        <!-- Agenda -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-warning-soft">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
    
                <div class="stat-title">
                    Agenda
                </div>
    
                <div class="stat-number counter"
                     data-target="{{ $totalAgenda }}">
                    0
                </div>
    
                <div class="stat-footer">
                    Agenda Kegiatan
                </div>
    
            </div>
    
        </div>
    
        @if(Auth::user()->role_id==1)
    
        <!-- User -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-danger-soft">
                    <i class="bi bi-people-fill"></i>
                </div>
    
                <div class="stat-title">
                    Data User
                </div>
    
                <div class="stat-number counter"
                     data-target="{{ $totalUser }}">
                    0
                </div>
    
                <div class="stat-footer">
                    Total Pengguna
                </div>
    
            </div>
    
        </div>
    
        <!-- Pejabat -->
        <div class="col-lg-4 col-md-6">
    
            <div class="stat-card">
    
                <div class="stat-icon bg-dark-soft">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
    
                <div class="stat-title">
                    Data Pejabat
                </div>
    
                <div class="stat-number counter"
                     data-target="{{ $totalPejabat }}">
                    0
                </div>
    
                <div class="stat-footer">
                    Data Pejabat Kecamatan
                </div>
    
            </div>
    
        </div>
    
        @endif
    
    </div>
    
    <br>

{{-- ===========================
MENU CEPAT
=========================== --}}

<div class="chart-box mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h5>

            ⚡ Menu Cepat

        </h5>

        <small class="text-muted">

            Pilih menu yang ingin dibuka

        </small>

    </div>

    <div class="row g-4">

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('suratmasuk.index') }}"
               class="quick-card">

                <i class="bi bi-envelope-fill text-success"></i>

                <h6>Surat Masuk</h6>

            </a>

        </div>

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('suratkeluar.index') }}"
               class="quick-card">

                <i class="bi bi-send-fill text-primary"></i>

                <h6>Surat Keluar</h6>

            </a>

        </div>

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('arsip.index') }}"
               class="quick-card">

                <i class="bi bi-folder-fill text-warning"></i>

                <h6>Arsip</h6>

            </a>

        </div>

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('agenda.index') }}"
            class="quick-card">
         
             <i class="bi bi-calendar-event-fill text-danger"></i>
         
             <h6>Agenda</h6>
         
         </a>
        </div>

        @if(Auth::user()->role_id == 1)

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('users.index') }}"
            class="quick-card">

                <i class="bi bi-people-fill text-info"></i>

                <h6>User</h6>

            </a>

        </div>

        @endif

                @if(Auth::user()->role_id == 1)

        <div class="col-lg-2 col-md-4 col-6">

            <a href="{{ route('laporan.index') }}"
            class="quick-card">

                <i class="bi bi-file-earmark-text-fill text-secondary"></i>

                <h6>Laporan</h6>

            </a>

        </div>

        @endif
    </div>

</div>


{{-- ===========================
RINGKASAN DATA
=========================== --}}

<div class="progress-box mt-5">

    <h5>
    
    📈 Ringkasan Data
    
    </h5>
    
    <div class="progress-item">

        <div class="progress-title">

            <span>📥 Surat Masuk</span>
        
            <span>{{ $totalSuratMasuk }}</span>
        
        </div>
    
        <div class="progress mt-2">
    
            <div class="progress-bar bg-success"
                 style="width:{{ min($totalSuratMasuk,100) }}%">
            </div>
    
        </div>
    
    </div>
    
    <div class="progress-item">

        <div class="progress-title">

            <span>📥 Surat Masuk</span>
    
            <span>{{ $totalSuratKeluar }}</span>
    
    </div>
    
        <div class="progress mt-2">
    
             <div class="progress-bar bg-primary"
    
                style="width:{{ min($totalSuratKeluar,100) }}%">
    
            </div>
    
         </div>
    
    </div>
    
    <div class="progress-item mt-4">
    
        <div class="progress-title">
    
            <span>📂 Arsip</span>
            
            <span>{{ $totalArsip }}</span>
    
        </div>
    
        <div class="progress mt-2">
    
            <div class="progress-bar bg-warning"
    
                style="width:{{ min($totalArsip,100) }}%">
    
            </div>
    
        </div>
    
    </div>
    
    <div class="progress-item mt-4">
    
        <div class="progress-title">
    
            <span>📅 Agenda</span>
            
            <span>{{ $totalAgenda }}</span>
        
        </div>
    
        <div class="progress mt-2">
    
            <div class="progress-bar bg-danger"
    
                style="width:{{ min($totalAgenda,100) }}%">
    
            </div>
    
        </div>
    
    </div>
    
</div>

    {{-- Aktivitas --}}
    <div class="col-lg-6">

        <div class="activity-box h-100">

            <h5 class="fw-bold mb-4">

                📝 Aktivitas Terbaru

            </h5>

            @foreach($aktivitas as $item)

<div class="activity-item">

    <div class="activity-icon">

        <i class="bi {{ $item['icon'] }} text-{{ $item['warna'] }}"></i>

    </div>

    <div class="activity-content">

        <div class="activity-title">

            {{ $item['judul'] }}

        </div>

        <div class="activity-desc">

            {{ $item['isi'] }}

        </div>

        <div class="activity-time">

            <i class="bi bi-clock"></i>

            {{ $item['waktu']->diffForHumans() }}

        </div>

    </div>

</div>

@endforeach

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

document.querySelectorAll('.counter').forEach(counter=>{

let target=+counter.dataset.target;

let count=0;

let speed=target/60;

function update(){

count+=speed;

if(count<target){

counter.innerText=Math.floor(count);

requestAnimationFrame(update);

}else{

counter.innerText=target;

}

}

update();

});

const canvas = document.getElementById("pieChart");

if (canvas && typeof Chart !== "undefined") {

    const ctx = canvas.getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "Surat Masuk",
                "Surat Keluar",
                "Arsip",
                "Agenda"
            ],
            datasets: [{
                data: [
                    {{ $totalSuratMasuk }},
                    {{ $totalSuratKeluar }},
                    {{ $totalArsip }},
                    {{ $totalAgenda }}
                ],
                backgroundColor:[
                "#0f766e",
                "#38bdf8",
                "#f59e0b",
                "#ef4444"
                ],
                borderWidth:0,
                borderRadius:10,
                borderSkipped:false,
            }]
        },
        options:{
    responsive:true,
    maintainAspectRatio:false,

    plugins:{
        legend:{
            display:false
        }
    },

    scales:{

        y:{
            beginAtZero:true,
            ticks:{
                precision:0
            },
            grid:{
                color:"#e5e7eb"
            }
        },

        x:{
            grid:{
                display:false
            }
        }

    }

}
    });

}
</script> 

    @php
    $agenda = $agendaBesok->first();
@endphp

@if($agenda)

<script>
document.addEventListener('DOMContentLoaded', function () {

Swal.fire({
    icon:'info',
    title:'📅 Pengingat Kegiatan Besok',
    html:`
        <div style="text-align:left">
            <b>📌 {{ $agenda->nama_kegiatan }}</b><br>
            📅 {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d-m-Y') }}<br>
            🕗 {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}<br>
            📍 {{ $agenda->tempat }}
        </div>
    `,
    showCancelButton:true,
    confirmButtonText:'📅 Lihat Agenda',
    cancelButtonText:'OK',
    confirmButtonColor:'#0f766e',
    cancelButtonColor:'#6c757d'

}).then((result)=>{

    if(result.isConfirmed){
        window.location.href="{{ route('agenda.index') }}";
    }

});

});
</script>

@endif

@endsection