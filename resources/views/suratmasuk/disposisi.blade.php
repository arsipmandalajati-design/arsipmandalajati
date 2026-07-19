@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.header-card{
    background:linear-gradient(135deg,#0f766e,#14b8a6,#2dd4bf);
    border-radius:20px;
    padding:30px;
    color:white;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}

.card-modern{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.form-control,
.form-select{
    border-radius:12px;
}

</style>

<div class="container-fluid">

    <div class="header-card">

        <h3 class="fw-bold">
            <i class="bi bi-send-check-fill"></i>
            Disposisi Surat
        </h3>

        <p class="mb-0">
            Kelola disposisi surat kepada pegawai.
        </p>

    </div>

    <div class="card card-modern">

        <div class="card-body">

            <form action="{{ route('suratmasuk.kirimDisposisi',$surat->id) }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Nomor Surat
                        </label>

                        <input
                        class="form-control"
                        value="{{ $surat->nomor_surat }}"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Tanggal Surat
                        </label>

                        <input
                        class="form-control"
                        value="{{ $surat->tanggal_surat }}"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Pengirim
                        </label>

                        <input
                        class="form-control"
                        value="{{ $surat->pengirim }}"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Status
                        </label>

                        <input
                        class="form-control"
                        value="{{ $surat->status }}"
                        readonly>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="fw-semibold">
                            Judul Surat
                        </label>

                        <input
                        class="form-control"
                        value="{{ $surat->judul }}"
                        readonly>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="fw-semibold">
                            Perihal
                        </label>

                        <textarea
                        class="form-control"
                        rows="4"
                        readonly>{{ $surat->perihal }}</textarea>

                    </div>

                    <hr>

                    {{-- ===================== ADMIN ===================== --}}
                    @if(Auth::user()->role == 'admin')

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Disposisikan Kepada
                        </label>

                        <select
                        name="user_disposisi_id"
                        class="form-select"
                        required>

                            <option value="">
                                -- Pilih Pegawai --
                            </option>

                            @foreach($users as $user)

                            <option
                            value="{{ $user->id }}"
                            {{ $surat->user_disposisi_id == $user->id ? 'selected' : '' }}>

                                {{ $user->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Catatan Admin
                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="Tambahkan catatan di bawah"
                        readonly>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="fw-semibold">
                            Catatan Admin
                        </label>

                        <textarea
                        name="catatan_admin"
                        rows="5"
                        class="form-control"
                        required>{{ old('catatan_admin',$surat->catatan_admin) }}</textarea>

                    </div>

                    <div class="text-end">

                        <a
                        href="{{ route('suratmasuk.index') }}"
                        class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Kembali

                        </a>

                        <button
                        type="submit"
                        class="btn btn-success">

                            <i class="bi bi-send-fill"></i>
                            Kirim Disposisi

                        </button>

                    </div>

                    {{-- ===================== PEGAWAI ===================== --}}
                    @else

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">
                            Pegawai Tujuan
                        </label>

                        <input
                        class="form-control"
                        value="{{ optional($surat->userDisposisi)->name ?? '-' }}"
                        readonly>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="fw-semibold">
                            Catatan Admin
                        </label>

                        <textarea
                        class="form-control"
                        rows="5"
                        readonly>{{ $surat->catatan_admin ?? '-' }}</textarea>

                    </div>

                    <div class="text-end">

                        <a
                        href="{{ route('suratmasuk.index') }}"
                        class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Kembali

                        </a>

                    </div>

                    @endif

                </div>

            </form>

        </div>

    </div>

</div>

@endsection