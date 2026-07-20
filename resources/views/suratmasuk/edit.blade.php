@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.page-header {
    background: linear-gradient(135deg, #0f766e, #14b8a6);
    border-radius: 20px;
    padding: 28px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,.1);
}

.form-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,.08);
}

.form-control,
.form-select {
    border-radius: 12px;
    min-height: 48px;
}

.form-control:focus,
.form-select:focus {
    border-color: #0f766e;
    box-shadow: none;
}

textarea.form-control {
    min-height: auto;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f766e;
    border-left: 5px solid #0f766e;
    padding-left: 12px;
    margin-bottom: 20px;
}

.btn-modern {
    border-radius: 12px;
    padding: 10px 24px;
    font-weight: 600;
}

.btn-save {
    background: #0f766e;
    color: white;
}

.btn-save:hover {
    background: #115e59;
    color: white;
}

.alert-modern {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.1);
}
</style>

@if ($errors->any())
<div class="alert alert-danger alert-modern p-3 mb-4">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="page-header">
    <h3 class="fw-bold m-0">
        <i class="bi bi-pencil-square me-2"></i>
        Edit Surat Masuk
    </h3>
    <p class="mb-0 mt-2 text-white-50">
        Perbarui data arsip surat masuk yang sudah tersimpan pada sistem digital.
    </p>
</div>

<div class="card form-card">
    <div class="card-body p-4">
        <form action="{{ route('suratmasuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- BLOK 1: INFORMASI ARSIP --}}
            <div class="section-title">Informasi Arsip</div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="kode_arsip_id" class="form-label fw-semibold text-secondary">Kode Arsip</label>
                    <select name="kode_arsip_id" id="kode_arsip_id" class="form-select" required>
                        <option value="">-- Pilih Kode Arsip --</option>
                        @foreach($kodearsip as $item)
                            <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" {{ old('kode_arsip_id', $surat->kode_arsip_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->kode }} - {{ $item->nama_arsip }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_surat" class="form-label fw-semibold text-secondary">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Judul Surat</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $surat->judul) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Pengirim</label>
                    <input type="text" name="pengirim" class="form-control" value="{{ old('pengirim', $surat->pengirim) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $surat->tanggal_surat) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Perihal</label>
                    <input type="text" name="perihal" class="form-control" value="{{ old('perihal', $surat->perihal) }}" required>
                </div>
            </div>

            <hr class="my-4 text-muted">

            {{-- BLOK 2: FILE SURAT --}}
            <div class="section-title">Berkas Digital</div>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary">Perbarui Berkas Surat (PDF)</label>
                    <input type="file" name="file_surat" class="form-control" accept=".pdf">
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengganti file lama.
                    </small>
                </div>
                
                @if($surat->file_surat)
                <div class="col-md-12">
                    <label class="form-label fw-semibold text-secondary d-block">Berkas Tersimpan</label>
                    <a href="{{ asset('storage/'.$surat->file_surat) }}" target="_blank" class="btn btn-danger btn-modern d-inline-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Lihat File PDF Saat Ini
                    </a>
                </div>
                @endif
            </div>

            <hr class="my-4 text-muted">

            {{-- BLOK 3: INFORMASI KEGIATAN --}}
            <div class="section-title">Informasi Kegiatan Agenda</div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Tempat Pelaksanaan</label>
                    <select name="tempat" class="form-select">
                        <option value="">-- Pilih Tempat --</option>
                        @foreach(['Aula Kecamatan', 'Ruang Camat', 'Ruang Sekretaris', 'Ruang Rapat', 'Halaman Kecamatan'] as $loc)
                            <option value="{{ $loc }}" {{ old('tempat', $surat->tempat) == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" class="form-control" value="{{ old('tanggal_kegiatan', $surat->tanggal_kegiatan) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', $surat->jam_mulai) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', $surat->jam_selesai) }}">
                </div>

                <div class="col-12 mb-2">
                    <label class="form-label fw-semibold text-secondary">Materi / Deskripsi Kegiatan</label>
                    <textarea name="materi" rows="4" class="form-control" placeholder="Tuliskan pokok pembahasan atau materi agenda kegiatan...">{{ old('materi', $surat->materi) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 border-top pt-4">
                <a href="{{ route('suratmasuk.index') }}" class="btn btn-light btn-modern text-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-save btn-modern">
                    <i class="bi bi-check-circle me-1"></i> Perbarui Berkas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function generateNomor(){
    let select = document.getElementById('kode_arsip_id');
    let kode = '';

    if(select.selectedIndex >= 0){
        kode = select.options[select.selectedIndex].getAttribute('data-kode');
    }

    let nomorLama = document.getElementById('nomor_surat').value;

    if(nomorLama === '' || nomorLama.indexOf('/') === -1){
        return;
    }

    let bagian = nomorLama.split('/');
    if(bagian.length >= 2){
        let nomorManual = bagian[1].split('-')[0];
        let tahun = new Date().getFullYear();
        let bulan = new Date().getMonth() + 1;
        let romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        document.getElementById('nomor_surat').value = 'No.' + kode + '/' + nomorManual + '-Kec.MDLJ/T/' + romawi[bulan] + '/' + tahun;
    }
}

document.getElementById('kode_arsip_id').addEventListener('change', generateNomor);
</script>

@endsection