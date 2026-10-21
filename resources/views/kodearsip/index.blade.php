@extends('layouts.app')

@section('page-icon')
<i class="bi bi-folder2-open"></i>
@endsection

@section('page-title')
Kode Arsip
@endsection

@section('page-description')
Kelola klasifikasi kode arsip Kecamatan Mandalajati.
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
.badge-status {
    background: #d1fae5;
    color: #065f46;
    padding: 6px 15px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}
.nama-klasifikasi {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}
.subtext {
    font-size: 12px;
    color: #6b7280;
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
            Data Kode Arsip digunakan sebagai klasifikasi penyimpanan dokumen sehingga pencarian arsip menjadi lebih cepat, terstruktur, dan sesuai standar tata naskah dinas.
        </span>
    </div>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kode Arsip</label>
                    <input type="text" name="kode_arsip" class="form-control rounded-3" placeholder="Cari kode arsip..." value="{{ request('kode_arsip') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nama Klasifikasi</label>
                    <input type="text" name="nama_arsip" class="form-control rounded-3" placeholder="Cari nama klasifikasi..." value="{{ request('nama_arsip') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('kodearsip.index') }}" class="btn btn-secondary rounded-3" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                    <a href="{{ route('kodearsip.create') }}" class="btn btn-success rounded-3 ms-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<!-- TABLE -->
<div class="card border-0 shadow-sm table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center" style="width: 70px;">No</th>
                    <th style="width: 180px;">Kode Arsip</th>
                    <th>Nama Klasifikasi</th>
                    <th class="text-center" style="width: 140px; padding-right: 25px;">Status</th>
                    <th class="text-center" style="width: 150px; padding-right: 30px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kodearsip as $item)
                <tr>
                    <td class="text-center fw-bold">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <span class="badge-kode">
                            {{ $item->kode }}
                        </span>
                    </td>
                    <td>
                        <div class="nama-klasifikasi">
                            {{ $item->nama_arsip }}
                        </div>
                    </td>
                    <td class="text-center" style="padding-right: 25px;">
                        <span class="badge-status">
                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                        </span>
                    </td>
                    <td class="text-center" style="padding-right: 20px;">
                        <a href="{{ route('kodearsip.edit', $item->id) }}" class="btn btn-warning btn-action text-white me-1" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('kodearsip.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-folder-x display-5 text-secondary"></i>
                        <h5 class="mt-3">Belum ada data klasifikasi arsip</h5>
                        <p class="text-muted">Silakan tambahkan kode arsip terlebih dahulu.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection