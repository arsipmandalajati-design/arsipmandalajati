@extends('layouts.app')

@section('page-icon')
<i class="bi bi-folder-plus"></i>
@endsection

@section('page-title')
Tambah Kode Arsip
@endsection

@section('page-description')
Kelola klasifikasi kode arsip Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@if ($errors->any())
<div class="alert alert-danger rounded-4 shadow-sm mb-4">
    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Periksa kembali inputan Anda:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        
        <form action="{{ route('kodearsip.store') }}" method="POST">
            @csrf

            <!-- KODE ARSIP -->
            <div class="mb-3">
                <label class="form-label fw-bold">Kode Arsip <span class="text-danger">*</span></label>
                <input type="text" name="kode" class="form-control rounded-3" placeholder="Contoh: UM.01.02" value="{{ old('kode') }}" required>
                <small class="text-muted">Masukkan kode klasifikasi arsip sesuai standar tata naskah dinas.</small>
            </div>

            <!-- NAMA KLASIFIKASI / NAMA ARSIP -->
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Klasifikasi Arsip <span class="text-danger">*</span></label>
                <input type="text" name="nama_arsip" class="form-control rounded-3" placeholder="Contoh: Kepegawaian & Cuti" value="{{ old('nama_arsip') }}" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('kodearsip.index') }}" class="btn btn-secondary px-4 rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4 rounded-3">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection