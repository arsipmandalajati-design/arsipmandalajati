@extends('layouts.app')

@section('page-icon')
<i class="bi bi-folder2-open"></i>
@endsection

@section('page-title')
Data Arsip
@endsection

@section('page-description')
Kelola dan pantau seluruh dokumen atau surat masuk dan keluar Kecamatan Mandalajati
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function(){
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#0d6efd'
    });
});
</script>
@endif

<style>
.table {
    margin-bottom: 0;
}
.table thead {
    background: #083c47;
}
.table thead th {
    color: #fff;
    font-weight: 700;
    border: none;
    padding: 18px;
    vertical-align: middle;
}
.table tbody td {
    padding: 22px 18px;
    vertical-align: middle;
    border-top: 1px solid #edf2f7;
}
.table tbody tr {
    transition: .3s;
}
.table tbody tr:hover {
    background: #f7fbff;
}
.badge-kode {
    display: inline-block;
    background: #2563eb;
    color: #fff;
    padding: 9px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
}
.nama-klasifikasi {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}
.btn-action {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}
.table-card {
    border-radius: 20px;
    overflow: hidden;
}
.running-box {
    background: #e0f2fe;
    color: #0369a1;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
}
</style>

<div class="running-box">
    <div class="d-flex align-items-center">
        <i class="bi bi-folder-fill me-3 fs-5"></i>
        <span>
            Pusat penyimpanan data arsip surat masuk dan surat keluar Kecamatan Mandalajati yang terintegrasi secara otomatis.
        </span>
    </div>
</div>

<!-- FILTER & TOMBOL PRINT -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('arsip.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">No. Registrasi</label>
                    <input type="text" name="nomor_registrasi" class="form-control rounded-3" placeholder="Cari nomor registrasi..." value="{{ request('nomor_registrasi') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Perihal / Nama Arsip</label>
                    <input type="text" name="nama_arsip" class="form-control rounded-3" placeholder="Cari perihal / nama arsip..." value="{{ request('nama_arsip') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('arsip.index') }}" class="btn btn-secondary rounded-3" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                    <!-- TOMBOL PRINT / CETAK -->
                    <a href="{{ route('arsip.print') }}" target="_blank" class="btn btn-info text-white rounded-3 ms-auto" title="Cetak Laporan Arsip">
                        <i class="bi bi-printer-fill me-1"></i> Print
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABLE DATA ARSIP -->
<div class="card border-0 shadow-sm table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">No</th>
                    <th style="width: 160px;">No. Registrasi</th>
                    <th style="width: 140px;">Kode Arsip</th>
                    <th>Perihal / Nama Arsip</th>
                    <th style="width: 150px;">Tanggal Arsip</th>
                    <th class="text-center" style="width: 100px;">File</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(count($arsip) > 0)
                    @foreach($arsip as $item)
                    <tr>
                        <td class="text-center fw-bold">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">
                                {{ $item->nomor_registrasi }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-kode">
                                {{ $item->kode_arsip }}
                            </span>
                        </td>
                        <td>
                            <div class="nama-klasifikasi">
                                {{ $item->nama_arsip }}
                            </div>
                            <small class="text-muted">Retensi: {{ $item->retensi_tahun }} Tahun</small>
                        </td>
                        <td>
                            <div class="small fw-semibold text-dark">{{ $item->tanggal_arsip }}</div>
                            <small class="text-muted">Exp: {{ $item->tanggal_kadaluarsa }}</small>
                        </td>
                        <td class="text-center">
                            @if($item->file_arsip)
                            <a href="{{ asset('storage/' . $item->file_arsip) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Lihat File">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Lihat
                            </a>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(userCan('arsip', 'ubah'))
                            <!-- Tombol Edit ke Halaman Terpisah -->
                            <a href="{{ route('arsip.edit', $item->id) }}" class="btn btn-warning btn-action text-white me-1" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @endif

                            @if(userCan('arsip', 'hapus'))
                            <button type="button" class="btn btn-danger btn-action btn-hapus" 
                                data-id="{{ $item->id }}"
                                data-noreg="{{ $item->nomor_registrasi }}"
                                title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif

                            @if(!userCan('arsip', 'ubah') && !userCan('arsip', 'hapus'))
                            <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-envelope-open display-5 text-secondary"></i>
                            <h5 class="mt-3">Belum ada data arsip surat</h5>
                            <p class="text-muted">Data akan otomatis masuk saat Anda menginput surat masuk atau surat keluar.</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection