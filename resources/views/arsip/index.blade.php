@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Data Arsip
@endsection

@section('page-description')
Kelola seluruh data arsip Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK'
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
                📂 Arsip Digital memudahkan pencarian dokumen • Simpan seluruh dokumen secara aman dan terstruktur.
            </span>

        </div>

    </div>

</div>
<!-- FILTER -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label fw-bold">
                        Kode Arsip
                    </label>

                    <input type="text"
                           name="kode_arsip"
                           class="form-control"
                           placeholder="Cari Kode Arsip">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label fw-bold">
                        Nama Arsip
                    </label>

                    <input type="text"
                           name="nama_arsip"
                           class="form-control"
                           placeholder="Cari Nama Arsip">

                </div>

                <div class="col-md-4 mb-3 d-flex align-items-end">

                    <button type="submit"
                            class="btn btn-primary me-2">

                        <i class="bi bi-search"></i>

                    </button>

                    <a href="{{ route('arsip.index') }}"
                       class="btn btn-secondary me-2">

                        <i class="bi bi-arrow-clockwise"></i>

                    </a>
                    <!-- Tambah -->
                    <a href="{{ route('arsip.create') }}"
                    class="btn btn-success rounded-circle">

                    <i class="bi bi-plus-lg"></i>

                    </a>
                </div>

            </div>

        </form>

    </div>

</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>
                        <th>Kode Arsip</th>
                        <th>Nama Arsip</th>
                        <th>Total Surat</th>
                        <th width="130">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($kodearsip as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>{{ $item->kode }}</td>

                        <td>{{ $item->nama_arsip }}</td>

                        <td>
                            <span class="badge bg-primary">
                        
                                {{
                                    $item->suratMasuk->count()
                                    +
                                    $item->suratKeluar->count()
                                }}
                        
                                Surat
                        
                            </span>
                        </td>

                        <td>

                            <a href="{{ route('arsip.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <form action="{{ route('arsip.destroy',$item->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            Belum ada data arsip

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection