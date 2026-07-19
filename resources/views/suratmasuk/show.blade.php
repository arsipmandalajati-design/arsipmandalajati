@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.page-header{
    background:linear-gradient(135deg,#0f766e,#14b8a6);
    border-radius:20px;
    padding:30px;
    color:white;
    margin-bottom:25px;
}

.info-card{
    border:none;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.preview-card{
    border:none;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.section-title{
    font-size:18px;
    font-weight:700;
    color:#0f766e;
    border-left:5px solid #0f766e;
    padding-left:12px;
    margin-bottom:20px;
}

.info-item{
    margin-bottom:18px;
}

.info-label{
    display:block;
    font-weight:700;
    color:#6b7280;
    margin-bottom:5px;
}

.info-value{
    font-size:15px;
    color:#111827;
}

.badge-custom{
    background:#d1fae5;
    color:#065f46;
    padding:8px 15px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.btn-download{
    background:#0f766e;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 20px;
}

.btn-download:hover{
    background:#115e59;
    color:white;
}

.btn-back{
    border-radius:12px;
    padding:10px 20px;
}

iframe{
    border-radius:15px;
}

</style>

<div class="page-header">

    <h2 class="fw-bold mb-2">

        <i class="bi bi-envelope-open-fill"></i>

        Detail Surat Masuk

    </h2>

    <p class="mb-0">

        Informasi lengkap surat masuk beserta data kegiatan dan disposisi.

    </p>

</div>

<div class="row">

<div class="col-lg-5">

<div class="card info-card">

<div class="card-body p-4">

<div class="section-title">

Informasi Surat

</div>
<div class="info-item">

    <span class="info-label">
        Kode Arsip
    </span>

    <div class="info-value">

        <span class="badge-custom">

            {{ $suratmasuk->kodearsip->kode ?? '-' }}

        </span>

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Nomor Surat
    </span>

    <div class="info-value">

        {{ $suratmasuk->nomor_surat }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Judul Surat
    </span>

    <div class="info-value">

        {{ $suratmasuk->judul }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Pengirim
    </span>

    <div class="info-value">

        {{ $suratmasuk->pengirim }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Tanggal Surat
    </span>

    <div class="info-value">

        {{ \Carbon\Carbon::parse($suratmasuk->tanggal_surat)->translatedFormat('d F Y') }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Perihal
    </span>

    <div class="info-value">

        {{ $suratmasuk->perihal }}

    </div>

</div>

<hr>

<div class="section-title">

Informasi Kegiatan

</div>

<div class="info-item">

    <span class="info-label">
        Tempat
    </span>

    <div class="info-value">

        {{ $suratmasuk->tempat ?? '-' }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Tanggal Kegiatan
    </span>

    <div class="info-value">

        {{ $suratmasuk->tanggal_kegiatan
            ? \Carbon\Carbon::parse($suratmasuk->tanggal_kegiatan)->translatedFormat('d F Y')
            : '-' }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Jam Pelaksanaan
    </span>

    <div class="info-value">

        {{ $suratmasuk->jam_mulai ?? '-' }}

        -

        {{ $suratmasuk->jam_selesai ?? '-' }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Materi
    </span>

    <div class="info-value">

        {{ $suratmasuk->materi ?? '-' }}

    </div>

</div>

<hr>

<div class="section-title">

Status & Disposisi

</div>

<div class="info-item">

    <span class="info-label">
        Status Surat
    </span>

    <div class="info-value">

        @if($suratmasuk->status=='Menunggu Verifikasi')

            <span class="badge bg-warning">

                {{ $suratmasuk->status }}

            </span>

        @elseif($suratmasuk->status=='Sudah Diverifikasi')

            <span class="badge bg-success">

                {{ $suratmasuk->status }}

            </span>

        @elseif($suratmasuk->status=='Sudah Disposisi')

            <span class="badge bg-primary">

                {{ $suratmasuk->status }}

            </span>

        @else

            <span class="badge bg-secondary">

                {{ $suratmasuk->status }}

            </span>

        @endif

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Pegawai Disposisi
    </span>

    <div class="info-value">

        {{ $suratmasuk->userDisposisi->name ?? '-' }}

    </div>

</div>

<div class="info-item">

    <span class="info-label">
        Catatan Admin
    </span>

    <div class="info-value">

        {{ $suratmasuk->catatan_admin ?? '-' }}

    </div>

</div>

<hr>

<div class="d-flex gap-2 flex-wrap">

@if($suratmasuk->file_surat)

<a href="{{ asset('storage/'.$suratmasuk->file_surat) }}"
   target="_blank"
   class="btn btn-download">

    <i class="bi bi-download"></i>

    Download PDF

</a>

@endif

<a href="{{ route('suratmasuk.index') }}"
   class="btn btn-secondary btn-back">

    <i class="bi bi-arrow-left"></i>

    Kembali

</a>

</div>

</div>

</div>

</div>

<div class="col-lg-7">

<div class="card preview-card">

<div class="card-body p-4">

<div class="section-title">

Preview Dokumen

</div>
@if($suratmasuk->file_surat)

<iframe

src="{{ asset('storage/'.$suratmasuk->file_surat) }}"

width="100%"

height="720"

frameborder="0">

</iframe>

<div class="mt-4 d-flex justify-content-end">

<a href="{{ asset('storage/'.$suratmasuk->file_surat) }}"
   target="_blank"
   class="btn btn-download">

<i class="bi bi-file-earmark-arrow-down-fill"></i>

Download PDF

</a>

</div>

@else

<div class="text-center py-5">

<i class="bi bi-file-earmark-pdf-fill"

style="font-size:80px;color:#dc3545;"></i>

<h4 class="mt-3">

Dokumen Tidak Ditemukan

</h4>

<p class="text-muted">

File surat belum diupload atau sudah dihapus.

</p>

</div>

@endif

</div>

</div>

</div>

</div>

@endsection