@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Data Pejabat
@endsection

@section('page-description')
Kelola seluruh data pejabat Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon:'success',
        title:'Berhasil',
        text:'{{ session('success') }}',
        confirmButtonColor:'#2563eb'
    });
});
</script>
@endif

<div class="running-box">

    <div class="d-flex align-items-center">

        <div class="icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>

        <div class="running-text">

            <span>

                🏢 Kelola Data Pejabat Kecamatan Mandalajati agar informasi penanggung jawab selalu diperbarui.

            </span>

        </div>

    </div>

</div>

<!-- FILTER -->
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-5">

                    <label class="form-label fw-bold">
                        Nama Pejabat
                    </label>

                    <input type="text"
                    class="form-control"
                    name="nama_pejabat"
                    value="{{ request('nama_pejabat') }}"
                    placeholder="Cari nama pejabat">

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

                <div class="col-md-2 d-flex align-items-end">

                    <!-- Cari -->
                    <button class="btn btn-primary rounded-circle"
                    type="submit"
                    style="width:50px;height:50px">

                <i class="bi bi-search"></i>

            </button>

            <!-- Reset -->
            <a href="{{ route('pejabat.index') }}"
               class="btn btn-secondary rounded-circle"
               style="width:50px;height:50px">

                <i class="bi bi-arrow-clockwise"></i>

            </a>

            <!-- Tambah -->
            <a href="{{ route('pejabat.create') }}"
               class="btn btn-success rounded-circle"
               style="width:50px;height:50px">

                <i class="bi bi-plus-lg"></i>

            </a>
                </div>

            </div>

        </form>

    </div>

</div>

<!-- TABLE -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>
                        <th>Nama Pejabat</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Tanda Tangan</th>
                        <th width="140">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pejabats as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nama_pejabat }}</td>

                        <td>{{ $item->nip }}</td>

                        <td>{{ $item->jabatan }}</td>

                        <td>

                            @if($item->tanda_tangan)

                                <img src="{{ asset('storage/'.$item->tanda_tangan) }}"
                                width="120"
                                class="rounded border shadow-sm">

                            @else

                                <span class="badge bg-secondary">
                                    Belum Upload
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('pejabat.edit',$item->id) }}"
                            class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <form action="{{ route('pejabat.destroy',$item->id) }}"
                            method="POST"
                            style="display:inline">

                                @csrf
                                @method('DELETE')

                                <button
                                onclick="return confirm('Hapus data ini?')"
                                class="btn btn-danger btn-sm">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                        class="text-center text-muted">

                            Belum ada data pejabat.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection