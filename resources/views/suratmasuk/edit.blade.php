@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.page-header{
    background:linear-gradient(135deg,#0f766e,#14b8b6);
    border-radius:20px;
    padding:28px;
    color:white;
    margin-bottom:25px;
}

.form-card{
    border:none;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
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
    font-weight:700;
    color:#0f766e;
    border-left:5px solid #0f766e;
    padding-left:12px;
    margin-bottom:20px;
}

.btn-save{
    background:#0f766e;
    color:white;
    border-radius:12px;
    padding:10px 24px;
}

.btn-save:hover{
    background:#115e59;
    color:white;
}

.bg-readonly{
    background:#f8fafc;
}

</style>

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



<div class="page-header">

<h3 class="fw-bold">

<i class="bi bi-pencil-square"></i>

Edit Surat Masuk

</h3>

<p class="mb-0">

Perbarui data surat masuk yang sudah tersimpan.

</p>

</div>



<div class="card form-card">

<div class="card-body p-4">

<form
action="{{ route('suratmasuk.update',$surat->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')



<div class="section-title">

Informasi Arsip

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-semibold">

Kode Arsip

</label>

<select
name="kode_arsip_id"
id="kode_arsip_id"
class="form-select"
required>

<option value="">-- Pilih Kode Arsip --</option>

@foreach($kodearsip as $item)

<option
value="{{ $item->id }}"
data-kode="{{ $item->kode }}"
{{ old('kode_arsip_id',$surat->kode_arsip_id)==$item->id?'selected':'' }}>

{{ $item->kode }}
-
{{ $item->nama_arsip }}

</option>

@endforeach

</select>

</div>



<div class="col-md-6 mb-3">

<label class="fw-semibold">

Nomor Surat

</label>

<input
type="text"
name="nomor_surat"
id="nomor_surat"
class="form-control"
value="{{ old('nomor_surat',$surat->nomor_surat) }}"
required>

</div>



<div class="col-md-6 mb-3">

<label class="fw-semibold">

Judul Surat

</label>

<input
type="text"
name="judul"
class="form-control"
value="{{ old('judul',$surat->judul) }}"
required>

</div>



<div class="col-md-6 mb-3">

<label class="fw-semibold">

Pengirim

</label>

<input
type="text"
name="pengirim"
class="form-control"
value="{{ old('pengirim',$surat->pengirim) }}"
required>

</div>



<div class="col-md-6 mb-3">

<label class="fw-semibold">

Tanggal Surat

</label>

<input
type="date"
name="tanggal_surat"
class="form-control"
value="{{ old('tanggal_surat',$surat->tanggal_surat) }}"
required>

</div>



<div class="col-md-6 mb-3">

<label class="fw-semibold">

Perihal

</label>

<input
type="text"
name="perihal"
class="form-control"
value="{{ old('perihal',$surat->perihal) }}"
required>

</div>
<div class="section-title">

    File Surat
    
    </div>
    
    <div class="row">
    
    <div class="col-md-12 mb-3">
    
    <label class="fw-semibold">
    
    Upload File Surat
    
    </label>
    
    <input
    type="file"
    name="file_surat"
    class="form-control"
    accept=".pdf">
    
    <small class="text-muted">
    
    Kosongkan jika tidak ingin mengganti file surat.
    
    </small>
    
    </div>
    
    @if($surat->file_surat)
    
    <div class="col-md-12 mb-4">
    
    <label class="fw-semibold">
    
    File Surat Saat Ini
    
    </label>
    
    <br>
    
    <a
    href="{{ asset('storage/'.$surat->file_surat) }}"
    target="_blank"
    class="btn btn-danger">
    
    <i class="bi bi-file-earmark-pdf-fill"></i>
    
    Lihat File PDF
    
    </a>
    
    </div>
    
    @endif
    
    </div>
    
    <hr class="my-4">
    
    <div class="section-title">
    
    Informasi Kegiatan
    
    </div>
    
    <div class="row">
    
    <div class="col-md-6 mb-3">
    
    <label class="fw-semibold">
    
    Tempat
    
    </label>
    
    <select
    name="tempat"
    class="form-select">
    
    <option value="">-- Pilih Tempat --</option>
    
    <option value="Aula Kecamatan"
    {{ old('tempat',$surat->tempat)=='Aula Kecamatan'?'selected':'' }}>
    Aula Kecamatan
    </option>
    
    <option value="Ruang Camat"
    {{ old('tempat',$surat->tempat)=='Ruang Camat'?'selected':'' }}>
    Ruang Camat
    </option>
    
    <option value="Ruang Sekretaris"
    {{ old('tempat',$surat->tempat)=='Ruang Sekretaris'?'selected':'' }}>
    Ruang Sekretaris
    </option>
    
    <option value="Ruang Rapat"
    {{ old('tempat',$surat->tempat)=='Ruang Rapat'?'selected':'' }}>
    Ruang Rapat
    </option>
    
    <option value="Halaman Kecamatan"
    {{ old('tempat',$surat->tempat)=='Halaman Kecamatan'?'selected':'' }}>
    Halaman Kecamatan
    </option>
    
    </select>
    
    </div>
    
    <div class="col-md-6 mb-3">
    
    <label class="fw-semibold">
    
    Tanggal Kegiatan
    
    </label>
    
    <input
    type="date"
    name="tanggal_kegiatan"
    class="form-control"
    value="{{ old('tanggal_kegiatan',$surat->tanggal_kegiatan) }}">
    
    </div>
    
    <div class="col-md-6 mb-3">
    
    <label class="fw-semibold">
    
    Jam Mulai
    
    </label>
    
    <input
    type="time"
    name="jam_mulai"
    class="form-control"
    value="{{ old('jam_mulai',$surat->jam_mulai) }}">
    
    </div>
    
    <div class="col-md-6 mb-3">
    
    <label class="fw-semibold">
    
    Jam Selesai
    
    </label>
    
    <input
    type="time"
    name="jam_selesai"
    class="form-control"
    value="{{ old('jam_selesai',$surat->jam_selesai) }}">
    
    </div>
    
    <div class="col-md-12 mb-3">
    
    <label class="fw-semibold">
    
    Materi Kegiatan
    
    </label>
    
    <textarea
    name="materi"
    rows="4"
    class="form-control"
    placeholder="Tuliskan materi kegiatan...">{{ old('materi',$surat->materi) }}</textarea>
    
    </div>
    
    </div>
    <hr class="my-4">

<div class="d-flex justify-content-end gap-2">

    <a
        href="{{ route('suratmasuk.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>

    <button
        type="submit"
        class="btn btn-save">

        <i class="bi bi-check-circle"></i>

        Update Surat

    </button>

</div>

</form>

</div>

</div>

<script>

function generateNomor(){

    let select = document.getElementById('kode_arsip_id');

    let kode = '';

    if(select.selectedIndex >= 0){

        kode = select.options[
            select.selectedIndex
        ].getAttribute('data-kode');

    }

    let nomorLama =
        document.getElementById('nomor_surat').value;

    if(
        nomorLama === '' ||
        nomorLama.indexOf('/') === -1
    ){
        return;
    }

    let bagian = nomorLama.split('/');

    if(bagian.length >= 2){

        let nomorManual = bagian[1].split('-')[0];

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

        document.getElementById('nomor_surat').value =

        'No.' +
        kode +
        '/' +
        nomorManual +
        '-Kec.MDLJ/T/' +
        romawi[bulan] +
        '/' +
        tahun;

    }

}

document
.getElementById('kode_arsip_id')
.addEventListener(
    'change',
    generateNomor
);

</script>

@endsection