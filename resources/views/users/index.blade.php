@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Data User & Pejabat
@endsection

@section('page-description')
Kelola seluruh data pengguna dan pejabat yang terintegrasi di Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.header-card{
    background:linear-gradient(135deg,#0f766e,#14b8a6,#5eead4);
    border-radius:22px;
    color:#fff;
    padding:30px;
    margin-bottom:30px;
    box-shadow:0 15px 35px rgba(15,118,110,.25);
    position:relative;
    overflow:hidden;
}
.data-card{
    border:none;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}
.table{
    border-collapse:separate;
    border-spacing:0 10px;
}
.table thead th{
    border:none;
    color:#6b7280;
    font-weight:700;
}
.table tbody tr{
    background:white;
    box-shadow:0 5px 18px rgba(0,0,0,.06);
    transition:.30s;
}
.table tbody tr:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(79,70,229,.15);
}
.table td{
    vertical-align:middle;
    border:none;
    padding:18px;
}
.btn-modern{
    transition:.30s;
    border-radius:12px;
}
.btn-modern:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 20px rgba(0,0,0,.18);
}
.role-admin{
    background:#dbeafe;
    color:#2563eb;
    padding:6px 15px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}
.role-pegawai{
    background:#dcfce7;
    color:#16a34a;
    padding:6px 15px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}
</style>

<div class="container-fluid px-0">
    
    <!-- Flash Message Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            
            <!-- Form Pencarian, Filter, & Tombol Tambah (Sejajar 1 Baris) -->
            <form action="{{ route('users.index') }}" method="GET" class="row g-2 align-items-center mb-4">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="nama" class="form-control border-start-0" value="{{ request('nama') }}" placeholder="Cari nama, email, NIP, atau jabatan...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">-- Semua Role --</option>
                        <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Pegawai" {{ request('role') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100" title="Filter"><i class="bi bi-filter"></i>Filter</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </div>
                <div class="col-md-2 text-md-end">
                    <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-3 w-100 text-nowrap">
                        <i class="bi bi-plus-lg me-1"></i> Tambah User
                    </a>
                </div>
            </form>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-uppercase fs-7">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="25%">Nama & Email</th>
                            <th width="25%">NIP & Jabatan</th>
                            <th width="15%">Unit Kerja</th>
                            <th width="10%" class="text-center">Role</th>
                            <th width="10%" class="text-center">No. WhatsApp</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                <div>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
                                    </td>
                                </div>
                                <td>
                                    <div class="fw-semibold text-secondary small">{{ $user->pejabat->nip ?? '-' }}</div>
                                    <div class="text-dark small">{{ $user->pejabat->jabatan ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $user->pejabat->unit_kerja ?? 'Kecamatan Mandalajati' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : 'bg-success' }} px-3 py-2 rounded-pill">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($user->nomor_wa)
                                        <a href="https://wa.me/{{ $user->nomor_wa }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1">
                                            <i class="bi bi-whatsapp"></i> {{ $user->nomor_wa }}
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data user & pejabat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    Belum ada data user atau pegawai yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection