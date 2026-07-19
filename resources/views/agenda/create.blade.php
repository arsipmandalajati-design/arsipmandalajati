@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Tambah Agenda Kegiatan
@endsection

@section('page-description')
Lengkapi kebutuhan kegiatan berdasarkan surat yang telah diverifikasi.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

.page-header{
    background:linear-gradient(135deg,#0f766e,#14b8a6);
    padding:28px;
    border-radius:20px;
    color:white;
    margin-bottom:25px;
}

.card-modern{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.form-control,
.form-select{
    border-radius:12px;
    min-height:48px;
}

.form-control:focus,
.form-select:focus{
    border-color:#0f766e;
    box-shadow:none;
}

.section-title{
    font-size:18px;
    font-weight:bold;
    color:#0f766e;
    border-left:5px solid #0f766e;
    padding-left:12px;
    margin-bottom:20px;
}

.btn-save{
    background:#0f766e;
    color:white;
    border-radius:12px;
    padding:10px 25px;
}

.btn-save:hover{
    background:#115e59;
    color:white;
}

.bg-readonly{
    background:#f8fafc;
}

</style>

@if(session('booking_error'))

<script>

document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'warning',
        title:'Jadwal Bentrok',
        text:'{{ session("booking_error") }}',
        confirmButtonColor:'#dc3545'

    });

});

</script>

@endif

@if($errors->any())

<div class="alert alert-danger">

<strong>

Terjadi kesalahan:

</strong>

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>

{{ $error }}

</li>

@endforeach

</ul>

</div>

@endif

<!-- CARD FORM -->

<div class="card card-modern">

<div class="card-body p-4">

<form
action="{{ route('agenda.store',$surat->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf

<!-- INFORMASI SURAT -->

<div class="section-title">

Informasi Surat

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-semibold">

Nama Kegiatan

</label>

<input
type="text"
name="nama_kegiatan"
class="form-control bg-readonly"
value="{{ old('nama_kegiatan',$surat->judul ?? '-') }}"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-semibold">

Penyelenggara

</label>

<input
type="text"
name="penyelenggara"
class="form-control bg-readonly"
value="{{ old('penyelenggara',$surat->pengirim ?? '-') }}"
readonly>

</div>

<div class="col-md-4 mb-3">

<label class="fw-semibold">

Tanggal

</label>

<input
type="date"
name="tanggal"
class="form-control bg-readonly"
value="{{ old('tanggal',$surat->tanggal_kegiatan) }}"
readonly>

</div>

<div class="col-md-4 mb-3">

<label class="fw-semibold">

Jam Mulai

</label>

<input
type="time"
name="jam_mulai"
class="form-control bg-readonly"
value="{{ old('jam_mulai',$surat->jam_mulai ?? '') }}"
readonly>

</div>

<div class="col-md-4 mb-3">

<label class="fw-semibold">

Jam Selesai

</label>

<input
type="time"
name="jam_selesai"
class="form-control bg-readonly"
value="{{ old('jam_selesai',$surat->jam_selesai ?? '') }}"
readonly>

</div>

<div class="col-md-6 mb-3">

    <label class="fw-semibold">
        Tempat
    </label>

    <input
        type="text"
        name="tempat"
        class="form-control bg-readonly"
        value="{{ old('tempat',$surat->tempat) }}"
        readonly>

</div>

<div class="col-md-6 mb-3">

    <label class="fw-semibold">
        Materi
    </label>

    <textarea
        class="form-control bg-readonly"
        rows="3"
        readonly>{{ old('materi',$surat->materi) }}</textarea>

</div>

<div class="col-md-3 mb-3">

    <label class="fw-semibold">

        Jumlah Peserta

    </label>

    <input
        type="number"
        class="form-control bg-readonly"
        value="{{ old('jumlah_peserta',$surat->jumlah_peserta) }}"
        readonly>

</div>

<hr>

<div class="section-title">

Kebutuhan Sarana

</div>

<div class="row">

<div class="col-md-2 mb-3">

<label>Kursi</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->kursi }}"
readonly>

</div>

<div class="col-md-2 mb-3">

<label>Meja</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->meja }}"
readonly>

</div>

<div class="col-md-2 mb-3">

<label>Proyektor</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->proyektor }}"
readonly>

</div>

<div class="col-md-2 mb-3">

<label>Mic</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->mic }}"
readonly>

</div>

<div class="col-md-2 mb-3">

<label>Sound System</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->sound_system }}"
readonly>

</div>

<div class="col-md-2 mb-3">

<label>Kabel Roll</label>

<input
type="number"
class="form-control bg-readonly"
value="{{ $surat->kabel_roll }}"
readonly>

</div>

@if($surat->lainnya)

<div class="col-md-12">

<label>Lainnya</label>

<textarea
class="form-control bg-readonly"
rows="2"
readonly>{{ $surat->lainnya }}</textarea>

</div>

@endif

</div>

<hr>

<!-- PENANGGUNG JAWAB DAN DOKUMENTASI -->

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="fw-semibold">

            Penanggung Jawab

        </label>

        <input
            type="text"
            class="form-control bg-readonly"
            value="{{ Auth::user()->name }}"
            readonly>

        <input
            type="hidden"
            name="penanggung_jawab"
            value="{{ Auth::user()->name }}">

    </div>



    <div class="col-md-6 mb-3">

        <label class="fw-semibold">

            Upload Dokumentasi (Opsional)

        </label>

        <input
            type="file"
            name="dokumentasi"
            class="form-control">

        <small class="text-muted">

            Format yang diperbolehkan:
            JPG, PNG, PDF

        </small>

    </div>

</div>



<!-- BUTTON -->

<div class="d-flex justify-content-end gap-2 mt-4">

    <a
        href="{{ route('agenda.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>



    <button
        type="submit"
        class="btn btn-save">

        <i class="bi bi-save"></i>

        Simpan Agenda

    </button>

</div>

</form>

</div>

</div>

@endsection