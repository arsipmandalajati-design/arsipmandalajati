@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="welcome-box mb-4">
        <h2>
            <i class="bi bi-person-circle"></i>
            Profil Saya
        </h2>

        <p>
            Kelola informasi akun Anda.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-4 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <!-- FOTO -->
        <div class="col-lg-4 mb-4">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body text-center">

                    @if(Auth::user()->photo)

                        <img src="{{ asset('storage/'.Auth::user()->photo) }}"
                             class="profile-avatar">

                    @else

                        <div class="avatar-default">

                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                        </div>

                    @endif

                    <h4 class="mt-4 mb-1">

                        {{ Auth::user()->name }}

                    </h4>

                    <p class="text-muted">

                        {{ Auth::user()->email }}

                    </p>

                    <span class="badge bg-primary px-3 py-2">

                        {{ Auth::user()->role_id == 1 ? 'Administrator' : 'Pegawai' }}

                    </span>

                </div>

            </div>

        </div>

        <!-- FORM -->
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body p-4">

                    <h4 class="mb-4">

                        <i class="bi bi-pencil-square"></i>

                        Edit Profil

                    </h4>

                    <form method="POST"
                          action="{{ route('profile.update') }}"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PATCH')

                        <div class="mb-3">

                            <label class="form-label">

                                Nama Lengkap

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name',Auth::user()->name) }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email',Auth::user()->email) }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Foto Profil

                            </label>

                            <input
                                type="file"
                                name="photo"
                                class="form-control">

                        </div>

                        <hr>

                        <h5 class="mb-3">

                            Ganti Password (Opsional)

                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                        
                            <input type="password"
       name="password"
       class="form-control"
       autocomplete="new-password"
       placeholder="Kosongkan jika tidak ingin mengganti password">


                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                        
                            <input type="password"
       name="password_confirmation"
       class="form-control"
       autocomplete="new-password"
       placeholder="Ulangi password baru">
                        </div>

                        <button class="btn btn-primary rounded-pill px-5">

                            <i class="bi bi-check-circle"></i>

                            Simpan Perubahan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.profile-avatar{

width:180px;
height:180px;
border-radius:50%;
object-fit:cover;
border:6px solid #eef4ff;
box-shadow:0 10px 30px rgba(0,0,0,.15);

}

.avatar-default{

width:180px;
height:180px;
border-radius:50%;
margin:auto;
background:#2563eb;
display:flex;
justify-content:center;
align-items:center;
font-size:70px;
font-weight:bold;
color:white;
border:6px solid #eef4ff;

}

.card{

transition:.3s;

}

.card:hover{

transform:translateY(-6px);

}

.form-control{

height:50px;
border-radius:12px;

}

.form-control:focus{

border-color:#2563eb;
box-shadow:0 0 0 .15rem rgba(37,99,235,.15);

}

</style>

@endsection