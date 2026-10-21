@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Edit Data User
@endsection

@section('page-description')
Kecamatan Mandalajati.
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Kepegawaian</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->pejabat->nip ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jabatan Resmi</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->pejabat->jabatan ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pangkat / Golongan Ruang</label>
                        <input type="text" name="golongan" class="form-control" value="{{ old('golongan', $user->pejabat->golongan ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Unit Kerja / Seksi</label>
                        <input type="text" name="unit_kerja" class="form-control" value="{{ old('unit_kerja', $user->pejabat->unit_kerja ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hak Akses Sistem (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="Pegawai" {{ old('role', $user->role) == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-shield-lock me-2"></i>Akun & Kontak Login</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email Kedinasan</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="nomor_wa" class="form-control" value="{{ old('nomor_wa', $user->nomor_wa) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Password Baru <small class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah password)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tetap">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection