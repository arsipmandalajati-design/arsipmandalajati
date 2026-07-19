@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Data User
@endsection

@section('page-description')
Kelola seluruh data pengguna Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

.header-card::before{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    right:-50px;
    top:-60px;
    background:rgba(255,255,255,.12);
    border-radius:50%;
}

.header-card::after{
    content:"";
    position:absolute;
    width:120px;
    height:120px;
    left:-30px;
    bottom:-40px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
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

.total-card{

    background:white;
    color:#4f46e5;
    padding:12px 22px;
    border-radius:30px;
    font-weight:bold;

}

</style>

<div class="container-fluid">

    <div class="running-box">

        <div class="d-flex align-items-center">
    
            <div class="icon">
                <i class="bi bi-megaphone-fill"></i>
            </div>
    
            <div class="running-text">
    
                <span>
                    👥 Kelola Data Pengguna berdasarkan hak akses (RBAC) • Admin memiliki akses penuh sedangkan Pegawai hanya dapat mengakses menu sesuai kewenangannya.
    
                </span>
    
            </div>
    
        </div>
    
    </div>
    
    @yield('content')
    
<!-- FILTER -->
<div class="card data-card mb-4">

    <div class="card-body">

        <form action="{{ route('users.index') }}" method="GET">

            <div class="row align-items-end">

                <!-- Nama -->
                <div class="col-md-5">

                    <label class="form-label fw-semibold">
                        Nama
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           placeholder="Cari Nama User..."
                           value="{{ request('nama') }}">

                </div>

                <!-- Role -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Jabatan
                    </label>

                    <select name="role"
                            class="form-select">

                        <option value="">
                            Semua Jabatan
                        </option>

                        <option value="Admin"
                            {{ request('role')=='Admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="Pegawai"
                            {{ request('role')=='Pegawai' ? 'selected' : '' }}>
                            Pegawai
                        </option>

                    </select>

                </div>

                <!-- Tombol -->
                <div class="col-md-3">

                    <div class="d-flex gap-2">

                        <button class="btn btn-primary btn-modern">

                            <i class="bi bi-search"></i>

                        </button>

                        <a href="{{ route('users.index') }}"
                           class="btn btn-secondary btn-modern">

                            <i class="bi bi-arrow-clockwise"></i>

                        </a>
                            <a href="{{ route('users.create') }}"
                            class="btn btn-primary btn-modern">
            
                                <i class="bi bi-plus-circle-fill"></i>
            
                            </a>
            
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
<!-- CARD -->
<div class="card data-card">

    <div class="card-body">

            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Nomor HP</th>

                            <th class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($users as $user)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td class="fw-semibold">

                                {{ $user->name }}

                            </td>

                            <td>

                                {{ $user->email }}

                            </td>

                            <td>

                                @if($user->role=='Admin')

                                    <span class="role-admin">

                                        Admin

                                    </span>

                                @else

                                    <span class="role-pegawai">

                                        Pegawai

                                    </span>

                                @endif

                            </td>

                            
                            <td class="text-center">

                                <a href="{{ route('users.edit',$user->id) }}"
                                class="btn btn-warning btn-sm btn-modern">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('users.destroy',$user->id) }}"
                                method="POST"
                                class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm btn-modern"
                                    onclick="return confirm('Yakin ingin menghapus user?')">

                                        <i class="bi bi-trash-fill"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
```
