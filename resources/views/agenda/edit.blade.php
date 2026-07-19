@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.page-header{
    background:linear-gradient(135deg,#667eea,#4f46e5);
    border-radius:20px;
    padding:30px;
    color:white;
    margin-bottom:25px;
}

.form-card{
    border:none;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.form-control,
.form-select,
textarea{
    border-radius:12px;
    min-height:48px;
}

.form-control:focus,
.form-select:focus,
textarea:focus{
    border-color:#4f46e5;
    box-shadow:none;
}

.section-title{
    font-size:17px;
    font-weight:700;
    color:#4f46e5;
    border-left:4px solid #4f46e5;
    padding-left:10px;
    margin-bottom:20px;
}

.btn-save{
    background:#4f46e5;
    border:none;
    border-radius:12px;
    padding:10px 25px;
}

.btn-save:hover{
    background:#4338ca;
}

.btn-back{
    border-radius:12px;
    padding:10px 25px;
}

</style>

@if($errors->any())

<div class="alert alert-danger">

    <ul class="mb-0">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<!-- HEADER -->

<div class="page-header">

    <h2 class="fw-bold">

        <i class="bi bi-pencil-square"></i>

        Edit Agenda Kegiatan

    </h2>

    <p class="mb-0">

        Perbarui informasi agenda kegiatan Kecamatan Mandalajati.

    </p>

</div>

<!-- FORM -->

<div class="card form-card">

<div class="card-body p-4">

<form action="{{ route('agenda.update',$agenda->id) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<!-- INFORMASI AGENDA -->

<div class="section-title">

    Informasi Agenda

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Nama Kegiatan

</label>

<input
type="text"
name="nama_kegiatan"
class="form-control"
value="{{ old('nama_kegiatan',$agenda->nama_kegiatan) }}"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Penyelenggara

</label>

<input
type="text"
name="penyelenggara"
class="form-control"
value="{{ old('penyelenggara',$agenda->penyelenggara) }}"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label fw-semibold">

Tanggal

</label>

<input
type="date"
name="tanggal"
class="form-control"
value="{{ old('tanggal',$agenda->tanggal) }}"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label fw-semibold">

Jam Mulai

</label>

<input
type="time"
name="jam_mulai"
class="form-control"
value="{{ old('jam_mulai',$agenda->jam_mulai) }}"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label fw-semibold">

Jam Selesai

</label>

<input
type="time"
name="jam_selesai"
class="form-control"
value="{{ old('jam_selesai',$agenda->jam_selesai) }}"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label fw-semibold">

Status

</label>

<select
name="status"
class="form-select">

<option value="Terjadwal"
{{ old('status',$agenda->status)=='Terjadwal' ? 'selected' : '' }}>
Terjadwal
</option>

<option value="Selesai"
{{ old('status',$agenda->status)=='Selesai' ? 'selected' : '' }}>
Selesai
</option>

<option value="Ditunda"
{{ old('status',$agenda->status)=='Ditunda' ? 'selected' : '' }}>
Ditunda
</option>

</select>

</div>

<div class="col-md-8 mb-3">

<label class="form-label fw-semibold">

Tempat

</label>

<input
type="text"
name="tempat"
class="form-control"
value="{{ old('tempat',$agenda->tempat) }}"
required>

</div>

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Materi Kegiatan

</label>

<textarea
name="materi"
rows="4"
class="form-control">{{ old('materi',$agenda->materi) }}</textarea>

</div>

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Keterangan

</label>

<textarea
name="keterangan"
rows="4"
class="form-control">{{ old('keterangan',$agenda->keterangan) }}</textarea>

</div>

<!-- ===========================
HASIL KEGIATAN
=========================== -->

<div class="section-title mt-4">

Hasil Pelaksanaan Kegiatan

</div>

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Hasil Kegiatan

</label>

<textarea
name="hasil_kegiatan"
rows="4"
class="form-control"
placeholder="Contoh: Kegiatan berjalan dengan lancar...">{{ old('hasil_kegiatan',$agenda->hasil_kegiatan) }}</textarea>

</div>

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Hasil Materi

</label>

<textarea
name="hasil_materi"
rows="4"
class="form-control"
placeholder="Tuliskan hasil materi yang disampaikan...">{{ old('hasil_materi',$agenda->hasil_materi) }}</textarea>

</div>

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Catatan

</label>

<textarea
name="catatan"
rows="4"
class="form-control"
placeholder="Catatan tambahan...">{{ old('catatan',$agenda->catatan) }}</textarea>

</div>

<div class="col-md-12 mb-4">

<label class="form-label fw-semibold">

Upload Dokumentasi Baru

</label>

<input
type="file"
name="dokumentasi"
class="form-control">

<small class="text-muted">

Kosongkan jika tidak ingin mengganti dokumentasi.

</small>

</div>

@if($agenda->dokumentasi)

<div class="col-md-12 mb-4">

<label class="form-label fw-semibold">

Dokumentasi Saat Ini

</label>

<br>

<img
src="{{ asset('storage/'.$agenda->dokumentasi) }}"
class="img-fluid rounded shadow"
width="350">

</div>

@endif

</div>

<hr>

<!-- ===========================
KEBUTUHAN ACARA
=========================== -->

<div class="section-title">

    Kebutuhan Acara

</div>

<div class="mb-4">

    <label class="form-label fw-semibold">

        Barang / Peralatan yang Dibutuhkan

    </label>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-primary">

                <tr>

                    <th width="70%">Peralatan</th>

                    <th width="30%">Jumlah</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>🪑 Kursi</td>

                    <td>

                        <input
                            type="number"
                            name="kursi"
                            class="form-control"
                            min="0"
                            value="{{ old('kursi',$agenda->kursi ?? 0) }}">

                    </td>

                </tr>

                <tr>

                    <td>🪑 Meja</td>

                    <td>

                        <input
                            type="number"
                            name="meja"
                            class="form-control"
                            min="0"
                            value="{{ old('meja',$agenda->meja ?? 0) }}">

                    </td>

                </tr>

                <tr>

                    <td>📽 Proyektor</td>

                    <td>

                        <input
                            type="number"
                            name="proyektor"
                            class="form-control"
                            min="0"
                            value="{{ old('proyektor',$agenda->proyektor ?? 0) }}">

                    </td>

                </tr>

                <tr>

                    <td>🎤 Microphone</td>

                    <td>

                        <input
                            type="number"
                            name="mic"
                            class="form-control"
                            min="0"
                            value="{{ old('mic',$agenda->mic ?? 0) }}">

                    </td>

                </tr>

                <tr>

                    <td>🔊 Sound System</td>

                    <td>

                        <input
                            type="number"
                            name="sound_system"
                            class="form-control"
                            min="0"
                            value="{{ old('sound_system',$agenda->sound_system ?? 0) }}">

                    </td>

                </tr>

                <tr>

                    <td>🔌 Kabel Roll</td>

                    <td>

                        <input
                            type="number"
                            name="kabel_roll"
                            class="form-control"
                            min="0"
                            value="{{ old('kabel_roll',$agenda->kabel_roll ?? 0) }}">

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <div class="mt-3">

        <label class="form-label fw-semibold">

            Kebutuhan Lainnya

        </label>

        <textarea
            name="lainnya"
            rows="3"
            class="form-control"
            placeholder="Tuliskan kebutuhan lainnya...">{{ old('lainnya',$agenda->lainnya) }}</textarea>

    </div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2 mt-4">

    <a
        href="{{ route('agenda.index') }}"
        class="btn btn-secondary btn-back">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>

    <button
        type="submit"
        class="btn btn-save text-white">

        <i class="bi bi-check-circle"></i>

        Update Agenda

    </button>

</div>

</form>

</div>

</div>

@endsection