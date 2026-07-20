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
.form-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
}

.form-control,
.form-select {
    border-radius: 12px;
    min-height: 46px;
}

.form-control:focus,
.form-select:focus {
    border-color: #4f46e5;
    box-shadow: none;
}

.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #4f46e5;
    border-left: 4px solid #4f46e5;
    padding-left: 10px;
    margin-bottom: 20px;
}

.booking-title {
    font-size: 16px;
    font-weight: 700;
    color: #0d9488;
    border-left: 4px solid #0d9488;
    padding-left: 10px;
    margin-bottom: 20px;
}

.btn-save {
    background: #4f46e5;
    border: none;
    border-radius: 12px;
    padding: 10px 25px;
    color: #fff;
    font-weight: 600;
}

.btn-save:hover {
    background: #4338ca;
    color: #fff;
}

.btn-back {
    border-radius: 12px;
    padding: 10px 25px;
    font-weight: 600;
}

.required {
    color: red;
}
</style>

@if ($errors->any())
<div class="alert alert-danger rounded-4 shadow-sm border-0 mb-4 animate__animated animate__fadeIn">
    <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i> Periksa kembali inputan Anda:</div>
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card form-card">
    <div class="card-body p-4">
        <form id="formRegistrasiSurat" action="{{ route('suratmasuk.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- ========================================= --}}
            {{-- INFORMASI ARSIP --}}
            {{-- ========================================= --}}
            <div class="section-title">Informasi Arsip</div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="kode_arsip_id" class="form-label fw-semibold text-secondary">Kode Arsip <span class="required">*</span></label>
                    <select class="form-select" id="kode_arsip_id" name="kode_arsip_id" required>
                        <option value="">-- Pilih Kode Arsip --</option>
                        @foreach($kodearsip as $item)
    <option value="{{ $item->id }}" {{ old('kode_arsip_id') == $item->id ? 'selected' : '' }}>
        {{ $item->kode }} - {{ $item->nama_arsip }}
    </option>
@endforeach
                    </select>
                    <div class="invalid-feedback">Kode arsip wajib dipilih.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_registrasi" class="form-label fw-semibold text-secondary">Nomor Registrasi</label>
                    <input type="text" class="form-control" id="nomor_registrasi" name="nomor_registrasi" readonly placeholder="Otomatis terisi setelah memilih Kode Arsip">
                    <small class="text-muted">Nomor ini di-generate otomatis oleh sistem berdasarkan nomor urut terbesar.</small>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- INFORMASI SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-2">Informasi Surat</div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="jenis_surat" class="form-label fw-semibold text-secondary">Jenis Surat <span class="required">*</span></label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        <option value="Internal" {{ old('jenis_surat') == 'Internal' ? 'selected' : '' }}>Internal Kecamatan</option>
                        <option value="Eksternal" {{ old('jenis_surat') == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                    </select>
                    <div class="invalid-feedback">Jenis surat wajib ditentukan.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sumber_arsip" class="form-label fw-semibold text-secondary">Sumber Arsip <span class="required">*</span></label>
                    <select name="sumber_arsip" id="sumber_arsip" class="form-select" required>
                        <option value="Dokumen Digital" {{ old('sumber_arsip') == 'Dokumen Digital' ? 'selected' : '' }}>Dokumen Digital</option>
                        <option value="Hasil Scan Dokumen Fisik" {{ old('sumber_arsip') == 'Hasil Scan Dokumen Fisik' ? 'selected' : '' }}>Hasil Scan Dokumen Fisik</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="nomor_surat" class="form-label fw-semibold text-secondary">Nomor Surat Fisik / Instansi <span class="required">*</span></label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="{{ old('nomor_surat') }}" placeholder="Contoh: 045.2/123-Kec" required>
                    <div class="invalid-feedback">Nomor surat fisik wajib diisi.</div>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- DETAIL SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-2">Detail Surat</div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="judul" class="form-label fw-semibold text-secondary">Judul Surat <span class="required">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul ringkas surat" required>
                    <div class="invalid-feedback">Judul surat wajib diisi.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pengirim" class="form-label fw-semibold text-secondary">Asal Surat / Instansi Pengirim <span class="required">*</span></label>
                    <input type="text" name="pengirim" id="pengirim" class="form-control" value="{{ old('pengirim') }}" placeholder="Contoh: Dinas Kesehatan Kota Bandung" required>
                    <div class="invalid-feedback">Asal instansi pengirim wajib diisi.</div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="tanggal_surat" class="form-label fw-semibold text-secondary">Tanggal Surat <span class="required">*</span></label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" value="{{ old('tanggal_surat') }}" required>
                    <div class="invalid-feedback">Tanggal pada surat fisik wajib dipilih.</div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="perihal" class="form-label fw-semibold text-secondary">Perihal / Ringkasan Isi <span class="required">*</span></label>
                    <textarea name="perihal" id="perihal" rows="3" class="form-control" placeholder="Tuliskan perihal utama surat..." required>{{ old('perihal') }}</textarea>
                    <div class="invalid-feedback">Perihal singkat wajib diisi.</div>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- DOKUMEN SURAT --}}
            {{-- ========================================= --}}
            <div class="section-title mt-2">Dokumen Surat</div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="file_surat" class="form-label fw-semibold text-secondary"><i class="bi bi-file-earmark-arrow-up-fill me-1 text-primary"></i>Upload File Surat <span class="required">*</span></label>
                    <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted d-block mt-1">Format dokumen yang diizinkan: PDF, JPG, JPEG, PNG. Ukuran berkas maksimal 2 MB.</small>
                    <div class="invalid-feedback">Harap unggah salinan berkas surat yang valid.</div>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- DYNAMIC CARD: INTEGRASI BOOKING TEMPAT --}}
            {{-- ========================================= --}}
            <div id="bookingCard" class="card border border-teal-subtle bg-light bg-opacity-25 shadow-sm mb-4 rounded-4 overflow-hidden animate__animated animate__fadeIn" style="display:none;">
                <div class="card-body p-4">
                    <div class="booking-title">Booking Tempat & Fasilitas Kegiatan</div>
                    <div class="alert alert-info border-0 rounded-3 shadow-sm d-flex align-items-center mb-4">
                        <i class="bi bi-info-circle-fill fs-5 me-3 text-info"></i>
                        <div>Formulir ini terbuka karena jenis surat berupa <strong>Internal</strong>. Digunakan apabila kegiatan internal Kecamatan membutuhkan reservasi ruangan.</div>
                    </div>
                    
                    <div id="bookingAlertContainer" class="mb-3"></div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tempat" class="form-label fw-semibold text-secondary">Fasilitas / Ruangan Kecamatan</label>
                            <select id="tempat" name="tempat" class="form-select">
                                <option value="">-- Pilih Ruangan --</option>
                                <option value="Aula Kecamatan" {{ old('tempat') == 'Aula Kecamatan' ? 'selected' : '' }}>Aula Utama Kecamatan</option>
                                <option value="Ruang Camat" {{ old('tempat') == 'Ruang Camat' ? 'selected' : '' }}>Ruang Camat</option>
                                <option value="Ruang Sekretaris" {{ old('tempat') == 'Ruang Sekretaris' ? 'selected' : '' }}>Ruang Sekretaris</option>
                                <option value="Ruang Rapat" {{ old('tempat') == 'Ruang Rapat' ? 'selected' : '' }}>Ruang Rapat VIP</option>
                                <option value="Halaman Kecamatan" {{ old('tempat') == 'Halaman Kecamatan' ? 'selected' : '' }}>Halaman / Alun-alun Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kegiatan" class="form-label fw-semibold text-secondary">Tanggal Kegiatan</label>
                            <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control" value="{{ old('tanggal_kegiatan') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="jam_mulai" class="form-label fw-semibold text-secondary">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="jam_selesai" class="form-label fw-semibold text-secondary">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="materi" class="form-label fw-semibold text-secondary">Materi / Subjek Kegiatan</label>
                            <input type="text" name="materi" id="materi" class="form-control" value="{{ old('materi') }}" placeholder="Contoh: Rapat Koordinasi Evaluasi Triwulan">
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-box-seam-fill me-2" style="color:#0d9488;"></i>
                        <h6 class="fw-bold m-0" style="color:#0d9488;">Kebutuhan Logistik Kegiatan</h6>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="jumlah_peserta" class="form-label text-secondary fs-7">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control" value="{{ old('jumlah_peserta', 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="kursi" class="form-label text-secondary fs-7">Fasilitas Kursi</label>
                            <input type="number" name="kursi" id="kursi" class="form-control" value="{{ old('kursi', 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="meja" class="form-label text-secondary fs-7">Fasilitas Meja</label>
                            <input type="number" name="meja" id="meja" class="form-control" value="{{ old('meja', 0) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label for="proyektor" class="form-label text-secondary fs-7">Proyektor (Unit)</label>
                            <input type="number" name="proyektor" id="proyektor" class="form-control" value="{{ old('proyektor', 0) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label for="mic" class="form-label text-secondary fs-7">Microphone (Unit)</label>
                            <input type="number" name="mic" id="mic" class="form-control" value="{{ old('mic', 0) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label for="sound_system" class="form-label text-secondary fs-7">Wireless Sound System</label>
                            <input type="number" name="sound_system" id="sound_system" class="form-control" value="{{ old('sound_system', 0) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label for="kabel_roll" class="form-label text-secondary fs-7">Kabel Roll Extension</label>
                            <input type="number" name="kabel_roll" id="kabel_roll" class="form-control" value="{{ old('kabel_roll', 0) }}" min="0">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="lainnya" class="form-label text-secondary fs-7">Kebutuhan Lainnya</label>
                            <input type="text" name="lainnya" id="lainnya" class="form-control" value="{{ old('lainnya') }}" placeholder="Contoh: Papan Tulis Putih, Flipchart, air mineral">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-4">
                <a href="{{ route('suratmasuk.index') }}" class="btn btn-light btn-back text-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" id="btnSimpan" class="btn btn-save">
                    <i class="bi bi-save me-1"></i> Simpan Surat
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================= --}}
{{-- JAVASCRIPT LOGIC OLEH JQUERY --}}
{{-- ========================================= --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const jenisSurat = document.getElementById("jenis_surat");
    const kodeArsip = document.getElementById("kode_arsip_id");
    const form = document.getElementById("formRegistrasiSurat");
    const btnSimpan = document.getElementById("btnSimpan");

    // Inisialisasi awal saat halaman selesai dimuat
    toggleBooking();
    if (kodeArsip.value !== "") {
        ambilNomorRegistrasi();
    }

    jenisSurat.addEventListener("change", toggleBooking);
    kodeArsip.addEventListener("change", ambilNomorRegistrasi);

    // 1. HANDLER SUBMIT FORM & VALIDASI BOOTSTRAP 5 (FIXED LOGIC)
    form.addEventListener("submit", function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            
            // Jaga agar button tetap aktif jika gagal validasi HTML5
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Surat';
            return; 
        }

        // Pindahkan perubahan status ke SINI (Hanya jika form valid)
        btnSimpan.disabled = true;
        btnSimpan.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

        Swal.fire({
            title: "Menyimpan Data Surat...",
            text: "Mohon tunggu sebentar, file sedang diunggah ke server",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // 2. TOGGLE BOOKING CARD (ON/OFF MANDATORY ATTRIBUTES)
    function toggleBooking() {
        let booking = document.getElementById("bookingCard");
        if (!booking) return;

        if (jenisSurat.value === "Internal") {
            booking.style.display = "block";
            document.getElementById("tempat").setAttribute("required", "true");
            document.getElementById("tanggal_kegiatan").setAttribute("required", "true");
            document.getElementById("jam_mulai").setAttribute("required", "true");
            document.getElementById("jam_selesai").setAttribute("required", "true");
        } else {
            booking.style.display = "none";
            document.getElementById("tempat").removeAttribute("required");
            document.getElementById("tanggal_kegiatan").removeAttribute("required");
            document.getElementById("jam_mulai").removeAttribute("required");
            document.getElementById("jam_selesai").removeAttribute("required");
            
            // Reset input booking saat disembunyikan
            $("#bookingCard").find('input[type="text"], input[type="date"], input[type="time"], select').val('');
            $("#bookingCard").find('input[type="number"]').val(0);
            $("#bookingAlertContainer").html('');
            btnSimpan.disabled = false;
        }
    }

    // 3. FETCH NOMOR REGISTRASI (MENGGUNAKAN NATIVE FETCH)
    function ambilNomorRegistrasi() {
        let id = kodeArsip.value;

        if (id === "") {
            document.getElementById("nomor_registrasi").value = "";
            return;
        }

        fetch("/suratmasuk/get-nomor-registrasi/" + id)
        .then(function(response) {
            if (!response.ok) {
                throw new Error("Route gagal diakses");
            }
            return response.json();
        })
        .then(function(data) {
            document.getElementById("nomor_registrasi").value = data.nomor_registrasi;
        })
        .catch(function(error) {
            console.error("Gagal mengambil nomor registrasi:", error);
        });
    }

    // 4. CEK BENTROK JADWAL RUANGAN via AJAX
    $("#tempat, #tanggal_kegiatan, #jam_mulai, #jam_selesai").on("change", function() {
        let tempat = $("#tempat").val();
        let tanggal = $("#tanggal_kegiatan").val();
        let mulai = $("#jam_mulai").val();
        let selesai = $("#jam_selesai").val();
        let alertContainer = $("#bookingAlertContainer");

        if (tempat === "" || tanggal === "" || mulai === "" || selesai === "") {
            return;
        }

        if (selesai <= mulai) {
            alertContainer.html(`
                <div class="alert alert-warning rounded-3 py-2 border-0 shadow-sm animate__animated animate__shakeX">
                    <i class="bi bi-clock-fill me-2"></i>
                    <strong>Format Waktu Salah!</strong> Jam Selesai harus lebih lambat daripada Jam Mulai.
                </div>`);
            btnSimpan.disabled = true;
            return;
        }

        alertContainer.html('<div class="alert alert-info py-2 rounded-3 border-0"><span class="spinner-border spinner-border-sm me-2"></span>Memeriksa agenda ruangan...</div>');

        $.ajax({
            url: "{{ route('agenda.cekBooking') }}",
            type: "GET",
            data: {
                tempat: tempat,
                tanggal: tanggal,
                jam_mulai: mulai,
                jam_selesai: selesai
            },
            success: function(res) {
                if (res.bentrok) {
                    alertContainer.html(`
                        <div class="alert alert-danger rounded-3 py-2 border-0 shadow-sm animate__animated animate__shakeX">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Peringatan Jadwal Bentrok!</strong> Ruangan tersebut sudah dipesan di tanggal dan jam yang sama.
                        </div>`);
                    btnSimpan.disabled = true;
                } else {
                    alertContainer.html(`
                        <div class="alert alert-success rounded-3 py-2 border-0 shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> Ruangan tersedia dan siap digunakan!
                        </div>`);
                    btnSimpan.disabled = false;
                }
            },
            error: function() {
                console.error("Gagal melakukan verifikasi ketersediaan jadwal.");
                alertContainer.html(`
                    <div class="alert alert-warning rounded-3 py-2 border-0 shadow-sm">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> Gagal memverifikasi jadwal. Silakan coba lagi.
                    </div>`);
                btnSimpan.disabled = false;
            }
        });
    });
});
</script>
@endsection