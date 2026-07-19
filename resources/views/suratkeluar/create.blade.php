@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Registrasi Surat Keluar
@endsection

@section('page-description')
Silakan lengkapi data surat keluar beserta dokumen digitalnya.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* ===========================
HEADER
=========================== */

.page-header{

    background:
    linear-gradient(
    135deg,
    #003844,
    #0f766e,
    #64c8b8
    );

    border-radius:28px;

    padding:35px 40px;

    color:#fff;

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

    content:"📤";

    position:absolute;

    right:35px;

    bottom:15px;

    font-size:110px;

    opacity:.08;

}

.page-title-text{

    font-size:34px;

    font-weight:700;

    margin-bottom:12px;

}

.page-subtitle{

    font-size:15px;

    line-height:1.8;

    max-width:650px;

    opacity:.95;

}

/* ===========================
FORM
=========================== */

.form-card{

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

    margin-bottom:20px;

}

.form-control,
.form-select{

    border-radius:14px;

    min-height:50px;

    border:1px solid #dbe5ef;

}

.form-control:focus,
.form-select:focus{

    border-color:#0f766e;

    box-shadow:0 0 0 .15rem rgba(15,118,110,.15);

}

textarea.form-control{

    min-height:120px;

}

/* ===========================
BUTTON
=========================== */

.btn-save{

    background:#0f766e;

    color:white;

    border:none;

    border-radius:14px;

    padding:12px 28px;

    transition:.25s;

}

.btn-save:hover{

    background:#0b5f59;

    color:white;

    transform:translateY(-2px);

}

.btn-back{

    border-radius:14px;

    padding:12px 28px;

}

/* ===========================
UPLOAD
=========================== */

.file-info{

    font-size:13px;

    color:#6b7280;

}

.bg-readonly{

    background:#f8fafc;

}

.required{

    color:red;

}

/* ===========================
RUNNING TEXT
=========================== */

.running-box{

    background:#fff;

    border-left:6px solid #0f766e;

    border-radius:18px;

    padding:15px 20px;

    margin-bottom:25px;

    box-shadow:0 5px 18px rgba(0,0,0,.08);

    overflow:hidden;

}

.running-box .icon{

    color:#0f766e;

    font-size:22px;

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

    color:#374151;

    font-weight:500;

}

@keyframes runningText{

0%{

transform:translateX(0);

}

100%{

transform:translateX(-100%);

}

}

</style>

@if(session('success'))

<script>

document.addEventListener('DOMContentLoaded',function(){

Swal.fire({

icon:'success',

title:'Berhasil',

text:'{{ session("success") }}',

confirmButtonColor:'#0f766e'

});

});

</script>

@endif

{{-- ===========================
VALIDASI ERROR
=========================== --}}

@if($errors->any())

<div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

    <div class="d-flex align-items-center">

        <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>

        <div>

            <h6 class="fw-bold mb-1">

                Terjadi Kesalahan!

            </h6>

            <small>

                Silakan periksa kembali data yang Anda masukkan.

            </small>

        </div>

    </div>

    <hr>

    <ul class="mb-0">

        @foreach($errors->all() as $error)

        <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

{{-- ===========================
FORM
=========================== --}}

<div class="card form-card">

<div class="card-body p-4">

<form
action="{{ route('suratkeluar.store') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="section-title">

<i class="bi bi-archive-fill me-2"></i>

Informasi Arsip

</div>

<div class="row">

    {{-- KODE ARSIP --}}

    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-folder2-open me-1 text-success"></i>

            Kode Arsip

            <span class="required">*</span>

        </label>

        <select

            name="kode_arsip_id"

            id="kode_arsip_id"

            class="form-select @error('kode_arsip_id') is-invalid @enderror">

            <option value="">

                -- Pilih Kode Arsip --

            </option>

            @foreach($kodearsip as $item)

            <option

                value="{{ $item->id }}"

                data-kode="{{ $item->kode }}"

                {{ old('kode_arsip_id')==$item->id?'selected':'' }}>

                {{ $item->kode }}

                -

                {{ $item->nama_arsip }}

            </option>

            @endforeach

        </select>

        @error('kode_arsip_id')

        <div class="invalid-feedback">

            {{ $message }}

        </div>

        @enderror

    </div>

    {{-- KODE MANUAL --}}

    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-pencil-square me-1 text-success"></i>

            Kode Manual (Opsional)

        </label>

        <input

            type="text"

            id="kode_manual"

            class="form-control"

            value="{{ old('kode_manual') }}"

            placeholder="Contoh : HM.01">

        <small class="text-muted">

            Isi jika ingin menggunakan kode arsip khusus.

        </small>

    </div>

</div>

<hr class="my-4">

<div class="section-title">

<i class="bi bi-envelope-paper-fill me-2"></i>

Informasi Surat

</div>

<div class="row">

    {{-- NOMOR REGISTRASI --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-123 me-1 text-success"></i>

            Nomor Registrasi

            <span class="required">*</span>

        </label>

        <input
            type="text"
            id="nomor_manual"
            class="form-control"
            value="{{ old('nomor_manual') }}"
            placeholder="Contoh : 058-Pel.PDH">

        <small class="text-muted">

            Masukkan nomor registrasi surat.

        </small>

    </div>

    {{-- NOMOR SURAT OTOMATIS --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-hash me-1 text-success"></i>

            Nomor Surat Otomatis

        </label>

        <input
            type="text"
            id="nomor_surat"
            name="nomor_surat"
            class="form-control bg-readonly"
            value="{{ old('nomor_surat') }}"
            readonly>

        <small class="text-success">

            Dibuat otomatis berdasarkan kode arsip.

        </small>

    </div>

    {{-- JUDUL --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-card-heading me-1 text-success"></i>

            Judul Surat

            <span class="required">*</span>

        </label>

        <input
            type="text"
            name="judul"
            class="form-control @error('judul') is-invalid @enderror"
            value="{{ old('judul') }}"
            placeholder="Masukkan judul surat"
            required>

        @error('judul')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    {{-- PENGIRIM --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-person-fill me-1 text-success"></i>

            Pengirim

            <span class="required">*</span>

        </label>

        <input
            type="text"
            name="pengirim"
            class="form-control @error('pengirim') is-invalid @enderror"
            value="{{ old('pengirim') }}"
            placeholder="Masukkan nama pengirim"
            required>

        @error('pengirim')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    {{-- TUJUAN --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-building me-1 text-success"></i>

            Tujuan Surat

            <span class="required">*</span>

        </label>

        <input
            type="text"
            name="tujuan"
            class="form-control @error('tujuan') is-invalid @enderror"
            value="{{ old('tujuan') }}"
            placeholder="Masukkan instansi tujuan"
            required>

        @error('tujuan')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    {{-- TANGGAL --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-calendar-event me-1 text-success"></i>

            Tanggal Surat

            <span class="required">*</span>

        </label>

        <input
            type="date"
            name="tanggal_surat"
            class="form-control @error('tanggal_surat') is-invalid @enderror"
            value="{{ old('tanggal_surat') }}"
            required>

        @error('tanggal_surat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    {{-- PERIHAL --}}
    <div class="col-md-12 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-chat-left-text-fill me-1 text-success"></i>

            Perihal

            <span class="required">*</span>

        </label>

        <textarea
            name="perihal"
            rows="5"
            class="form-control @error('perihal') is-invalid @enderror"
            placeholder="Tuliskan perihal surat..."
            required>{{ old('perihal') }}</textarea>

        @error('perihal')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    {{-- FILE PDF --}}
    <div class="col-md-12 mb-4">

        <label class="form-label fw-semibold">

            <i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i>

            Upload File Surat (PDF)

            <span class="required">*</span>

        </label>

        <input
            type="file"
            name="file_surat"
            id="file_surat"
            class="form-control @error('file_surat') is-invalid @enderror"
            accept=".pdf"
            required>

        <div id="namaFile" class="file-info mt-2">

            <i class="bi bi-info-circle me-1"></i>

            Belum ada file dipilih.

        </div>

        @error('file_surat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>
        
<hr class="my-4">

<div class="row align-items-center">

    <div class="col-md-6">

        <div class="text-muted">

            <i class="bi bi-info-circle-fill text-success me-2"></i>

            Pastikan seluruh data telah benar sebelum menyimpan surat keluar.

        </div>

    </div>

    <div class="col-md-6">

        <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-3 mt-md-0">

            <a
                href="{{ route('suratkeluar.index') }}"
                class="btn btn-outline-secondary rounded-pill px-4">

                <i class="bi bi-arrow-left-circle me-2"></i>

                Kembali

            </a>

            <button
                type="submit"
                class="btn btn-save rounded-pill px-4">

                <i class="bi bi-check-circle-fill me-2"></i>

                Simpan Surat

            </button>

        </div>

    </div>

</div>

</form>

</div>

</div>
        <script>

            /*
            |--------------------------------------------------------------------------
            | GENERATE NOMOR SURAT OTOMATIS
            |--------------------------------------------------------------------------
            */
            
            function generateNomorSurat(){
            
                let select = document.getElementById('kode_arsip_id');
            
                let selected = select.options[select.selectedIndex];
            
                let kodeDropdown = '';
            
                if(selected){
            
                    kodeDropdown = selected.getAttribute('data-kode');
            
                }
            
                let kodeManual = document
                    .getElementById('kode_manual')
                    .value
                    .trim();
            
                let nomorManual = document
                    .getElementById('nomor_manual')
                    .value
                    .trim();
            
                let kode = kodeManual !== ''
                    ? kodeManual
                    : kodeDropdown;
            
                let tahun = new Date().getFullYear();
            
                let bulan = new Date().getMonth()+1;
            
                let romawi = [
            
                    '',
            
                    'I',
            
                    'II',
            
                    'III',
            
                    'IV',
            
                    'V',
            
                    'VI',
            
                    'VII',
            
                    'VIII',
            
                    'IX',
            
                    'X',
            
                    'XI',
            
                    'XII'
            
                ];
            
                if(kode && nomorManual){
            
                    document.getElementById('nomor_surat').value =
            
                        'No.' +
            
                        kode +
            
                        '/' +
            
                        nomorManual +
            
                        '-Kec.MDLJ/T/' +
            
                        romawi[bulan] +
            
                        '/' +
            
                        tahun;
            
                }else{
            
                    document.getElementById('nomor_surat').value='';
            
                }
            
            }
            
            
            /*
            |--------------------------------------------------------------------------
            | EVENT
            |--------------------------------------------------------------------------
            */
            
            document.getElementById('kode_arsip_id')
            
            .addEventListener(
            
            'change',
            
            generateNomorSurat
            
            );
            
            document.getElementById('kode_manual')
            
            .addEventListener(
            
            'keyup',
            
            generateNomorSurat
            
            );
            
            document.getElementById('nomor_manual')
            
            .addEventListener(
            
            'keyup',
            
            generateNomorSurat
            
            );
            
            
            /*
            |--------------------------------------------------------------------------
            | PREVIEW NAMA FILE PDF
            |--------------------------------------------------------------------------
            */
            
            document.getElementById('file_surat').addEventListener('change',function(){

                let file=this.files[0];

                if(file){

                document.getElementById('namaFile').innerHTML=

                '<span class="badge bg-success rounded-pill px-3 py-2">'+
                '<i class="bi bi-check-circle-fill me-2"></i>'+
                file.name+
                '</span>';

                }else{

                document.getElementById('namaFile').innerHTML=

                '<i class="bi bi-info-circle me-1"></i> Belum ada file dipilih.';

                }

                });
            
/*
            |--------------------------------------------------------------------------
            | Tambahkan animasi halaman
            |--------------------------------------------------------------------------
            */
                document.addEventListener("DOMContentLoaded",function(){

                const card=document.querySelector(".form-card");

                card.style.opacity="0";

                card.style.transform="translateY(25px)";

                setTimeout(function(){

                card.style.transition=".45s";

                card.style.opacity="1";

                card.style.transform="translateY(0)";

                },150);

                });
            /*
            |--------------------------------------------------------------------------
            | AUTO GENERATE SAAT LOAD
            |--------------------------------------------------------------------------
            */
            
            window.onload=function(){
            
            generateNomorSurat();
            
            };
            
            </script>
            
            @endsection