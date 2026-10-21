@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Registrasi Surat Keluar
@endsection

@section('page-description')
Silakan lengkapi data surat keluar beserta dokumen digitalnya.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.form-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
}

.card-header-custom {
    background: #fff;
    color: #1e293b;
    font-size: 16px;
    font-weight: 700;
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
}

.card-header-custom i {
    color: #0d9488;
    font-size: 18px;
    margin-right: 10px;
}

.card-body {
    padding: 24px;
}

.form-label {
    font-weight: 600;
    color: #334155;
    font-size: 13px;
    margin-bottom: 6px;
}

.required {
    color: #ef4444;
}

.form-control,
.form-select {
    height: 45px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    color: #1e293b;
    padding: 0.5rem 0.875rem;
}

textarea.form-control {
    height: auto;
    min-height: 110px;
    padding: 0.75rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
}

.readonly-box {
    background: #f8fafc;
    font-weight: 600;
    color: #475569;
}

.text-helper {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}

.upload-area {
    border: 2px dashed #99f6e4;
    border-radius: 14px;
    background: #f0fdfa;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.upload-area:hover {
    background: #ccfbf1;
    border-color: #0d9488;
}

.upload-area i {
    font-size: 42px;
    color: #0d9488;
}

.btn-primary {
    background: #0d9488;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 600;
    font-size: 14px;
}

.btn-primary:hover {
    background: #0f766e;
}

.btn-outline-secondary {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 14px;
    border-color: #cbd5e1;
    color: #475569;
}

.btn-outline-secondary:hover {
    background: #f1f5f9;
    color: #1e293b;
}
</style>

@if ($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Periksa kembali inputan Anda:</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formRegistrasiSuratKeluar" action="{{ route('suratkeluar.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- ===================================================== --}}
{{-- KARTU: INFORMASI SURAT (KODE ARSIP & NOMOR REGISTRASI DIGABUNG DISINI) --}}
{{-- ===================================================== --}}
<div class="card form-card">
    <div class="card-header-custom">
        <i class="bi bi-file-earmark-text"></i> Informasi Surat
    </div>
    <div class="card-body">
        <div class="row g-3">
            {{-- KODE ARSIP --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-folder me-1 text-muted"></i> Kode Arsip <span class="required">*</span></label>
                <select name="kode_arsip_id" id="kode_arsip_id" class="form-control select2">
                    <option value="" disabled selected>-- Pilih Kode Arsip --</option>
                    @foreach($kodearsip as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->kode }} - {{ $item->nama_arsip }}
                        </option>
                    @endforeach
                </select>
                <div class="text-helper">Pilih klasifikasi arsip untuk men-generate nomor registrasi.</div>
            </div>

            {{-- NOMOR REGISTRASI --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-123 me-1 text-muted"></i> Nomor Registrasi <span class="required">*</span></label>
                <input type="text" id="nomor_registrasi" class="form-control readonly-box" readonly placeholder="Otomatis terisi dari kode arsip...">
                <input type="hidden" name="nomor_registrasi" id="nomor_registrasi_hidden">
                <div class="text-helper">Dibuat otomatis berdasarkan kode arsip.</div>
            </div>

            {{-- NOMOR SURAT KELUAR --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-hash me-1 text-muted"></i> Nomor Surat Keluar <span class="required">*</span></label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" placeholder="Contoh: 005/123-Kec.Mandalajati/2026" value="{{ old('nomor_surat') }}" required>
                <div class="text-helper">Masukkan nomor surat keluar resmi dari instansi.</div>
            </div>

            {{-- JUDUL SURAT --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-journal-text me-1 text-muted"></i> Judul Surat <span class="required">*</span></label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul surat" value="{{ old('judul') }}" required>
            </div>

            {{-- TUJUAN SURAT --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-building me-1 text-muted"></i> Tujuan Surat <span class="required">*</span></label>
                <input type="text" name="tujuan" class="form-control" placeholder="Masukkan instansi tujuan" value="{{ old('tujuan') }}" required>
            </div>

            {{-- TANGGAL SURAT --}}
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-calendar-event me-1 text-muted"></i> Tanggal Surat <span class="required">*</span></label>
                <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
            </div>

            {{-- PERIHAL --}}
            <div class="col-12">
                <label class="form-label"><i class="bi bi-chat-left-text me-1 text-muted"></i> Perihal <span class="required">*</span></label>
                <textarea name="perihal" class="form-control" placeholder="Tuliskan perihal surat..." required>{{ old('perihal') }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- KARTU: DOKUMEN SURAT --}}
{{-- ===================================================== --}}
<div class="card form-card">
    <div class="card-header-custom">
        <i class="bi bi-cloud-arrow-up"></i> Dokumen Surat Keluar
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-lg-5">
                <label class="form-label">Upload Dokumen <span class="required">*</span></label>
                <div class="upload-area" id="btnUploadArea">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <h6 class="mt-2 fw-bold text-dark">Pilih File Surat Keluar</h6>
                    <p class="text-muted mb-1 small">PDF, JPG, JPEG, PNG</p>
                    <span class="text-muted" style="font-size: 11px;">Maksimal ukuran 5 MB</span>
                </div>
                <input type="file" id="file_surat" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" hidden required>
                
                <div id="fileInfo" class="alert alert-success mt-3 py-2 px-3 small d-none mb-0">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    <span id="namaFile"></span>
                </div>
            </div>

            <div class="col-lg-7">
                <label class="form-label">Preview Dokumen</label>
                <div id="previewArea" class="border rounded-3 bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 230px;">
                    <div id="previewEmpty" class="text-center p-3">
                        <i class="bi bi-file-earmark-pdf fs-1 text-muted"></i>
                        <p class="text-muted small mt-2 mb-0">Preview dokumen akan muncul setelah file dipilih.</p>
                    </div>
                    <iframe id="previewPDF" style="display:none; width:100%; height:100%; border:none;"></iframe>
                    <img id="previewIMG" style="display:none; width:100%; height:100%; object-fit:contain;">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- KARTU: DISPOSISI (KHUSUS HAK AKSES ADMIN) --}}
{{-- ===================================================== --}}
@if(auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->is_admin))
<div class="card form-card border-teal">
    <div class="card-header-custom" style="background: #f0fdfa; color: #0f766e;">
        <i class="bi bi-diagram-3-fill"></i> Disposisi & Catatan Pimpinan (Khusus Admin)
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label"><i class="bi bi-journal-check me-1 text-muted"></i> Catatan Disposisi</label>
                <textarea name="disposisi" class="form-control" placeholder="Masukkan instruksi atau catatan disposisi untuk ditindaklanjuti...">{{ old('disposisi') }}</textarea>
                <div class="text-helper">Catatan ini hanya dapat diisi oleh pihak Administrator/Pimpinan.</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===================================================== --}}
{{-- BUTTON AKSI --}}
{{-- ===================================================== --}}
<div class="d-flex justify-content-end gap-2 mb-5">
    <a href="{{ route('suratkeluar.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Simpan Surat Keluar
    </button>
</div>

</form>

{{-- ===================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ===================================================== --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function ambilNomorRegistrasi() {
    let id = $('#kode_arsip_id').val();
    
    if(!id) {
        $('#nomor_registrasi').val('');
        $('#nomor_registrasi_hidden').val('');
        return;
    }

    let fetchUrl = "{{ url('/suratkeluar/get-nomor-registrasi') }}/" + id;

    $.ajax({
        url: fetchUrl,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if(data && data.nomor_registrasi) {
                $('#nomor_registrasi').val(data.nomor_registrasi);
                $('#nomor_registrasi_hidden').val(data.nomor_registrasi);
            } else {
                $('#nomor_registrasi').val('Gagal memuat nomor');
            }
        },
        error: function(xhr, status, error) {
            console.error("Fetch Error:", error);
            $('#nomor_registrasi').val('Gagal mengambil data');
        }
    });
}

function previewDokumen(e){
    let file = e.target.files[0];
    if(!file) return;

    $('#namaFile').text(file.name);
    $('#fileInfo').removeClass('d-none');
    $('#previewEmpty').hide();

    let url = URL.createObjectURL(file);

    if(file.type === "application/pdf"){
        $('#previewPDF').show().attr('src', url);
        $('#previewIMG').hide();
    } else {
        $('#previewIMG').show().attr('src', url);
        $('#previewPDF').hide();
    }
}

$(document).ready(function() {
    if($('#kode_arsip_id').val()){
        ambilNomorRegistrasi();
    }

    $('#kode_arsip_id').on('change', function() {
        ambilNomorRegistrasi();
    });

    $('#btnUploadArea').on('click', function() {
        $('#file_surat').click();
    });

    $('#file_surat').on('change', previewDokumen);

    $("#formRegistrasiSuratKeluar").on("submit", function(){
        if(this.checkValidity()) {
            Swal.fire({
                title: "Menyimpan Surat Keluar",
                text: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    });
});
</script>
@endsection