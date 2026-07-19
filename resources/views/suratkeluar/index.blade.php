@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Surat Keluar
@endsection

@section('page-description')
Kelola seluruh surat keluar Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* ===========================
   PAGE HEADER
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

    overflow:hidden;

    position:relative;

    box-shadow:0 10px 30px rgba(0,56,68,.18);

}

.page-header::before{

    content:"";

    position:absolute;

    width:230px;

    height:230px;

    border-radius:50%;

    background:rgba(255,255,255,.08);

    top:-80px;

    right:-80px;

}

.page-header::after{

    content:"📤";

    position:absolute;

    right:30px;

    bottom:10px;

    font-size:120px;

    opacity:.08;

}

.page-title{

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
   INFO CARD
=========================== */

.info-card{

    background:#fff;

    border:none;

    border-radius:20px;

    padding:25px;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    transition:.3s;

}

.info-card:hover{

    transform:translateY(-5px);

}

.info-icon{

    width:65px;

    height:65px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#dcfce7;

    color:#0f766e;

    font-size:28px;

    margin-bottom:15px;

}

.info-title{

    font-size:14px;

    color:#6b7280;

}

.info-number{

    font-size:32px;

    font-weight:700;

    color:#003844;

}

/* ===========================
   RUNNING TEXT
=========================== */

.running-box{

    background:#fff;

    border-left:6px solid #0f766e;

    border-radius:18px;

    padding:15px 20px;

    margin:25px 0;

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

/* ===========================
FILTER
=========================== */

.filter-card{

border:none;

border-radius:24px;

box-shadow:0 8px 25px rgba(0,0,0,.08);

}

.filter-card .card-header{

border-bottom:1px solid #eef2f7;

background:#fff;

}

/* ===========================
TABLE
=========================== */

.table-card{

border:none;

border-radius:24px;

box-shadow:0 8px 25px rgba(0,0,0,.08);

}

.table-card .card-header{

background:#fff;

border-bottom:1px solid #eef2f7;

border-radius:24px 24px 0 0;

}

.table{

margin-bottom:0;

}

.table thead th{

background:#0f766e;

color:#fff;

font-weight:600;

border:none;

text-align:center;

padding:16px;

white-space:nowrap;

}

.table tbody td{

vertical-align:middle;

text-align:center;

padding:15px;

}

.table tbody tr{

transition:.25s;

}

.table tbody tr:hover{

background:#f8fffd;

transform:translateY(-2px);

box-shadow:0 5px 18px rgba(0,0,0,.08);

}

.badge-kode{

background:#dcfce7;

color:#166534;

border-radius:30px;

padding:8px 14px;

font-weight:600;

}

.file-btn{

border-radius:30px;

padding:6px 15px;

}

.action-btn{

width:38px;

height:38px;

border-radius:50%;

display:flex;

justify-content:center;

align-items:center;

}

.empty-state{

padding:60px 20px;

}

.form-label{

font-size:14px;

margin-bottom:8px;

color:#003844;

}

.form-control{

min-height:48px;

border-radius:14px;

border:1px solid #dbe5ef;

transition:.3s;

}

.form-control:focus{

border-color:#0f766e;

box-shadow:0 0 0 .15rem rgba(15,118,110,.15);

}

.btn{

transition:.25s;

}

.btn:hover{

transform:translateY(-2px);

}

/* ===========================
   PAGINATION
=========================== */

.pagination{
    margin-bottom:0;
}

.page-link{
    border:none;
    color:#0f766e;
    border-radius:10px;
    margin:0 3px;
    transition:.3s;
}

.page-link:hover{
    background:#0f766e;
    color:#fff;
}

.page-item.active .page-link{
    background:#0f766e;
    color:#fff;
}

/* ===========================
   BUTTON
=========================== */

.btn{
    transition:.25s;
}

.btn:hover{
    transform:translateY(-2px);
}

.action-btn:hover{
    transform:scale(1.08);
}

/* ===========================
   CARD
=========================== */

.filter-card,
.table-card,
.info-card{

    transition:.3s;

}

.filter-card:hover,
.table-card:hover{

    box-shadow:0 12px 30px rgba(0,0,0,.10);

}

/* ===========================
   RESPONSIVE
=========================== */

@media(max-width:768px){

.page-header{

padding:25px;

}

.page-title{

font-size:27px;

}

.page-subtitle{

font-size:14px;

}

.info-card{

margin-bottom:15px;

}

.btn{

width:100%;

}

.table th,
.table td{

font-size:13px;

white-space:nowrap;

}

.running-text span{

animation-duration:65s;

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
RUNNING TEXT
=========================== --}}

<div class="running-box">

    <div class="d-flex align-items-center">

        <div class="icon">

            <i class="bi bi-megaphone-fill"></i>

        </div>

        <div class="running-text">

            <span>

                📤 Kelola Surat Keluar • Pastikan nomor surat, tujuan, perihal, penanggung jawab, serta lampiran telah sesuai sebelum surat dicetak maupun dikirim kepada instansi tujuan.

            </span>

        </div>

    </div>

</div>
{{-- ===========================
FILTER
=========================== --}}

<div class="card filter-card mb-4">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <div class="d-flex align-items-center justify-content-between flex-wrap">

            <div>

                <h5 class="fw-bold mb-1 text-dark">

                    <i class="bi bi-funnel-fill text-success me-2"></i>

                    Filter Data Surat Keluar

                </h5>

                <small class="text-muted">

                    Gunakan filter di bawah ini untuk mencari data surat keluar berdasarkan periode, kode arsip, atau perihal.

                </small>

            </div>

        </div>

    </div>

    <div class="card-body px-4 pb-4">

        <form action="{{ route('suratkeluar.index') }}" method="GET">

            <div class="row g-3">

                {{-- Tanggal Awal --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold text-dark">

                        <i class="bi bi-calendar-event me-1 text-success"></i>

                        Tanggal Awal

                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}">

                </div>

                {{-- Tanggal Akhir --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold text-dark">

                        <i class="bi bi-calendar2-check me-1 text-success"></i>

                        Tanggal Akhir

                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}">

                </div>

                {{-- Kode Arsip --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold text-dark">

                        <i class="bi bi-archive-fill me-1 text-success"></i>

                        Kode Arsip

                    </label>

                    <input
                        type="text"
                        name="kode_arsip"
                        class="form-control"
                        placeholder="Contoh : ARS-001"
                        value="{{ request('kode_arsip') }}">

                </div>

                {{-- Perihal --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold text-dark">

                        <i class="bi bi-card-heading me-1 text-success"></i>

                        Perihal

                    </label>

                    <input
                        type="text"
                        name="perihal"
                        class="form-control"
                        placeholder="Cari perihal surat..."
                        value="{{ request('perihal') }}">

                </div>

            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">

                <button
                    type="submit"
                    class="btn btn-success rounded-pill px-4">

                    <i class="bi bi-search me-2"></i>

                    Cari

                </button>

                <a
                    href="{{ route('suratkeluar.index') }}"
                    class="btn btn-secondary rounded-pill px-4">

                    <i class="bi bi-arrow-clockwise me-2"></i>

                    Reset

                </a>

                <a
                    href="{{ route('suratkeluar.create') }}"
                    class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-plus-circle me-2"></i>

                    Tambah

                </a>

                <a
                    href="{{ route('suratkeluar.print') }}"
                    target="_blank"
                    class="btn btn-danger rounded-pill px-4">

                    <i class="bi bi-printer-fill me-2"></i>

                    Cetak

                </a>

            </div>

        </form>

    </div>

</div>

    <!-- ===========================
TABEL SURAT KELUAR
=========================== -->

<div class="card table-card">

    <div class="card-header bg-white border-0 pt-4 px-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-table me-2 text-success"></i>

                    Data Surat Keluar

                </h5>

                <small class="text-muted">

                    Daftar seluruh surat keluar Kecamatan Mandalajati.

                </small>

            </div>

            <span class="badge bg-success rounded-pill px-3 py-2">

                Total {{ $suratkeluar->count() }} Data

            </span>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th class="text-center">No</th>

                        <th class="text-center">Kode Arsip</th>

                        <th class="text-center">Nomor Surat</th>

                        <th class="text-center">Judul</th>

                        <th class="text-center">Pengirim</th>

                        <th class="text-center">Tujuan</th>

                        <th class="text-center">Tanggal</th>

                        <th class="text-center">Perihal</th>

                        <th class="text-center">File</th>

                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($suratkeluar as $item)

                    <tr>

                        <td class="text-center">

                            {{ $loop->iteration }}

                        </td>

                        <td class="text-center">

                            <span class="badge bg-success rounded-pill px-3 py-2">

                                {{ $item->kodearsip->kode ?? '-' }}

                            </span>

                        </td>

                        <td>{{ $item->nomor_surat }}</td>

                        <td>{{ $item->judul }}</td>

                        <td>{{ $item->pengirim }}</td>

                        <td>{{ $item->tujuan }}</td>

                        <td class="text-center">

                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}

                        </td>

                        <td>{{ $item->perihal }}</td>

                        <td class="text-center">

                            @if($item->file_surat)

                                <a
                                    href="{{ asset('storage/'.$item->file_surat) }}"
                                    target="_blank"
                                    class="btn btn-success btn-sm rounded-pill">

                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>

                                    PDF

                                </a>

                            @else

                                <span class="badge bg-secondary">

                                    Tidak Ada

                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex justify-content-center gap-2">

                                <!-- DETAIL -->

                                <a
                                    href="{{ route('suratkeluar.show',$item->id) }}"
                                    class="btn btn-info btn-sm rounded-circle"
                                    title="Detail"
                                    style="width:38px;height:38px;">

                                    <i class="bi bi-eye-fill"></i>

                                </a>

                                <!-- EDIT -->

                                <a
                                    href="{{ route('suratkeluar.edit',$item->id) }}"
                                    class="btn btn-warning btn-sm rounded-circle"
                                    title="Edit"
                                    style="width:38px;height:38px;">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>

                                <!-- HAPUS -->

                                <form
                                    action="{{ route('suratkeluar.destroy',$item->id) }}"
                                    method="POST"
                                    class="form-delete">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm rounded-circle"
                                        style="width:38px;height:38px;"
                                        title="Hapus">

                                        <i class="bi bi-trash-fill"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10" class="text-center py-5">

                            <img

                                src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"

                                width="110"

                                class="mb-3">

                            <h5 class="fw-bold text-secondary">

                                Belum Ada Data Surat Keluar

                            </h5>

                            <p class="text-muted mb-3">

                                Silakan tambahkan data surat keluar terlebih dahulu.

                            </p>

                            <a

                                href="{{ route('suratkeluar.create') }}"

                                class="btn btn-success rounded-pill px-4">

                                <i class="bi bi-plus-circle-fill me-2"></i>

                                Tambah Surat

                            </a>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- ===========================
SWEET ALERT DELETE
=========================== --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {
    
        document.querySelectorAll('.form-delete').forEach(function(form){
    
            form.addEventListener('submit', function(e){
    
                e.preventDefault();
    
                Swal.fire({
    
                    title:'Yakin ingin menghapus?',
    
                    text:'Data Surat Keluar yang dihapus tidak dapat dikembalikan.',
    
                    icon:'warning',
    
                    showCancelButton:true,
    
                    confirmButtonColor:'#dc3545',
    
                    cancelButtonColor:'#6c757d',
    
                    confirmButtonText:'Ya, Hapus',
    
                    cancelButtonText:'Batal',
    
                    reverseButtons:true
    
                }).then((result)=>{
    
                    if(result.isConfirmed){
    
                        form.submit();
    
                    }
    
                });
    
            });
    
        });
    
    });
    
    </script>
    
    {{-- ===========================
    ANIMASI CARD
    =========================== --}}
    
    <script>
    
    document.addEventListener("DOMContentLoaded",function(){
    
        const cards=document.querySelectorAll('.info-card,.filter-card,.table-card');
    
        cards.forEach(function(card,index){
    
            card.style.opacity='0';
    
            card.style.transform='translateY(25px)';
    
            setTimeout(function(){
    
                card.style.transition='.45s ease';
    
                card.style.opacity='1';
    
                card.style.transform='translateY(0)';
    
            },150*index);
    
        });
    
    });
    
    </script>
    
    @endsection