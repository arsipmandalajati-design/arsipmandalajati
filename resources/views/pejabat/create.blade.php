@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Tambah Data Pejabat
@endsection

@section('page-description')
Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- FORM -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('pejabat.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">

                        Nama Pejabat

                    </label>

                    <input
                        type="text"
                        name="nama_pejabat"
                        class="form-control"
                        value="{{ old('nama_pejabat') }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">

                        NIP

                    </label>

                    <input
                        type="text"
                        name="nip"
                        class="form-control"
                        value="{{ old('nip') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jabatan
                    </label>
                
                    <select name="jabatan"
                            class="form-select"
                            required>
                
                        <option value="">
                            -- Pilih Jabatan --
                        </option>
                
                        <option value="Camat">Camat</option>
                
                        <option value="Kasubag Umum">
                            Kasubag Umum
                        </option>
                    </select>
                    
                </div>
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                
                        Upload Tanda Tangan
                
                    </label>
                
                    <input
                        type="file"
                        name="tanda_tangan"
                        class="form-control">
                
                </div>
            </div>

            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <a href="{{ route('pejabat.index') }}"
                class="btn btn-secondary">
                
                <i class="bi bi-arrow-left"></i>
                
                Kembali
                
                </a>

            </div>

        </form>

    </div>

</div>

@endsection