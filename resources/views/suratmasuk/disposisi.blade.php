@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.header-card {
    background: linear-gradient(135deg, #0f766e, #14b8a6, #2dd4bf);
    border-radius: 20px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,.1);
}

.card-modern {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.form-control,
.form-select {
    border-radius: 12px;
    min-height: 46px;
}

textarea.form-control {
    min-height: auto;
}

.form-control:focus,
.form-select:focus {
    border-color: #14b8a6;
    box-shadow: none;
}

.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f766e;
    border-left: 4px solid #0f766e;
    padding-left: 10px;
    margin-bottom: 20px;
}

.btn-modern {
    border-radius: 12px;
    padding: 10px 25px;
    font-weight: 600;
}
</style>

<div class="container-fluid">

    <div class="header-card">
        <h3 class="fw-bold m-0">
            <i class="bi bi-send-check-fill me-2"></i>
            Disposisi Surat Masuk
        </h3>
        <p class="mb-0 mt-2 text-white-50">
            Kelola lembar disposisi internal untuk meneruskan instruksi surat kepada pegawai Kecamatan Mandalajati.
        </p>
    </div>

    <div class="card card-modern">
        <div class="card-body p-4">
            
            {{-- Detail Informasi Surat (Selalu Readonly untuk Kedua Role) --}}
            <div class="section-title">Detail Berkas Surat</div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Nomor Surat</label>
                    <input class="form-control bg-light" value="{{ $surat->nomor_surat }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Tanggal Surat</label>
                    <input class="form-control bg-light" value="{{ $surat->tanggal_surat }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Asal Pengirim</label>
                    <input class="form-control bg-light" value="{{ $surat->pengirim }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-secondary">Status Alur Berkas</label>
                    <input class="form-control bg-light fw-bold text-teal" value="{{ $surat->status }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold text-secondary">Judul Surat</label>
                    <input class="form-control bg-light" value="{{ $surat->judul }}" readonly>
                </div>

                <div class="col-12 mb-2">
                    <label class="form-label fw-semibold text-secondary">Perihal / Ringkasan Isi</label>
                    <textarea class="form-control bg-light" rows="3" readonly>{{ $surat->perihal }}</textarea>
                </div>
            </div>

            <hr class="my-4 text-muted">

            {{-- ===================== TAMPILAN JIKA USER ADALAH ADMIN (BISA EDIT) ===================== --}}
            @if(Auth::user()->role == 'admin')
                <div class="section-title">Instruksi Lembar Disposisi</div>
                
                <form action="{{ route('suratmasuk.kirimDisposisi', $surat->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="user_disposisi_id" class="form-label fw-semibold text-secondary">Disposisikan Kepada Pegawai <span class="text-danger">*</span></label>
                            <select name="user_disposisi_id" id="user_disposisi_id" class="form-select" required>
                                <option value="">-- Pilih Pegawai Tujuan --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $surat->user_disposisi_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="catatan_admin" class="form-label fw-semibold text-secondary">Catatan / Instruksi Pimpinan <span class="text-danger">*</span></label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" class="form-control" placeholder="Tulis instruksi tindak lanjut surat di sini..." required>{{ old('catatan_admin', $surat->catatan_admin) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('suratmasuk.index') }}" class="btn btn-light btn-modern text-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-teal text-white btn-modern" style="background-color: #0f766e;">
                            <i class="bi bi-send-fill me-1"></i> Kirim Disposisi
                        </button>
                    </div>
                </form>

            {{-- ===================== TAMPILAN JIKA USER ADALAH PEGAWAI (READONLY) ===================== --}}
            @else
                <div class="section-title">Lembar Disposisi Diterima</div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold text-secondary">Pegawai Penerima Disposisi</label>
                        <input class="form-control bg-light" value="{{ optional($surat->userDisposisi)->name ?? '-' }}" readonly>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label fw-semibold text-secondary">Catatan / Instruksi Pimpinan</label>
                        <textarea class="form-control bg-light" rows="4" readonly>{{ $surat->catatan_admin ?? 'Tidak ada catatan khusus dari pimpinan.' }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end border-top pt-4">
                    <a href="{{ route('suratmasuk.index') }}" class="btn btn-light btn-modern text-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection