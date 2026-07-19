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
<div class="container-fluid">

    <div class="chart-box">

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control">

            </div>
            
            <div class="mb-3">

                <label>Email</label>

                <input
                    type="text"
                    name="nomor_wa"
                    class="form-control"
                    placeholder="628xxxxxxxxxx">

            </div>

            <div class="mb-3">

                <label>Role</label>
            
                <select name="role"
                        class="form-control">
            
                    <option value="admin">
                        Admin
                    </option>
            
                    <option value="user">
                        User
                    </option>
            
                </select>
            
            </div>

            <div class="mb-3">

                <label>Password</label>

                <input type="password"
                       name="password"
                       class="form-control">

            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection