@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Disposisi Surat Masuk
@endsection

@section('page-description')
Kelola lembar disposisi internal untuk meneruskan instruksi surat kepada pegawai Kecamatan Mandalajati.
@endsection

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

/* Kotak Ringkasan Surat ala Mockup */
.info-box-custom {
    background-color: #f1f5f9;
    border-left: 5px solid #0f766e;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
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

    <div class="card card-modern">
        <div class="card-body p-4">
            
            {{-- Kotak Informasi Surat Ringkas (Gaya Minimalis Bersih) --}}
            <div class="info-box-custom">
                <div class="mb-2">
                    <span class="text-secondary fw-semibold">Nomor Surat:</span> 
                    <span class="fw-bold text-dark">{{ $surat->nomor_surat }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-secondary fw-semibold">Tanggal Surat:</span> 
                    <span class="text-dark">{{ $surat->tanggal_surat }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-secondary fw-semibold">Asal Pengirim:</span> 
                    <span class="text-dark">{{ $surat->pengirim }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-secondary fw-semibold">Judul / Perihal:</span> 
                    <span class="fw-bold text-dark uppercase">{{ $surat->judul }} - {{ $surat->perihal }}</span>
                </div>
                <div>
                    <span class="text-secondary fw-semibold">Status Berkas:</span> 
                    <span class="badge bg-teal text-white px-2 py-1" style="background-color: #0f766e;">{{ $surat->status }}</span>
                </div>
            </div>

            <hr class="my-4 text-muted">

            {{-- ===================== FORM DISPOSISI INTERAKTIF UNTUK SEMUA USER ===================== --}}
            @if(Auth::check())
                <div class="section-title">Form Disposisi Surat Masuk</div>
                
                <form action="{{ route('suratmasuk.kirimDisposisi', $surat->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="user_disposisi_id" class="form-label fw-semibold text-secondary">Tujuan Disposisi / Kepada <span class="text-danger">*</span></label>
                            <select name="user_disposisi_id" id="user_disposisi_id" class="form-select" required>
                                <option value="">-- PILIH DISPOSISI --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $surat->user_disposisi_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role ?? 'User') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="catatan_admin" class="form-label fw-semibold text-secondary">Isi Disposisi / Catatan <span class="text-danger">*</span></label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" class="form-control" placeholder="Tuliskan instruksi atau catatan disposisi di sini..." required>{{ old('catatan_admin', $surat->catatan_admin) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('suratmasuk.index') }}" class="btn btn-light btn-modern text-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn text-white btn-modern" style="background-color: #0f766e;">
                            <i class="bi bi-send-fill me-1"></i> Simpan Disposisi
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>

@endsection