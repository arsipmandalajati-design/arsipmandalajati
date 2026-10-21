@extends('layouts.app')

@section('page-icon')
<i class="bi bi-pencil-square"></i>
@endsection

@section('page-title')
Edit Data Arsip
@endsection

@section('page-description')
Perbarui informasi dokumen atau surat masuk dan keluar Kecamatan Mandalajati
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-warning text-dark px-4 py-3 rounded-top-4">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Formulir Edit Data Arsip</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">No. Registrasi</label>
                        <input type="text" class="form-control bg-light rounded-3" value="{{ $arsip->nomor_registrasi }}" readonly>
                        <small class="text-muted">Nomor registrasi terikat otomatis dari sistem surat dan tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label for="kode_arsip" class="form-label fw-bold">Kode Arsip</label>
                        <input type="text" class="form-control rounded-3 @error('kode_arsip') is-invalid @enderror" id="kode_arsip" name="kode_arsip" value="{{ old('kode_arsip', $arsip->kode_arsip) }}" required>
                        @error('kode_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_arsip" class="form-label fw-bold">Perihal / Nama Arsip</label>
                        <textarea class="form-control rounded-3 @error('nama_arsip') is-invalid @enderror" id="nama_arsip" name="nama_arsip" rows="3" required>{{ old('nama_arsip', $arsip->nama_arsip) }}</textarea>
                        @error('nama_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="retensi_tahun" class="form-label fw-bold">Masa Retensi (Tahun)</label>
                        <input type="number" class="form-control rounded-3 @error('retensi_tahun') is-invalid @enderror" id="retensi_tahun" name="retensi_tahun" value="{{ old('retensi_tahun', $arsip->retensi_tahun) }}" required>
                        @error('retensi_tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file_arsip" class="form-label fw-bold">Ganti File Arsip (Opsional)</label>
                        @if($arsip->file_arsip)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $arsip->file_arsip) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat File Saat Ini
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control rounded-3 @error('file_arsip') is-invalid @enderror" id="file_arsip" name="file_arsip" accept=".pdf,.doc,.docx,.jpg,.png">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file dokumen.</small>
                        @error('file_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('arsip.index') }}" class="btn btn-secondary rounded-3 px-4">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success rounded-3 px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection