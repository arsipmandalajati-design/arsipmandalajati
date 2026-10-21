@extends('layouts.app')

@section('page-icon')
<i class="bi bi-pencil-square"></i>
@endsection

@section('page-title')
Edit Data Pejabat
@endsection

@section('page-description')
Kelola dan perbarui data pejabat Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- FORM -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('pejabat.update', $pejabat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_pejabat" class="form-label">Nama Pejabat</label>
                <input type="text" class="form-control" id="nama_pejabat" name="nama_pejabat" 
                 value="{{ old('nama_pejabat', $pejabat->nama_pejabat ?? optional($pejabat->user)->name) }}" required>
            </div>
        
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $pejabat->nip) }}" required>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}" required>
            </div>

                <!-- Upload Tanda Tangan Baru -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Upload Tanda Tangan Baru</label>
                    <input type="file" name="tanda_tangan" class="form-control" accept="image/png, image/jpeg">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah tanda tangan.</small>
                </div>

            @if($pejabat->tanda_tangan)
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Tanda Tangan Saat Ini:</label>
                <img src="{{ asset('storage/'.$pejabat->tanda_tangan) }}" width="150" class="rounded border shadow-sm p-1 bg-light">
            </div>
            @endif

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Perbarui Data
                </button>
                <a href="{{ route('pejabat.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection