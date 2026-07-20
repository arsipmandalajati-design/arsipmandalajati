@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.page-header{
    background: linear-gradient(135deg, #0f766e, #14b8a6);
    border-radius: 20px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
}

.info-card, .preview-card{
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}

.section-title{
    font-size: 18px;
    font-weight: 700;
    color: #0f766e;
    border-left: 5px solid #0f766e;
    padding-left: 12px;
    margin-bottom: 20px;
}

.info-item{
    margin-bottom: 18px;
}

.info-label{
    display: block;
    font-weight: 700;
    color: #6b7280;
    margin-bottom: 5px;
}

.info-value{
    font-size: 15px;
    color: #111827;
}

.badge-custom{
    background: #d1fae5;
    color: #065f46;
    padding: 8px 15px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
}

.facility-badge {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-download{
    background: #0f766e;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 10px 20px;
}

.btn-download:hover{
    background: #115e59;
    color: white;
}

.btn-back{
    border-radius: 12px;
    padding: 10px 20px;
}

iframe{
    border-radius: 15px;
}
</style>

<div class="page-header">
    <h2 class="fw-bold mb-2">
        <i class="bi bi-envelope-open-fill"></i>
        Detail Surat Masuk
    </h2>
    <p class="mb-0">
        Informasi lengkap surat masuk beserta data kegiatan dan disposisi.
    </p>
</div>

<div class="row">
    <!-- Kolom Kiri: Informasi Detail -->
    <div class="col-lg-5">
        <div class="card info-card">
            <div class="card-body p-4">
                
                <!-- Section 1: Informasi Surat -->
                <div class="section-title">Informasi Surat</div>
                
                <div class="info-item">
                    <span class="info-label">Kode Arsip / No Urut</span>
                    <div class="info-value">
                        <span class="badge-custom">
                            {{ $suratmasuk->kodearsip->kode ?? '-' }} / {{ str_pad($suratmasuk->nomor_urut ?? 0, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-label">Nomor Surat</span>
                    <div class="info-value fw-semibold text-primary">{{ $suratmasuk->nomor_surat }}</div>
                </div>

                <div class="info-item">
                    <span class="info-label">Jenis & Sumber Arsip</span>
                    <div class="info-value">{{ $suratmasuk->jenis_surat ?? '-' }} ({{ $suratmasuk->sumber_arsip ?? '-' }})</div>
                </div>

                <div class="info-item">
                    <span class="info-label">Judul Surat / Perihal</span>
                    <div class="info-value">
                        <strong>{{ $suratmasuk->judul }}</strong>
                        <p class="text-secondary small mb-0 mt-1">{{ $suratmasuk->perihal }}</p>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-label">Pengirim</span>
                    <div class="info-value">{{ $suratmasuk->pengirim }}</div>
                </div>

                <div class="info-item">
                    <span class="info-label">Tanggal Surat</span>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($suratmasuk->tanggal_surat)->translatedFormat('d F Y') }}
                    </div>
                </div>

                <hr>

                <!-- Section 2: Informasi Kegiatan -->
                <div class="section-title">Informasi Kegiatan</div>

                <div class="info-item">
                    <span class="info-label">Tempat Pelaksanaan</span>
                    <div class="info-value"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $suratmasuk->tempat ?? '-' }}</div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <span class="info-label">Tanggal Kegiatan</span>
                            <div class="info-value">
                                {{ $suratmasuk->tanggal_kegiatan ? \Carbon\Carbon::parse($suratmasuk->tanggal_kegiatan)->translatedFormat('d F Y') : '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <span class="info-label">Jam Pelaksanaan</span>
                            <div class="info-value">
                                {{ $suratmasuk->jam_mulai ?? '-' }} - {{ $suratmasuk->jam_selesai ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-label">Materi Pembahasan</span>
                    <div class="info-value">{{ $suratmasuk->materi ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <span class="info-label">Estimasi Peserta</span>
                    <div class="info-value">{{ $suratmasuk->jumlah_peserta ?? 0 }} Orang</div>
                </div>

                <!-- Sub-Section: Kebutuhan Sarana Prasarana -->
                <div class="info-item mt-3">
                    <span class="info-label">Fasilitas & Sarpras Pendukung</span>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <div class="facility-badge"><i class="bi bi-chair text-success"></i> Kursi: <strong>{{ $suratmasuk->kursi ?? 0 }}</strong></div>
                        <div class="facility-badge"><i class="bi bi-calendar-minus text-success"></i> Meja: <strong>{{ $suratmasuk->meja ?? 0 }}</strong></div>
                        <div class="facility-badge"><i class="bi bi-projector text-success"></i> Proyektor: <strong>{{ $suratmasuk->proyektor ?? 0 }}</strong></div>
                        <div class="facility-badge"><i class="bi bi-mic text-success"></i> Mic: <strong>{{ $suratmasuk->mic ?? 0 }}</strong></div>
                        <div class="facility-badge"><i class="bi bi-speaker text-success"></i> Sound: <strong>{{ $suratmasuk->sound_system ?? 0 }}</strong></div>
                        <div class="facility-badge"><i class="bi bi-usb-plug text-success"></i> Kabel Roll: <strong>{{ $suratmasuk->kabel_roll ?? 0 }}</strong></div>
                        @if($suratmasuk->lainnya)
                            <div class="facility-badge bg-light w-100 mt-1"><i class="bi bi-plus-circle text-info"></i> Lainnya: <span class="small">{{ $suratmasuk->lainnya }}</span></div>
                        @endif
                    </div>
                </div>

                <hr>

                <!-- Section 3: Status & Disposisi -->
                <div class="section-title">Status & Disposisi</div>

                <div class="info-item">
                    <span class="info-label">Status Surat</span>
                    <div class="info-value">
                        @if($suratmasuk->status=='Menunggu Verifikasi' || $suratmasuk->status=='Belum Disposisi')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                                {{ $suratmasuk->status }}
                            </span>
                        @elseif($suratmasuk->status=='Sudah Diverifikasi')
                            <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                                {{ $suratmasuk->status }}
                            </span>
                        @elseif($suratmasuk->status=='Sudah Disposisi')
                            <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold">
                                {{ $suratmasuk->status }}
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 rounded-pill fw-bold">
                                {{ $suratmasuk->status }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-label">Diteruskan Kepada (Pegawai)</span>
                    <div class="info-value fw-semibold text-dark">
                        <i class="bi bi-person-badge text-muted me-1"></i> {{ $suratmasuk->userDisposisi->name ?? '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-label">Catatan Rekomendasi / Admin</span>
                    <div class="info-value p-3 bg-light border rounded text-secondary small" style="min-height: 60px;">
                        {{ $suratmasuk->catatan_admin ?? 'Tidak ada catatan tambahan.' }}
                    </div>
                </div>

                <hr>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2 flex-wrap">
                    @if($suratmasuk->file_surat)
                        <a href="{{ asset('storage/'.$suratmasuk->file_surat) }}" target="_blank" class="btn btn-download">
                            <i class="bi bi-download me-1"></i> Download PDF
                        </a>
                    @endif
                    <a href="{{ route('suratmasuk.index') }}" class="btn btn-light border btn-back">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Preview Dokumen -->
    <div class="col-lg-7">
        <div class="card preview-card">
            <div class="card-body p-4">
                <div class="section-title">Preview Dokumen</div>
                
                @if($suratmasuk->file_surat)
                    <div class="rounded overflow-hidden border">
                        <iframe src="{{ asset('storage/'.$suratmasuk->file_surat) }}" width="100%" height="750" frameborder="0"></iframe>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ asset('storage/'.$suratmasuk->file_surat) }}" target="_blank" class="btn btn-download">
                            <i class="bi bi-file-earmark-arrow-down-fill me-1"></i> Buka di Tab Baru
                        </a>
                    </div>
                @else
                    <div class="text-center py-5 my-5">
                        <i class="bi bi-file-earmark-pdf-fill" style="font-size:80px; color:#dc3545;"></i>
                        <h4 class="mt-3 fw-bold">Dokumen Tidak Ditemukan</h4>
                        <p class="text-muted">File berkas lampiran surat masuk belum diunggah atau tidak tersedia di server.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection