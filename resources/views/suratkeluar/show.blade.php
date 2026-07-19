@extends('layouts.app')

@section('page-icon')
<i class="bi bi-file-earmark-text-fill"></i>
@endsection

@section('page-title')
Detail Surat Keluar
@endsection

@section('page-description')
Informasi lengkap surat keluar Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.page-header{

background:linear-gradient(
135deg,
#003844,
#0f766e,
#64c8b8);

border-radius:28px;

padding:35px;

color:white;

margin-bottom:25px;

position:relative;

overflow:hidden;

box-shadow:0 10px 30px rgba(0,56,68,.15);

}

.page-header::before{

content:"";

position:absolute;

width:220px;

height:220px;

border-radius:50%;

background:rgba(255,255,255,.08);

right:-70px;

top:-70px;

}

.page-header::after{

content:"📄";

position:absolute;

font-size:110px;

right:35px;

bottom:10px;

opacity:.08;

}

.page-title-text{

font-size:34px;

font-weight:700;

margin-bottom:10px;

}

.page-subtitle{

font-size:15px;

line-height:1.8;

opacity:.95;

max-width:650px;

}

.running-box{

background:#fff;

border-left:5px solid #0f766e;

border-radius:18px;

padding:15px 20px;

margin-bottom:25px;

box-shadow:0 5px 18px rgba(0,0,0,.08);

overflow:hidden;

}

.running-box .icon{

font-size:22px;

color:#0f766e;

margin-right:15px;

}

.running-text{

overflow:hidden;

white-space:nowrap;

width:100%;

}

.running-text span{

display:inline-block;

padding-left:100%;

animation:runningText 45s linear infinite;

font-weight:500;

color:#374151;

}

@keyframes runningText{

0%{

transform:translateX(0);

}

100%{

transform:translateX(-100%);

}

}

.info-card,
.preview-card{

border:none;

border-radius:24px;

box-shadow:0 8px 24px rgba(0,0,0,.08);

}

.section-title{

font-size:18px;

font-weight:700;

color:#0f766e;

border-left:5px solid #0f766e;

padding-left:14px;

margin-bottom:25px;

}

.info-item{

margin-bottom:22px;

}

.info-label{

font-size:13px;

font-weight:700;

color:#6b7280;

margin-bottom:6px;

display:block;

text-transform:uppercase;

letter-spacing:.5px;

}

.info-value{

font-size:15px;

color:#111827;

font-weight:500;

}

.badge-custom{

background:#dcfce7;

color:#166534;

padding:8px 16px;

border-radius:30px;

font-size:13px;

font-weight:700;

}

.btn-download{

background:#0f766e;

color:white;

border:none;

border-radius:14px;

padding:12px 22px;

transition:.25s;

}

.btn-download:hover{

background:#0b5f59;

color:white;

transform:translateY(-2px);

}

.btn-back{

border-radius:14px;

padding:12px 22px;

}

.preview-card iframe{

border-radius:15px;

}

</style>

<div class="row">

    <!-- ===========================
    INFORMASI SURAT
    =========================== -->

    <div class="col-lg-5">

        <div class="card info-card">

            <div class="card-body p-4">

                <div class="section-title">

                    <i class="bi bi-info-circle-fill me-2"></i>

                    Informasi Surat

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-folder2-open me-2 text-success"></i>

                        Kode Arsip

                    </span>

                    <div class="info-value">

                        <span class="badge-custom">

                            {{ $suratkeluar->kodearsip->kode ?? '-' }}

                        </span>

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-hash me-2 text-success"></i>

                        Nomor Surat

                    </span>

                    <div class="info-value">

                        {{ $suratkeluar->nomor_surat }}

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-card-heading me-2 text-success"></i>

                        Judul Surat

                    </span>

                    <div class="info-value">

                        {{ $suratkeluar->judul }}

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-person-fill me-2 text-success"></i>

                        Pengirim

                    </span>

                    <div class="info-value">

                        {{ $suratkeluar->pengirim }}

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-building me-2 text-success"></i>

                        Tujuan

                    </span>

                    <div class="info-value">

                        {{ $suratkeluar->tujuan }}

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-calendar-event me-2 text-success"></i>

                        Tanggal Surat

                    </span>

                    <div class="info-value">

                        {{ \Carbon\Carbon::parse($suratkeluar->tanggal_surat)->translatedFormat('d F Y') }}

                    </div>

                </div>

                <div class="info-item">

                    <span class="info-label">

                        <i class="bi bi-chat-left-text-fill me-2 text-success"></i>

                        Perihal

                    </span>

                    <div class="info-value">

                        {{ $suratkeluar->perihal }}

                    </div>

                </div>

                <hr>

                <div class="d-grid gap-2">

                    @if($suratkeluar->file_surat)

                        <a
                            href="{{ asset('storage/'.$suratkeluar->file_surat) }}"
                            target="_blank"
                            class="btn btn-download">

                            <i class="bi bi-download me-2"></i>

                            Download PDF

                        </a>

                    @endif

                    <a
                        href="{{ route('suratkeluar.index') }}"
                        class="btn btn-outline-secondary rounded-pill">

                        <i class="bi bi-arrow-left-circle me-2"></i>

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- ===========================
    PREVIEW PDF
    =========================== -->

    <div class="col-lg-7">

        <div class="card preview-card">

            <div class="card-body p-4">

                <div class="section-title">

                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>

                    Preview Dokumen

                </div>

                @if($suratkeluar->file_surat)

                <div class="border rounded-4 overflow-hidden shadow-sm">
                
                    <iframe
                        src="{{ asset('storage/'.$suratkeluar->file_surat) }}"
                        width="100%"
                        height="720"
                        frameborder="0">
                    </iframe>
                
                </div>
                
                <div class="mt-4">
                
                    <div class="alert alert-success border-0 rounded-4 mb-0">
                
                        <i class="bi bi-check-circle-fill me-2"></i>
                
                        Dokumen PDF berhasil ditemukan dan dapat dipreview secara langsung.
                
                    </div>
                
                </div>
                
                @else
                
                <div class="text-center py-5">
                
                    <div
                        class="mx-auto mb-4 d-flex justify-content-center align-items-center"
                        style="
                            width:120px;
                            height:120px;
                            border-radius:50%;
                            background:#fef2f2;
                        ">
                
                        <i
                            class="bi bi-file-earmark-x-fill"
                            style="
                                font-size:60px;
                                color:#dc2626;
                            ">
                        </i>
                
                    </div>
                
                    <h4 class="fw-bold mb-3">
                
                        Dokumen Belum Tersedia
                
                    </h4>
                
                    <p class="text-muted mb-4">
                
                        File PDF surat keluar belum diunggah atau sudah tidak tersedia pada sistem arsip digital.
                
                    </p>
                
                    <a
                        href="{{ route('suratkeluar.edit',$suratkeluar->id) }}"
                        class="btn btn-warning rounded-pill px-4">
                
                        <i class="bi bi-pencil-square me-2"></i>
                
                        Upload Dokumen
                
                    </a>
                
                </div>
                
                @endif
                
                </div>
                
                </div>
                
                </div>
                
                </div>
                
                <script>
                
                document.addEventListener("DOMContentLoaded",function(){
                
                const cards=document.querySelectorAll(".info-card,.preview-card");
                
                cards.forEach(function(card,index){
                
                card.style.opacity="0";
                
                card.style.transform="translateY(25px)";
                
                setTimeout(function(){
                
                card.style.transition=".45s ease";
                
                card.style.opacity="1";
                
                card.style.transform="translateY(0)";
                
                },index*180);
                
                });
                
                });
                
                </script>
                
                @endsection