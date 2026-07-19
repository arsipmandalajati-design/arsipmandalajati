@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Laporan
@endsection

@section('page-description')
Kelola seluruh laporan Kecamatan Mandalajati.
@endsection

@section('content')


<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="running-box">

    <div class="d-flex align-items-center">

        <div class="icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>

        <div class="running-text">

            <span>

                📊 Gunakan menu Laporan untuk melihat rekap Surat Masuk, Surat Keluar, Arsip dan Agenda.

            </span>

        </div>

    </div>

</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('laporan.index') }}"
              method="GET">

            <div class="row">

                <!-- Jenis Laporan -->
                <div class="col-md-4 mb-3">

                    <label class="form-label fw-bold">
                        Jenis Laporan
                    </label>

                    <select name="jenis"
                            class="form-select">

                        <option value="semua">
                            Semua Data
                        </option>

                        <option value="suratmasuk">
                            Surat Masuk
                        </option>

                        <option value="suratkeluar">
                            Surat Keluar
                        </option>

                        <option value="arsip">
                            Data Arsip
                        </option>

                    </select>

                </div>

                <!-- Tanggal Awal -->
                <div class="col-md-3 mb-3">

                    <label class="form-label fw-bold">
                        Tanggal Awal
                    </label>

                    <input type="date"
                           name="tanggal_awal"
                           class="form-control">

                </div>

                <!-- Tanggal Akhir -->
                <div class="col-md-3 mb-3">

                    <label class="form-label fw-bold">
                        Tanggal Akhir
                    </label>

                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control">

                </div>

                <!-- Tombol -->
                <div class="col-md-2 mb-3 d-flex align-items-end">

                    <button type="submit"
                            class="btn btn-primary me-2">

                        <i class="bi bi-search"></i>

                    </button>

                    <a href="{{ route('laporan.index') }}"
                       class="btn btn-secondary me-2">

                        <i class="bi bi-arrow-clockwise"></i>

                    </a>

                    <a href="{{ route('laporan.print') }}"
                       target="_blank"
                       class="btn btn-danger">

                        <i class="bi bi-printer"></i>

                    </a>

                </div>

            </div>

        </form>

</div>

</div>

<!-- TAB LAPORAN -->
<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <ul class="nav nav-tabs mb-3">

            <li class="nav-item">
                <button class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#suratmasuk">

                    Surat Masuk

                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#suratkeluar">

                    Surat Keluar

                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#arsip">

                    Data Arsip

                </button>
            </li>

        </ul>

        <div class="tab-content">

            <!-- SURAT MASUK -->
            <div class="tab-pane fade show active"
                 id="suratmasuk">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Judul</th>
                            <th>Pengirim</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($suratMasuk as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->nomor_surat }}</td>

                            <td>{{ $item->judul }}</td>

                            <td>{{ $item->pengirim }}</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- SURAT KELUAR -->
            <div class="tab-pane fade"
                 id="suratkeluar">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Judul</th>
                            <th>Tujuan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($suratKeluar as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->nomor_surat }}</td>

                            <td>{{ $item->judul }}</td>

                            <td>{{ $item->tujuan }}</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- ARSIP -->
            <div class="tab-pane fade"
                 id="arsip">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Arsip</th>
                            <th>Nama Arsip</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($arsip as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->kode }}</td>

                            <td>{{ $item->nama_arsip }}</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection