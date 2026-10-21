@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Hasil Kegiatan
@endsection

@section('page-description')
Isi hasil kegiatan setelah agenda selesai dilaksanakan.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.header-card {
    background: linear-gradient(135deg, #0f766e, #14b8a6, #2dd4bf);
    border-radius: 20px;
    padding: 30px;
    color: #fff;
    margin-bottom: 25px;
}

.card-custom {
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f766e;
    border-left: 5px solid #0f766e;
    padding-left: 10px;
    margin-bottom: 25px;
}

.form-control,
textarea {
    border-radius: 12px;
}

.form-control:focus,
textarea:focus {
    box-shadow: none;
    border-color: #0f766e;
}

.img-doc {
    width: 100%;
    border-radius: 15px;
    border: 1px solid #ddd;
    margin-top: 15px;
}

.label {
    color: #6b7280;
    font-size: 13px;
}

.value {
    font-weight: 600;
    margin-bottom: 18px;
}
</style>

<div class="card card-custom">
    <div class="card-body p-4">
        
        <div class="section-title">
            Informasi Agenda
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="label">Nama Kegiatan</div>
                <div class="value">{{ $agenda->nama_kegiatan }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Tanggal</div>
                <div class="value">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d F Y') }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Tempat</div>
                <div class="value">{{ $agenda->tempat }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Penyelenggara</div>
                <div class="value">{{ $agenda->penyelenggara }}</div>
            </div>
        </div>

        <hr>

        <form action="{{ route('agenda.simpanHasil', $agenda->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">
                Hasil Pelaksanaan
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Hasil Kegiatan</label>
                <textarea name="hasil_kegiatan" rows="4" class="form-control">{{ old('hasil_kegiatan', $agenda->hasil_kegiatan) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Upload Dokumentasi</label>
                <input type="file" name="dokumentasi" class="form-control">

                @if($agenda->dokumentasi)
                    <img src="{{ asset('storage/' . $agenda->dokumentasi) }}" class="img-doc">
                @endif
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('agenda.index', $agenda->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Hasil
                </button>
            </div>

        </form>

    </div>
</div>

@endsection