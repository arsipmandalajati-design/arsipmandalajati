@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Data Pejabat
@endsection

@section('page-description')
Kelola seluruh data pejabat Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon:'success',
        title:'Berhasil',
        text:'{{ session('success') }}',
        confirmButtonColor:'#2563eb'
    });
});
</script>
@endif

<div class="running-box mb-4">
    <div class="d-flex align-items-center">
        <div class="icon me-3">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <div class="running-text">
            <span>🏢 Kelola Data Pejabat Kecamatan Mandalajati agar informasi penanggung jawab selalu diperbarui.</span>
        </div>
    </div>
</div>

<!-- FILTER & TOMBOL TAMBAH (Sejajar 1 Baris) -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('pejabat.index') }}" method="GET" class="row g-2 align-items-center">
            
            <!-- Input Cari Nama Pejabat / NIP -->
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="nama_pejabat" class="form-control border-start-0" value="{{ request('nama_pejabat') }}" placeholder="Cari nama pejabat atau NIP...">
                </div>
            </div>

            <!-- Filter Jabatan -->
            <div class="col-md-3">
                <select name="jabatan" class="form-select">
                    <option value="">-- Semua Jabatan --</option>
                    <option value="Camat" {{ request('jabatan') == 'Camat' ? 'selected' : '' }}>Camat</option>
                    <option value="Kasubag Umum" {{ request('jabatan') == 'Kasubag Umum' ? 'selected' : '' }}>Kasubag Umum</option>
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100" title="Filter"><i class="bi bi-filter"></i>Filter</button>
                <a href="{{ route('pejabat.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
            </div>

            <!-- Tombol Tambah Pejabat -->
            <div class="col-md-2 text-md-end">
                <a href="{{ route('pejabat.create') }}" class="btn btn-primary rounded-pill px-3 w-100 text-nowrap">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pejabat
                </a>
            </div>

        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Pejabat</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Tanda Tangan</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pejabats as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <!-- Diperbaiki menggunakan $item->nama_pejabat atau relasi ke user->name -->
                            <div class="fw-bold text-dark">{{ $item->nama_pejabat ?? $item->user->name ?? '-' }}</div>
                            <div class="small text-muted">{{ $item->user->email ?? '' }}</div>
                        </td>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>
                            @if($item->tanda_tangan)
                                <img src="{{ asset('storage/'.$item->tanda_tangan) }}" width="120" class="rounded border shadow-sm">
                            @else
                                <span class="badge bg-secondary">Belum Upload</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pejabat.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('pejabat.destroy', $item->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada data pejabat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection