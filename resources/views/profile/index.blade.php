@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.profile-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.header-profile{
    background:linear-gradient(135deg,#4f46e5,#2563eb);
    padding:40px;
    color:white;
    text-align:center;
}

.photo{
    width:140px;
    height:140px;
    border-radius:50%;
    border:5px solid white;
    object-fit:cover;
    background:#fff;
}

.form-control{
    border-radius:12px;
    min-height:48px;
}

.btn-save{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:12px;
}

.btn-save:hover{
    background:#1d4ed8;
    color:white;
}

</style>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<div class="card profile-card">

    <div class="header-profile">

        @if(Auth::user()->photo)

<img src="{{ Storage::url(Auth::user()->photo) }}"
     style="
        width:55px;
        height:55px;
        border-radius:50%;
        object-fit:cover;
        border:2px solid #eef4ff;
     ">

@else

<img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff&size=200"
     style="
        width:55px;
        height:55px;
        border-radius:50%;
        object-fit:cover;
     ">

@endif

        <h3 class="mt-3">

            {{ Auth::user()->name }}

        </h3>

        <p>

            {{ ucfirst(Auth::user()->role) }}

        </p>

    </div>

    <div class="card-body p-4">

        <form action="{{ route('profil.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">Nama</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', Auth::user()->name) }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', Auth::user()->email) }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Foto Profil</label>

                    <input
                        type="file"
                        name="photo"
                        class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Role</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ ucfirst(Auth::user()->role) }}"
                        readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Password Baru</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Konfirmasi Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control">

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-save">

                <i class="bi bi-save"></i>

                Simpan Perubahan

            </button>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))

<script>

Swal.fire({

    icon:'success',

    title:'Berhasil',

    text:'{{ session("success") }}',

    timer:2000,

    showConfirmButton:false

});

</script>

@endif

@endsection