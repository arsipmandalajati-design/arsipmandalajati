@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Tambah Data User
@endsection

@section('page-description')
Kecamatan Mandalajati.
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Kepegawaian</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Drs. H. Budi Santoso, M.Si" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Contoh: 197503121998031005" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jabatan Resmi</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Seksi Pemerintahan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pangkat / Golongan Ruang</label>
                        <input type="text" name="golongan" class="form-control" value="{{ old('golongan') }}" placeholder="Contoh: Pembina / IV/a">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Unit Kerja / Seksi</label>
                        <input type="text" name="unit_kerja" class="form-control" value="{{ old('unit_kerja', 'Kecamatan Mandalajati') }}" placeholder="Contoh: Seksi Pemerintahan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hak Akses Sistem (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="Pegawai" {{ old('role') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-shield-lock me-2"></i>Akun & Kontak Login</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email Kedinasan</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="budi@mandalajati.go.id" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="nomor_wa" class="form-control" value="{{ old('nomor_wa') }}" placeholder="081234567890">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection