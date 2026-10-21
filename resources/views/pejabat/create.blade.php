@extends('layouts.app')
@section('page-icon')
<i class="bi bi-person-plus-fill"></i>
@endsection

@section('page-title')
Tambah Data Pejabat
@endsection

@section('page-description')
Kelola dan tambahkan data pejabat baru Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- FORM -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('pejabat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Pejabat</label>
                    <input type="text" name="nama_pejabat" class="form-control" value="{{ old('nama_pejabat') }}" placeholder="Contoh: Drs. H. Budi Santoso, M.Si" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Contoh: 197503121998031005" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email Kedinasan <small class="text-muted fw-normal">(Untuk akun login user)</small></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="budi@mandalajati.go.id" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jabatan</label>
                    <select name="jabatan" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Camat" {{ old('jabatan') == 'Camat' ? 'selected' : '' }}>Camat</option>
                        <option value="Kasubag Umum" {{ old('jabatan') == 'Kasubag Umum' ? 'selected' : '' }}>Kasubag Umum</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Upload Tanda Tangan</label>
                    <input type="file" name="tanda_tangan" class="form-control" accept="image/png, image/jpeg">
                    <small class="text-muted">Format: PNG, JPG, JPEG (Maks. 2MB)</small>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('pejabat.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection