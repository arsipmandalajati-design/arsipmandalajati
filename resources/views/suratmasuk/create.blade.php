@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Registrasi Surat Masuk
@endsection

@section('page-description')
Registrasikan surat fisik maupun dokumen digital yang diterima Kecamatan sebagai arsip digital untuk diproses lebih lanjut.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.form-card{
    border:none;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.form-control,
.form-select{
    border-radius:12px;
    min-height:48px;
}

.form-control:focus,
.form-select:focus{
    border-color:#4f46e5;
    box-shadow:none;
}

.section-title{
    font-size:16px;
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
    color:#fff;
}

.btn-save:hover{
    background:#4338ca;
    color:#fff;
}

.btn-back{
    border-radius:12px;
    padding:10px 25px;
}

.card-header{
    font-weight:600;
}

.required{
    color:red;
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

<div class="card form-card">
    <div class="card-body p-4">
        <form id="formRegistrasiSurat" action="{{ route('suratmasuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ========================================= --}}
            {{-- INFORMASI ARSIP --}}
            {{-- ========================================= --}}
            <div class="section-title">Informasi Arsip</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kode Arsip <span class="required">*</span></label>
                    <select name="kode_arsip_id" id="kode_arsip_id" class="form-select" required>
                        <option value="">-- Pilih Kode Arsip --</option>
                        @foreach($kodearsip as $item)
                            <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" {{ old('kode_arsip_id')==$item->id ? 'selected' : '' }}>
                                {{ $item->kode }} - {{ $item->nama_kode }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih klasifikasi arsip.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nomor Registrasi</label>
                    <input type="text" id="nomor_registrasi" class="form-control bg-light" readonly>
                    <input type="hidden" name="nomor_registrasi" id="nomor_registrasi_hidden">
                    <small class="text-muted">Nomor registrasi dibuat otomatis.</small>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- INFORMASI SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-4">Informasi Surat</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jenis Surat <span class="required">*</span></label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        <option value="Internal" {{ old('jenis_surat')=='Internal' ? 'selected' : '' }}>Internal Kecamatan</option>
                        <option value="Eksternal" {{ old('jenis_surat')=='Eksternal' ? 'selected' : '' }}>Eksternal</option>
                    </select>
                    <small class="text-muted">Internal = kegiatan Kecamatan.<br>Eksternal = surat dari luar instansi.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Sumber Arsip <span class="required">*</span></label>
                    <select name="sumber_arsip" class="form-select" required>
                        <option value="Dokumen Digital" {{ old('sumber_arsip')=='Dokumen Digital' ? 'selected' : '' }}>Dokumen Digital</option>
                        <option value="Hasil Scan Dokumen Fisik" {{ old('sumber_arsip')=='Hasil Scan Dokumen Fisik' ? 'selected' : '' }}>Hasil Scan Dokumen Fisik</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nomor Surat <span class="required">*</span></label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="{{ old('nomor_surat') }}" placeholder="Masukkan nomor surat" required>
                    <small class="text-muted">Isi sesuai nomor surat yang diterima.</small>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- DETAIL SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-4">Detail Surat</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Judul Surat <span class="required">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul surat" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Asal Surat / Instansi <span class="required">*</span></label>
                    <input type="text" name="pengirim" class="form-control" value="{{ old('pengirim') }}" placeholder="Contoh : Kecamatan Mandalajati" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Surat <span class="required">*</span></label>
                    <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat') }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Perihal <span class="required">*</span></label>
                    <textarea name="perihal" rows="4" class="form-control" placeholder="Masukkan perihal surat" required>{{ old('perihal') }}</textarea>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- DOKUMEN SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-4">Dokumen Surat</div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-semibold"><i class="bi bi-file-earmark-arrow-up me-1"></i>Upload File Surat <span class="required">*</span></label>
                    <input type="file" name="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted">Format PDF, JPG, JPEG, PNG. Maksimal 2 MB.</small>
                </div>
            </div>

            <hr class="my-4">

            {{-- ========================================= --}}
            {{-- BOOKING KEGIATAN --}}
            {{-- ========================================= --}}
            <div id="bookingCard" class="card border-0 shadow-sm mb-4" style="display:none; border-radius:15px; overflow:hidden;">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-calendar-event me-2"></i>Booking Tempat Kegiatan
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        Booking hanya digunakan apabila surat merupakan kegiatan internal yang membutuhkan ruangan.
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Tempat</label>
                            <select id="tempat" name="tempat" class="form-select">
                                <option value="">-- Pilih Tempat --</option>
                                <option value="Aula Kecamatan">Aula Kecamatan</option>
                                <option value="Ruang Camat">Ruang Camat</option>
                                <option value="Ruang Sekretaris">Ruang Sekretaris</option>
                                <option value="Ruang Rapat">Ruang Rapat</option>
                                <option value="Halaman Kecamatan">Halaman Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Kegiatan</label>
                            <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control" value="{{ old('tanggal_kegiatan') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
                        </div>

                        <div class="col-md-12">
                            <div id="bookingAlert" class="alert alert-danger d-none">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>Ruangan sudah dibooking pada jadwal tersebut.
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Materi Kegiatan</label>
                            <input type="text" name="materi" class="form-control" value="{{ old('materi') }}" placeholder="Contoh : Rapat Evaluasi Bulanan">
                        </div>
                    </div>

                    <hr>
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-box-seam me-2"></i>Kebutuhan Kegiatan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" class="form-control" value="{{ old('jumlah_peserta',0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Kursi</label>
                            <input type="number" name="kursi" class="form-control" value="{{ old('kursi',0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Meja</label>
                            <input type="number" name="meja" class="form-control" value="{{ old('meja',0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Proyektor</label>
                            <input type="number" name="proyektor" class="form-control" value="{{ old('proyektor',0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold">Mic</label>
                            <input type="number" name="mic" class="form-control" value="{{ old('mic',0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sound System</label>
                            <input type="number" name="sound_system" class="form-control" value="{{ old('sound_system',0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Kabel Roll</label>
                            <input type="number" name="kabel_roll" class="form-control" value="{{ old('kabel_roll',0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Lainnya</label>
                            <input type="text" name="lainnya" class="form-control" value="{{ old('lainnya') }}" placeholder="Contoh : Whiteboard, Flipchart">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- BUTTON --}}
            {{-- ========================================= --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('suratmasuk.index') }}" class="btn btn-secondary btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" id="btnSimpan" class="btn btn-save">
                    <i class="bi bi-save"></i> Simpan Surat
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const jenisSurat = document.getElementById("jenis_surat");
    const kodeArsip = document.getElementById("kode_arsip_id");
    const form = document.getElementById("formRegistrasiSurat");

    // tampilkan / sembunyikan booking
    toggleBooking();

    // kalau edit / old value
    if(kodeArsip.value !== ""){
        ambilNomorRegistrasi();
    }

    jenisSurat.addEventListener("change", toggleBooking);
    kodeArsip.addEventListener("change", ambilNomorRegistrasi);

    // ======================================
    // SUBMIT FORM DENGAN VALIDASI & SWAL SAFE
    // ======================================
    form.addEventListener("submit", function(e){
        // Biarkan HTML5 memeriksa required input terlebih dahulu
        if(!form.checkValidity()){
            return; 
        }

        // Jalankan SweetAlert loading jika form valid
        document.getElementById("btnSimpan").disabled = true;

        Swal.fire({
            title: "Menyimpan Surat...",
            text: "Mohon tunggu sebentar",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
});

// ======================================
// BOOKING CARD
// ======================================
function toggleBooking(){
    let booking = document.getElementById("bookingCard");
    if(!booking) return;

    if(document.getElementById("jenis_surat").value === "Internal"){
        booking.style.display = "block";
    } else {
        booking.style.display = "none";
        // Reset input fields booking ketika disembunyikan agar required/input tak sengaja tidak terkirim
        $("#bookingCard find('input, select')").val('');
    }
}

// ======================================
// NOMOR REGISTRASI
// ======================================
function ambilNomorRegistrasi(){
    let id = document.getElementById("kode_arsip_id").value;

    if(id === ""){
        document.getElementById("nomor_registrasi").value = "";
        document.getElementById("nomor_registrasi_hidden").value = "";
        return;
    }

    fetch("/kodearsip/" + id + "/nomor-registrasi")
    .then(function(response){
        if(!response.ok){
            throw new Error("Route gagal");
        }
        return response.json();
    })
    .then(function(data){
        document.getElementById("nomor_registrasi").value = data.nomor_registrasi;
        document.getElementById("nomor_registrasi_hidden").value = data.nomor_registrasi;
    })
    .catch(function(error){
        console.error(error);
    });
}

// ======================================
// CEK BOOKING (AJAX JQUERY)
// ======================================
$("#tempat, #tanggal_kegiatan, #jam_mulai, #jam_selesai").on("change", function(){
    let tempat = $("#tempat").val();
    let tanggal = $("#tanggal_kegiatan").val();
    let mulai = $("#jam_mulai").val();
    let selesai = $("#jam_selesai").val();

    if(tempat === "" || tanggal === "" || mulai === "" || selesai === ""){
        return;
    }

    $.ajax({
        url: "{{ route('agenda.cekBooking') }}",
        type: "GET",
        data: {
            tempat: tempat,
            tanggal: tanggal,
            jam_mulai: mulai,
            jam_selesai: selesai
        },
        success: function(res){
            if(res.bentrok){
                $("#bookingAlert").removeClass("d-none");
            } else {
                $("#bookingAlert").addClass("d-none");
            }
        },
        error: function(){
            console.log("Gagal cek booking");
        }
    });
});
</script>

@endsection