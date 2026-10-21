@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Registrasi Surat Masuk
@endsection

@section('page-description')
Registrasikan surat masuk sebagai arsip digital Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
/*==================================
CARD & LAYOUT FIX
==================================*/
.form-card{
    border: none;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,.06);
    width: 100%;
}

.card-header-custom{
    background: #fff;
    color: #1d4ed8;
    font-size: 18px;
    font-weight: 700;
    padding: 18px 25px;
    border-bottom: 1px solid #eef2f7;
}

.card-body{
    padding: 28px;
    overflow: visible;
}

.row {
    margin-left: -12px;
    margin-right: -12px;
}

.row > [class*="col-"] {
    padding-left: 12px;
    padding-right: 12px;
}

/*==================================
FORM
==================================*/
.form-label{
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.required{
    color: #ef4444;
}

.form-control,
.form-select{
    height: 48px;
    border-radius: 12px;
    border: 1px solid #dbe3ef;
    width: 100%;
}

textarea.form-control{
    height: auto;
    min-height: 110px;
}

.form-control:focus,
.form-select:focus{
    border-color: #2563eb;
    box-shadow: 0 0 0 .15rem rgba(37,99,235,.15);
}

.readonly-box{
    background: #eef5ff;
    font-weight: 600;
}

.text-helper{
    font-size: 13px;
    color: #6b7280;
    margin-top: 6px;
}

/*==================================
UPLOAD
==================================*/
.upload-area{
    border: 2px dashed #3b82f6;
    border-radius: 18px;
    background: #f8fbff;
    padding: 40px 25px;
    text-align: center;
    cursor: pointer;
    transition: .3s;
}

.upload-area:hover{
    background: #eef6ff;
    border-color: #2563eb;
}

.upload-area i{
    font-size: 55px;
}

/*==================================
BUTTON
==================================*/
.btn-primary{
    background: #2563eb;
    border: none;
    border-radius: 12px;
    padding: 12px 35px;
}

.btn-primary:hover{
    background: #1d4ed8;
}

.btn-outline-secondary{
    border-radius: 12px;
    padding: 12px 30px;
}

@media(max-width:991px){
    .card-body{
        padding: 20px;
    }
}
</style>

@if ($errors->any())
<div class="alert alert-danger rounded-4">
    <strong>
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Periksa kembali inputan Anda
    </strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formRegistrasiSurat" action="{{ route('suratmasuk.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- ===================================================== --}}
{{-- INFORMASI ARSIP --}}
{{-- ===================================================== --}}
<div class="card form-card">
    <div class="card-header-custom">
        <i class="bi bi-folder2-open me-2"></i>
        Informasi Arsip
    </div>
    <div class="card-body">
        <div class="row g-4">
            {{-- KODE ARSIP --}}
            <div class="col-lg-6">
                <label class="form-label">
                    Kode Arsip <span class="required">*</span>
                </label>
                <select name="kode_arsip_id" id="kode_arsip_id" class="form-control select2">
                    <option value="" disabled selected>-- Pilih Kode Arsip --</option>
                    @foreach($kodearsip as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->kode }} - {{ $item->nama_arsip }}
                        </option>
                    @endforeach
                </select>
                <small class="text-helper">Pilih klasifikasi arsip sesuai jenis surat.</small>
            </div>

            {{-- NOMOR REGISTRASI --}}
            <div class="col-lg-6">
                <label class="form-label">Nomor Registrasi</label>
                <input type="text" id="nomor_registrasi" class="form-control readonly-box" readonly placeholder="Otomatis terisi...">
                <input type="hidden" name="nomor_registrasi" id="nomor_registrasi_hidden">
                <small class="text-helper">Dibuat otomatis berdasarkan kode arsip.</small>
            </div>

            {{-- JENIS SURAT --}}
            <div class="col-lg-12">
                <!-- 1. Jenis Surat -->
                <div class="form-group mb-3">
                    <label for="jenis_surat" class="fw-bold form-label">Jenis Surat <span class="required">*</span></label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                        <option value="Eksternal" {{ old('jenis_surat') == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                        <option value="Internal" {{ old('jenis_surat') == 'Internal' ? 'selected' : '' }}>Internal</option>
                    </select>
                </div>

                <!-- 2. Dropdown Pengirim Khusus Internal -->
                <div class="form-group mb-3 d-none" id="wrapper_pengirim_internal">
                    <label for="pengirim_internal_select" class="fw-bold form-label">Pilih Pengirim <span class="required">*</span></label>
                    <select id="pengirim_internal_select" class="form-select">
                        <option value="">-- Pilih Seksi / Kasi --</option>
                        <option value="Sekcam" data-kode="Sekcam">Sekretaris Camat</option>
                        <option value="Subbag.Umum" data-kode="Subbag.Umum">Subbag Umum & Kepegawaian</option>
                        <option value="Trantib" data-kode="Trantib">Kasi Trantib (Ketenteraman & Ketertiban)</option>
                        <option value="Pemdes" data-kode="Pemdes">Kasi Pemdes (Pemerintahan Desa)</option>
                        <option value="Pemas" data-kode="Pemas">Kasi PMD / Pemas (Pemberdayaan Masyarakat)</option>
                        <option value="Kesos" data-kode="Kesos">Kasi Kesos (Kesejahteraan Sosial)</option>
                        <option value="TP - PKK" data-kode="TP - PKK">TP - PKK </option>
                        <option value="Puskesmas" data-kode="Puskesmas">Puskesmas</option>
                        <option value="Kelurahan" data-kode="Pasim">Kelurahan Pasir Impun</option>
                        <option value="Kelurahan" data-kode="Karpam">Kelurahan Karang Pamulang</option>
                        <option value="Kelurahan" data-kode="Sdjy">Kelurahan SindangJaya</option>
                        <option value="Kelurahan" data-kode="Jthndp">Kelurahan JatiHandap</option>
                    </select>
                </div>

                <!-- 3. Pengirim Manual (Tampil jika Eksternal) -->
                <div class="form-group mb-3" id="wrapper_pengirim_manual">
                    <label for="pengirim_manual" class="fw-bold form-label">Pengirim / Instansi Asal <span class="required">*</span></label>
                    <input type="text" id="pengirim_manual" class="form-control" placeholder="Contoh: Dinas Pendidikan / PT. ABC" value="{{ old('pengirim') }}">
                </div>

                <!-- Hidden Input untuk menampung nilai final Pengirim yang dikirim ke Controller -->
                <input type="hidden" name="pengirim" id="pengirim_final" value="{{ old('pengirim') }}">

                <!-- 4. Input Nomor Surat dengan Prefix/Suffix Otomatis -->
                <div class="form-group mb-3">
                    <label for="nomor_surat_input" class="fw-bold form-label">Nomor Surat Asal <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="text" id="nomor_surat_input" class="form-control fw-bold" placeholder="Contoh: 012" required>
                        <span class="input-group-text bg-light d-none" id="suffix_kode_unit">/Sekr/{{ date('Y') }}</span>
                    </div>
                    
                    <!-- KOTAK INFORMASI REKOMENDASI NOMOR TERAKHIR (DARI AJAX) -->
                    <div class="alert alert-info d-none mt-2 mb-1 py-2 px-3" id="info_nomor_terakhir" style="font-size: 0.9rem;"></div>

                    <small class="text-muted" id="help_nomor_surat">Masukkan nomor surat sesuai dokumen asal.</small>
                </div>

                <!-- Hidden Input untuk menampung Nomor Surat Final yang dikirim ke Controller -->
                <input type="hidden" name="nomor_surat" id="nomor_surat_final" value="{{ old('nomor_surat') }}">

            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- INFORMASI SURAT --}}
{{-- ===================================================== --}}
<div class="card form-card">
    <div class="card-header-custom">
        <i class="bi bi-file-earmark-text me-2"></i>
        Informasi Surat
    </div>
    <div class="card-body">
        <div class="row g-4">
            {{-- JUDUL SURAT --}}
            <div class="col-lg-12">
                <label class="form-label">
                    Judul Surat <span class="required">*</span>
                </label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh : Undangan Rapat Evaluasi Semester" value="{{ old('judul') }}" required>
                <small class="text-helper">Isi dengan judul atau nama surat.</small>
            </div>

            {{-- TANGGAL SURAT --}}
            <div class="col-lg-4">
                <label class="form-label">
                    Tanggal Surat <span class="required">*</span>
                </label>
                <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat') }}" required>
            </div>

            {{-- TANGGAL DITERIMA --}}
            <div class="col-lg-4">
                <label class="form-label">
                    Tanggal Diterima <span class="required">*</span>
                </label>
                <input type="date" name="tanggal_diterima" class="form-control" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required>
            </div>

            {{-- TANGGAL KADALUARSA (OPSIONAL) --}}
            <div class="col-lg-4">
                <label class="form-label">Tanggal Kadaluarsa <small class="text-muted">(Opsional)</small></label>
                <input type="date" name="tanggal_kadaluarsa" class="form-control" value="{{ old('tanggal_kadaluarsa') }}">
                <small class="text-helper">Isi jika surat memiliki batas berlaku.</small>
            </div>

            {{-- PERIHAL --}}
            <div class="col-lg-12">
                <label class="form-label">
                    Perihal Surat <span class="required">*</span>
                </label>
                <textarea name="perihal" rows="4" class="form-control" placeholder="Tuliskan isi singkat atau perihal surat..." required>{{ old('perihal') }}</textarea>
                <small class="text-helper">Jelaskan maksud atau isi pokok surat secara singkat.</small>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- DOKUMEN SURAT --}}
{{-- ===================================================== --}}
<div class="card form-card">
    <div class="card-header-custom">
        <i class="bi bi-cloud-arrow-up me-2"></i>
        Dokumen Surat
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-5">
                <label class="form-label">
                    Upload Dokumen <span class="required">*</span>
                </label>
                <div class="upload-area" id="btnUploadArea">
                    <i class="bi bi-cloud-arrow-up text-primary"></i>
                    <h5 class="mt-3 fw-bold">Pilih File Surat</h5>
                    <p class="text-muted mb-1">PDF, JPG, JPEG, PNG</p>
                    <small class="text-muted">Maksimal ukuran 2 MB</small>
                </div>
                <input type="file" id="file_surat" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" hidden required>
                <div id="fileInfo" class="alert alert-success mt-4 d-none">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span id="namaFile"></span>
                </div>
            </div>

            <div class="col-lg-7">
                <label class="form-label">Preview Dokumen</label>
                <div id="previewArea" class="border rounded-4 bg-light d-flex align-items-center justify-content-center overflow-hidden shadow-sm" style="height:430px;">
                    <div id="previewEmpty" class="text-center">
                        <i class="bi bi-file-earmark-pdf display-1 text-secondary"></i>
                        <h5 class="mt-3 text-secondary">Belum ada dokumen</h5>
                        <p class="text-muted">Preview akan muncul setelah file dipilih.</p>
                    </div>
                    <iframe id="previewPDF" style="display:none;width:100%;height:100%;border:none;"></iframe>
                    <img id="previewIMG" style="display:none;width:100%;height:100%;object-fit:contain;">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- BOOKING TEMPAT KEGIATAN --}}
{{-- ===================================================== --}}
<div id="bookingCard" class="card form-card" style="display:none;">
    <div class="card-header-custom">
        <i class="bi bi-calendar-event me-2"></i>
        Booking Tempat Kegiatan
    </div>
    <div class="card-body">
        <div class="alert alert-primary rounded-4 border-0">
            <i class="bi bi-info-circle-fill me-2"></i>
            Booking ruangan hanya digunakan untuk <strong>Surat Internal Kecamatan</strong>. Silakan pilih ruangan, tanggal, dan jam kegiatan.
        </div>
        <div class="row g-4">
            {{-- DROPDOWN PILIH TEMPAT (DINAMIS DARI DATABASE) --}}
            <div class="col-lg-6">
                <label class="form-label">Tempat Kegiatan</label>
                <select name="tempat" id="tempat" class="form-select @error('tempat') is-invalid @enderror">
                    <option value="">-- Pilih Tempat --</option>
                    
                    {{-- Loop data ruangan dari database --}}
                    @foreach($daftar_ruangan as $r)
                        @if($r->status == 'renovasi')
                            <option value="{{ $r->nama_ruangan }}" disabled class="text-muted bg-light">
                                {{ $r->nama_ruangan }} (Sedang Renovasi 🛠️)
                            </option>
                        @else
                            <option value="{{ $r->nama_ruangan }}" {{ old('tempat') == $r->nama_ruangan ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
                        @endif
                    @endforeach
                </select>

                @error('tempat')
                    <div class="invalid-feedback d-block fw-bold text-danger mt-1">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- FIELD TAMBAH RUANGAN BARU & CHECKBOX RENOVASI DI BAWAHNYA --}}
            <div class="col-lg-6">
                <label class="form-label">Tambah Ruangan Baru (Ketik Manual)</label>
                <div class="input-group mb-2">
                    <input type="text" id="input_ruangan_baru" class="form-control" placeholder="Ketik nama ruangan baru...">
                    <button class="btn btn-outline-primary" type="button" id="btn_simpan_ruangan">
                        <i class="bi bi-plus-circle me-1"></i> Simpan
                    </button>
                </div>
                
                {{-- Checkbox Status Renovasi di bawah kotak input --}}
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkbox_renovasi" value="renovasi">
                    <label class="form-check-label text-danger fw-semibold small" for="checkbox_renovasi">
                        <i class="bi bi-tools me-1"></i> Tandai sebagai Sedang Renovasi (Tidak bisa langsung dipesan)
                    </label>
                </div>
            </div>

            <div class="col-lg-6">
                <label class="form-label">Tanggal Kegiatan</label>
                <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" class="form-control" value="{{ old('tanggal_kegiatan') }}">
            </div>
            <div class="col-lg-6">
                <label class="form-label">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
            </div>
            <div class="col-lg-6">
                <label class="form-label">Jam Selesai</label>
                <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
            </div>
            <div class="col-lg-12">
                <label class="form-label">Materi / Nama Kegiatan</label>
                <input type="text" name="materi" class="form-control" placeholder="Contoh : Rapat Evaluasi Bulanan" value="{{ old('materi') }}">
                <small class="text-helper">Isi nama kegiatan yang akan dilaksanakan.</small>
            </div>
        </div>

        <div id="bookingAlert" class="alert alert-danger rounded-4 mt-4 d-none">
            <i class="bi bi-x-circle-fill me-2"></i>
            Jadwal atau ruangan sudah digunakan. Silakan pilih waktu yang berbeda.
        </div>
        <div id="bookingSuccess" class="alert alert-success rounded-4 mt-4 d-none">
            <i class="bi bi-check-circle-fill me-2"></i>
            Ruangan tersedia dan dapat digunakan.
        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT: SIMPAN KE DATABASE & TAMPILKAN DI DROPDOWN --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const btnSimpanRuangan = document.getElementById('btn_simpan_ruangan');
    const inputRuanganBaru = document.getElementById('input_ruangan_baru');
    const checkboxRenovasi = document.getElementById('checkbox_renovasi');
    const selectTempat = document.getElementById('tempat');

    btnSimpanRuangan.addEventListener('click', function () {
        const namaRuangan = inputRuanganBaru.value.trim();
        const statusRuangan = checkboxRenovasi.checked ? 'renovasi' : 'tersedia';

        if (namaRuangan === '') {
            alert('Harap ketik nama ruangan terlebih dahulu!');
            return;
        }

        // Disable tombol saat proses request
        btnSimpanRuangan.disabled = true;
        btnSimpanRuangan.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';

        // Kirim data ke backend Laravel via AJAX
        fetch("{{ route('ruangan.storeAjax') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nama_ruangan: namaRuangan,
                status: statusRuangan
            })
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Error HTTP ' + response.status);
            }
            return data;
        })
        .then(data => {
            btnSimpanRuangan.disabled = false;
            btnSimpanRuangan.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Simpan';

            if (data.status === 'success') {
                const nama = data.data.nama_ruangan;
                const status = data.data.status;

                // Cari apakah opsi ruangan ini sudah ada di dropdown
                let existingOption = null;
                for (let i = 0; i < selectTempat.options.length; i++) {
                    if (selectTempat.options[i].value.toLowerCase() === nama.toLowerCase()) {
                        existingOption = selectTempat.options[i];
                        break;
                    }
                }

                if (existingOption) {
                    // JIKA SUDAH ADA: UPDATE STATUS DAN TAMPILANNYA
                    if (status === 'renovasi') {
                        existingOption.text = nama + ' (Sedang Renovasi 🛠️)';
                        existingOption.disabled = true;
                        existingOption.className = 'text-muted bg-light';
                        selectTempat.value = ''; // Reset pilihan jika opsi yang aktif diubah jadi renovasi
                        alert('Status ruangan "' + nama + '" berhasil diubah menjadi Sedang Renovasi!');
                    } else {
                        existingOption.text = nama;
                        existingOption.disabled = false;
                        existingOption.className = '';
                        existingOption.selected = true;
                        alert('Status ruangan "' + nama + '" berhasil diubah menjadi Tersedia kembali!');
                    }
                } else {
                    // JIKA BELUM ADA: TAMBAHKAN OPSI BARU
                    let newOption = document.createElement('option');
                    newOption.value = nama;

                    if (status === 'renovasi') {
                        newOption.text = nama + ' (Sedang Renovasi 🛠️)';
                        newOption.disabled = true;
                        newOption.className = 'text-muted bg-light';
                        alert('Ruangan "' + nama + '" berhasil ditambahkan (Sedang Renovasi).');
                    } else {
                        newOption.text = nama;
                        newOption.selected = true;
                        alert('Ruangan "' + nama + '" berhasil ditambahkan dan dipilih!');
                    }

                    selectTempat.add(newOption);
                }

                // Reset form input
                inputRuanganBaru.value = '';
                checkboxRenovasi.checked = false;
            }
        })
        .catch(error => {
            console.error('Error Detail:', error);
            btnSimpanRuangan.disabled = false;
            btnSimpanRuangan.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Simpan';
            alert('Gagal memperbarui status: ' + error.message);
        });
    });
});
    </script>

{{-- ===================================================== --}}
{{-- KEBUTUHAN LOGISTIK --}}
{{-- ===================================================== --}}
<div id="logistikCard" class="card form-card" style="display:none;">
    <div class="card-header-custom">
        <i class="bi bi-box-seam me-2"></i>
        Kebutuhan Logistik
    </div>
    <div class="card-body">
        <div class="alert alert-warning border-0 rounded-4">
            <i class="bi bi-lightbulb-fill me-2"></i>
            Isi kebutuhan logistik apabila kegiatan memerlukan perlengkapan dari Kecamatan.
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <label class="form-label">Jumlah Peserta</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                    <input type="number" name="jumlah_peserta" min="0" class="form-control" value="{{ old('jumlah_peserta', 0) }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Kursi</label>
                <div class="input-group">
                    <span class="input-group-text">🪑</span>
                    <input type="number" name="kursi" min="0" class="form-control" value="{{ old('kursi', 0) }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Meja</label>
                <div class="input-group">
                    <span class="input-group-text">🪟</span>
                    <input type="number" name="meja" min="0" class="form-control" value="{{ old('meja', 0) }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Proyektor</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-projector-fill"></i></span>
                    <input type="number" name="proyektor" min="0" class="form-control" value="{{ old('proyektor', 0) }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Microphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-mic-fill"></i></span>
                    <input type="number" name="mic" min="0" class="form-control" value="{{ old('mic', 0) }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Sound System</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-speaker-fill"></i></span>
                    <input type="number" name="sound_system" min="0" class="form-control" value="{{ old('sound_system', 0) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label">Kabel Roll</label>
                <div class="input-group">
                    <span class="input-group-text">🔌</span>
                    <input type="number" name="kabel_roll" min="0" class="form-control" value="{{ old('kabel_roll', 0) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label">Perlengkapan Lainnya</label>
                <input type="text" name="lainnya" class="form-control" placeholder="Contoh : Whiteboard, Flipchart, Banner" value="{{ old('lainnya') }}">
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- BUTTON --}}
{{-- ===================================================== --}}
<div class="d-flex justify-content-end gap-3 mt-4 mb-5">
    <a href="{{ route('suratmasuk.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-2"></i> Simpan Surat
    </button>
</div>

</form>

{{-- ========================================================= --}}
{{-- JAVASCRIPT LENGKAP & SUDAH DIPERBAIKI --}}
{{-- ========================================================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/*========================================
1. FUNGSI UTAMA & GLOBAL
========================================*/

// A. Ambil Nomor Registrasi dari Kode Arsip
function ambilNomorRegistrasi() {
    let id = $('#kode_arsip_id').val();

    if(!id) {
        $('#nomor_registrasi').val('');
        $('#nomor_registrasi_hidden').val('');
        return;
    }

    let fetchUrl = "{{ url('/suratmasuk/get-nomor-registrasi') }}/" + id;

    $.ajax({
        url: fetchUrl,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if(data && data.nomor_registrasi) {
                $('#nomor_registrasi').val(data.nomor_registrasi);
                $('#nomor_registrasi_hidden').val(data.nomor_registrasi);
            } else {
                console.warn("Nomor registrasi dari server kosong/tidak ditemukan.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Fetch Error:", error);
        }
    });
}

// B. Toggle Card Booking & Logistik
function toggleBooking(){
    let jenis = $('#jenis_surat').val();
    if(jenis === "Internal"){
        $('#bookingCard').slideDown();
        $('#logistikCard').slideDown();
    } else {
        $('#bookingCard').slideUp();
        $('#logistikCard').slideUp();
    }
}

// C. Preview Dokumen File Upload
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

// D. AJAX Cek Nomor Surat Terakhir (Rekomendasi Otomatis)
function cekNomorTerakhir(kasi) {
    if (!kasi) return;

    // Tampilkan status loading
    $('#info_nomor_terakhir').removeClass('d-none alert-danger alert-success')
        .addClass('alert-info')
        .html('⌛ <i>Mengecek nomor surat terakhir di database...</i>');

    $.ajax({
        url: "{{ route('suratmasuk.get_last_nomor') }}",
        type: "GET",
        data: { kasi: kasi },
        success: function (response) {
            // Auto-fill nomor urut rekomendasi ke input
            $('#nomor_surat_input').val(response.next_number);

            // Tampilkan pesan informasi yang jelas
            $('#info_nomor_terakhir').removeClass('alert-info')
                .addClass('alert-success')
                .html(`
                    <strong>📌 Informasi Nomor Surat (${kasi}):</strong><br>
                    • Surat terakhir di database: <span class="badge bg-secondary">${response.last_full_nomor || '-'}</span><br>
                    • Otomatis diisi nomor berikutnya: <b>${response.next_number}</b> <i>(Dapat Anda ubah jika surat susulan/backdate)</i>.
                `);

            updateNomorSuratInternal();
        },
        error: function () {
            $('#info_nomor_terakhir').removeClass('alert-info')
                .addClass('alert-danger')
                .html('❌ Gagal mengambil data nomor surat terakhir.');
        }
    });
}

// E. Update State Form berdasarkan Jenis Surat (Internal / Eksternal)
function updateFormState() {
    let jenisSurat = $('#jenis_surat').val();
    
    if (jenisSurat === 'Internal') {
        $('#wrapper_pengirim_internal').removeClass('d-none');
        $('#wrapper_pengirim_manual').addClass('d-none');
        $('#suffix_kode_unit').removeClass('d-none');
        $('#help_nomor_surat').text('Ketik nomor urut saja (misal: 012), suffix unit akan otomatis ditambahkan.');

        let selectedKasi = $('#pengirim_internal_select').val();
        if(selectedKasi) {
            cekNomorTerakhir(selectedKasi);
        } else {
            updateNomorSuratInternal();
        }
    } else {
        $('#wrapper_pengirim_internal').addClass('d-none');
        $('#wrapper_pengirim_manual').removeClass('d-none');
        $('#suffix_kode_unit').addClass('d-none');
        $('#info_nomor_terakhir').addClass('d-none');
        $('#help_nomor_surat').text('Masukkan nomor surat lengkap sesuai dokumen yang diterima.');

        $('#pengirim_final').val($('#pengirim_manual').val());
        $('#nomor_surat_final').val($('#nomor_surat_input').val());
    }
}

// F. Gabungkan Nomor Surat Internal ke Input Hidden Final
function updateNomorSuratInternal() {
    let kodeUnit = $('#pengirim_internal_select option:selected').data('kode') || $('#pengirim_internal_select').val() || 'Sekr';
    let namaPengirim = $('#pengirim_internal_select option:selected').text();
    let nomorUrut = $('#nomor_surat_input').val().trim();
    let tahun = new Date().getFullYear();

    // Update teks suffix di samping inputan (contoh: /Sekr/2026)
    $('#suffix_kode_unit').text('/' + kodeUnit + '/' + tahun);

    // Set nilai pengirim final jika memilih seksi
    if ($('#pengirim_internal_select').val() !== '') {
        $('#pengirim_final').val(namaPengirim);
    }

    // Combine format final ke hidden input: 012/Sekr/2026
    if (nomorUrut !== '') {
        $('#nomor_surat_final').val(nomorUrut + '/' + kodeUnit + '/' + tahun);
    } else {
        $('#nomor_surat_final').val('');
    }
}


/*========================================
2. EVENT LISTENERS (JALAN SETELAH DOM READY)
========================================*/
$(document).ready(function() {

    // --- Inisialisasi Tampilan Awal ---
    toggleBooking();
    updateFormState();

    if($('#kode_arsip_id').val()){
        ambilNomorRegistrasi();
    }

    // Trigger Upload Button Area
    $('#btnUploadArea').on('click', function() {
        $('#file_surat').click();
    });

    // --- Event Handlers ---

    // 1. Kode Arsip Change (Mendukung Select biasa & Select2)
    $('#kode_arsip_id').on('change select2:select', function() {
        ambilNomorRegistrasi();
    });

    // 2. Jenis Surat Change
    $('#jenis_surat').on('change', function() {
        toggleBooking();
        updateFormState();
    });

    // 3. Pengirim Internal Dropdown Change
    $('#pengirim_internal_select').on('change', function() {
        let kasi = $(this).val();
        if (kasi) {
            cekNomorTerakhir(kasi);
        } else {
            $('#info_nomor_terakhir').addClass('d-none');
            updateNomorSuratInternal();
        }
    });

    // 4. Input Manual Pengirim (Eksternal)
    $('#pengirim_manual').on('input', function() {
        if ($('#jenis_surat').val() === 'Eksternal') {
            $('#pengirim_final').val($(this).val());
        }
    });

    // 5. Input Nomor Surat Input
    $('#nomor_surat_input').on('input', function() {
        if ($('#jenis_surat').val() === 'Internal') {
            updateNomorSuratInternal();
        } else {
            $('#nomor_surat_final').val($(this).val());
        }
    });

    // 6. Preview File
    $('#file_surat').on('change', previewDokumen);

    // 7. Cek Bentrok Booking Tempat (Real-time AJAX)
    $("#tempat, #tanggal_kegiatan, #jam_mulai, #jam_selesai").on("change", function(){
        let tempat = $("#tempat").val();
        let tanggal = $("#tanggal_kegiatan").val();
        let mulai = $("#jam_mulai").val();
        let selesai = $("#jam_selesai").val();

        if(!tempat || !tanggal || !mulai || !selesai) return;

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
                    $("#bookingSuccess").addClass("d-none");
                } else {
                    $("#bookingAlert").addClass("d-none");
                    $("#bookingSuccess").removeClass("d-none");
                }
            }
        });
    });

    // 8. Submit Form dengan SweetAlert Loading
    $("#formRegistrasiSurat").on("submit", function(){
        Swal.fire({
            title: "Menyimpan Surat",
            text: "Mohon tunggu sebentar...",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

});
</script>
@endsection