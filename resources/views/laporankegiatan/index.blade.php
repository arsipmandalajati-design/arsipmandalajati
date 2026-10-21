@extends('layouts.app')

@section('page-icon')
<i class="bi bi-calendar-event-fill"></i>
@endsection

@section('page-title')
Laporan
@endsection

@section('page-description')
Rekap seluruh kegiatan Kecamatan Mandalajati.
@endsection

@section('content')

<!-- Catatan: Sebaiknya link CSS Bootstrap Icons dipindah ke layouts.app jika memungkinkan -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.header-card {
    background: linear-gradient(135deg, #003844, #0f5c6e);
    border-radius: 22px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,56,68,.15);
}
.running-box {
    background: #ffffff;
    border-radius: 18px;
    padding: 18px 22px;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,.05);
}
.running-box .icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #c6ddf0;
    color: #003844;
    font-size: 22px;
    margin-right: 15px;
}
.stat-card {
    border: none;
    border-radius: 20px;
    padding: 22px;
    color: white;
    box-shadow: 0 10px 20px rgba(0,0,0,.08);
    transition: .3s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-icon {
    font-size: 35px;
    opacity: .9;
}
.stat-number {
    font-size: 32px;
    font-weight: 700;
    margin-top: 10px;
}
.bg-total {
    background: linear-gradient(135deg, #003844, #0f5c6e);
}
.bg-success2 {
    background: linear-gradient(135deg, #198754, #20c997);
}
.bg-primary2 {
    background: linear-gradient(135deg, #0d6efd, #4dabf7);
}
.bg-warning2 {
    background: linear-gradient(135deg, #fd7e14, #ffc107);
}
.filter-card, .table-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
}
.table-card {
    overflow: hidden;
}
.table thead {
    background: #003844;
    color: white;
}
.badge {
    padding: 8px 14px;
    border-radius: 30px;
    font-size: 12px;
}
</style>

<!-- RUNNING BOX / INFORMASI -->
<div class="running-box">
    <div class="d-flex align-items-center">
        <div class="icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <div>
            <b>Informasi</b>
            <br>
            Gunakan halaman ini untuk melihat rekap kegiatan, melakukan pencarian berdasarkan periode, serta mencetak laporan kegiatan dalam format PDF.
        </div>
    </div>
</div>

<!-- STATISTIK KARTU -->
<div class="row mb-4">
    <div class="col-lg-3 mb-3">
        <div class="stat-card bg-total">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>Total Kegiatan</div>
                    <div class="stat-number">{{ $statistik['total'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="stat-card bg-primary2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>Terjadwal</div>
                    <div class="stat-number">{{ $statistik['terjadwal'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-calendar-week-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="stat-card bg-success2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>Selesai</div>
                    <div class="stat-number">{{ $statistik['selesai'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="stat-card bg-warning2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>Ditunda</div>
                    <div class="stat-number">{{ $statistik['ditunda'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="card filter-card mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-4">
            <i class="bi bi-funnel-fill me-2 text-primary"></i>
            Filter Laporan
        </h5>
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="row">
                <!-- Nama Kegiatan -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" placeholder="Cari kegiatan..." value="{{ request('nama_kegiatan') }}">
                </div>

                <!-- Tanggal Awal -->
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <!-- Status -->
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Terjadwal" {{ request('status') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditunda" {{ request('status') == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                    </select>
                </div>

                <!-- Tombol Action -->
                <div class="col-lg-3 d-flex align-items-end mb-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary me-2" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                    <a href="{{ route('laporan.print', request()->all()) }}" target="_blank" class="btn btn-danger" title="Cetak PDF">
                        <i class="bi bi-printer"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card table-card mt-4">
    <div class="card-header bg-white border-0 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-table me-2 text-primary"></i>
                Data Laporan Kegiatan
            </h5>
            <span class="badge bg-primary">
                Total : {{ $laporan->total() }}
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th class="text-center">Dokumentasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="ps-3">
                            {{ $laporan->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <b>{{ $item->nama_kegiatan }}</b>
                            <br>
                            <small class="text-muted">{{ $item->keterangan }}</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            <br>
                            <small class="text-muted">
                                {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                            </small>
                        </td>
                        <td>{{ $item->tempat }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>
                            @if($item->status == "Selesai")
                                <span class="badge bg-success">Selesai</span>
                            @elseif($item->status == "Terjadwal")
                                <span class="badge bg-primary">Terjadwal</span>
                            @else
                                <span class="badge bg-warning text-dark">Ditunda</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->dokumentasi)
                                <a href="{{ asset('storage/' . $item->dokumentasi) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-image"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-folder-x display-5 text-secondary"></i>
                            <p class="mt-2 text-muted">Belum ada data kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="mt-4">
    {{ $laporan->appends(request()->query())->links() }}
</div>

@endsection