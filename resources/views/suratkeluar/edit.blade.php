@extends('layouts.app')

@section('page-icon')
<i class="bi bi-pencil-square"></i>
@endsection

@section('page-title')
Edit Surat Keluar
@endsection

@section('page-description')
Perbarui data surat keluar Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .page-header {
        background: linear-gradient(135deg, #003844, #0f766e, #64c8b8);
        border-radius: 28px;
        padding: 35px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(0, 56, 68, .15);
    }
    .page-header::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(255, 255, 255, .08);
        border-radius: 50%;
        right: -70px;
        top: -70px;
    }
    .page-header::after {
        content: "📝";
        position: absolute;
        right: 30px;
        bottom: 15px;
        font-size: 110px;
        opacity: .08;
    }
    .page-title-text {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .page-subtitle {
        font-size: 15px;
        line-height: 1.8;
        max-width: 650px;
        opacity: .95;
    }
    .form-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f766e;
        border-left: 5px solid #0f766e;
        padding-left: 15px;
        margin-bottom: 22px;
    }
    .form-control, .form-select {
        border-radius: 14px;
        min-height: 50px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .15);
    }
    .preview-file {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 15px;
    }
    .btn-save {
        background: #0f766e;
        color: white;
        border: none;
        border-radius: 14px;
        padding: 12px 28px;
        transition: .25s;
    }
    .btn-save:hover {
        background: #0b5f59;
        color: white;
        transform: translateY(-2px);
    }
    .required {
        color: #dc2626;
        font-weight: bold;
    }
    .bg-readonly {
        background-color: #e9ecef !important;
        opacity: 1;
    }
</style>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <b><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi Kesalahan Validation</b>
    <hr>
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card form-card">
    <div class="card-body p-4">
        <form action="{{ route('suratkeluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="section-title">Informasi Arsip</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Kode Arsip <span class="required">*</span>
                    </label>

                    <select name="kode_arsip_id" id="kode_arsip" class="form-select @error('kode_arsip_id') is-invalid @enderror" required>
                        @foreach($kodearsip as $item)
                            <option value="{{ $item->id }}" data-kode="{{ $item->kode }}"
                                {{ old('kode_arsip_id', $suratKeluar->kode_arsip_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->kode }} - {{ $item->nama_arsip }}
                            </option>
                        @endforeach
                    </select>

                    @error('kode_arsip_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nomor Registrasi / Manual</label>
                    <input type="text" id="nomor_manual" name="nomor_manual" class="form-control" 
                           placeholder="Contoh : 035-Pel.DN" 
                           value="{{ old('nomor_manual', $suratKeluar->nomor_manual ?? '') }}">
                    <small class="text-muted">Isi jika ingin memicu pembuatan nomor surat baru secara otomatis.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="section-title">
                <i class="bi bi-envelope-paper-fill me-2"></i> Informasi Surat
            </div>

            <div class="row">
                <!-- NOMOR SURAT -->
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-hash me-1 text-success"></i> Nomor Surat
                    </label>

                    <input type="text" id="nomor_surat" name="nomor_surat" 
                           class="form-control bg-readonly" 
                           value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" readonly>

                    <small class="text-muted">Nomor surat otomatis diperbarui jika kode arsip & nomor manual diubah.</small>
                </div>

                <!-- JUDUL -->
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-card-heading me-1 text-success"></i> Judul Surat <span class="required">*</span>
                    </label>

                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul', $suratKeluar->judul) }}" required>

                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TUJUAN -->
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-building me-1 text-success"></i> Tujuan <span class="required">*</span>
                    </label>

                    <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
                           value="{{ old('tujuan', $suratKeluar->tujuan) }}" required>

                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TANGGAL -->
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-event me-1 text-success"></i> Tanggal Surat <span class="required">*</span>
                    </label>

                    <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror"
                           value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}" required>

                    @error('tanggal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PERIHAL -->
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-chat-left-text-fill me-1 text-success"></i> Perihal <span class="required">*</span>
                    </label>

                    <textarea name="perihal" rows="4" class="form-control @error('perihal') is-invalid @enderror" required>{{ old('perihal', $suratKeluar->perihal) }}</textarea>

                    @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- FILE SURAT SAAT INI -->
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> File Surat Saat Ini
                    </label>

                    <div class="preview-file">
                        @if($suratKeluar->file_surat)
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                    <strong>Dokumen PDF tersedia</strong>
                                    <br>
                                    <small class="text-muted">Klik tombol di samping untuk membuka dokumen.</small>
                                </div>
                                <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank" class="btn btn-danger rounded-pill mt-3 mt-md-0">
                                    <i class="bi bi-eye-fill me-2"></i> Lihat PDF
                                </a>
                            </div>
                        @else
                            <div class="text-muted">
                                <i class="bi bi-exclamation-circle me-2"></i> Belum ada file PDF yang tersimpan.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- UPLOAD FILE BARU -->
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-upload text-success me-1"></i> Upload File PDF Baru
                    </label>

                    <input type="file" id="file_surat" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror" accept=".pdf">
                    <small class="text-muted">Kosongkan apabila tidak ingin mengganti file lama (Maksimal PDF 5MB).</small>

                    @error('file_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="namaFile" class="mt-3">
                        <span class="badge bg-secondary rounded-pill px-3 py-2">Belum memilih file baru.</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="bi bi-info-circle-fill text-success me-2"></i> Periksa kembali data sebelum menyimpan perubahan.
                    </small>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-3 mt-md-0">
                        <a href="{{ route('suratkeluar.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                        </a>

                        <button type="submit" class="btn btn-save rounded-pill px-4">
                            <i class="bi bi-check-circle-fill me-2"></i> Update Surat
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputKodeArsip = document.getElementById('kode_arsip');
        const inputNomorManual = document.getElementById('nomor_manual');
        const inputNomorSurat = document.getElementById('nomor_surat');
        const inputFileSurat = document.getElementById('file_surat');
        const defaultNomorSurat = "{{ $suratKeluar->nomor_surat }}";

        // Generate Nomor Surat Otomatis
        function generateNomor() {
            let selected = inputKodeArsip.options[inputKodeArsip.selectedIndex];
            let kode = selected ? selected.getAttribute('data-kode') : '';
            let manual = inputNomorManual.value.trim();

            if (kode && manual) {
                let tahun = new Date().getFullYear();
                let bulan = new Date().getMonth() + 1;
                let romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

                inputNomorSurat.value = `No.${kode}/${manual}-Kec.MDLJ/T/${romawi[bulan]}/${tahun}`;
            } else if (!manual) {
                inputNomorSurat.value = defaultNomorSurat;
            }
        }

        inputKodeArsip.addEventListener('change', generateNomor);
        inputNomorManual.addEventListener('input', generateNomor);

        inputFileSurat.addEventListener('change', function() {
            let file = this.files[0];
            let container = document.getElementById('namaFile');

            if (file) {
                container.innerHTML = `
                    <span class="badge bg-success rounded-pill px-3 py-2">
                        <i class="bi bi-check-circle-fill me-2"></i> ${file.name}
                    </span>`;
            } else {
                container.innerHTML = `
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Belum memilih file baru.</span>`;
            }
        });

        const card = document.querySelector(".form-card");
        card.style.opacity = "0";
        card.style.transform = "translateY(25px)";
        setTimeout(() => {
            card.style.transition = ".45s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 150);
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0f766e'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>

@endsection