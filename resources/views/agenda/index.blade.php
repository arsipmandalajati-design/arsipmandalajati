@extends('layouts.app')
@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Agenda Kegiatan
@endsection

@section('page-description')
Kelola seluruh agenda kegiatan di Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))

<script>
document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'success',

        title:'Berhasil',

        text:'{{ session("success") }}',

        confirmButtonColor:'#0f766e'

    });

});
</script>

@endif


@if(session('error'))

<script>
document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'error',

        title:'Gagal',

        text:'{{ session("error") }}',

        confirmButtonColor:'#dc3545'

    });

});
</script>

@endif


@if(session('booking_error'))

<script>
document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'warning',

        title:'Booking Gagal',

        text:'{{ session("booking_error") }}',

        confirmButtonColor:'#f59f00'

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

                📅 Jangan lupa memeriksa Agenda Kegiatan • Pastikan jadwal rapat maupun kegiatan telah sesuai.

            </span>

        </div>

    </div>

</div>

<!-- FILTER -->

<div class="card border-0 shadow-sm mb-4">

<div class="card-body">

<form method="GET">

<div class="row g-3">

<div class="col-md-3">

<label class="form-label fw-semibold">

Nama Kegiatan

</label>

<input
type="text"
name="nama_kegiatan"
class="form-control"
placeholder="Cari agenda..."
value="{{ request('nama_kegiatan') }}">

</div>



<div class="col-md-2">

<label class="form-label fw-semibold">

Status

</label>

<select
name="status"
class="form-select">

<option value="">

Semua

</option>

<option value="Terjadwal"
@if(request('status')=="Terjadwal")
selected
@endif>

Terjadwal

</option>

<option value="Selesai"
@if(request('status')=="Selesai")
selected
@endif>

Selesai

</option>

<option value="Ditunda"
@if(request('status')=="Ditunda")
selected
@endif>

Ditunda

</option>

</select>

</div>



<div class="col-md-2">

<label class="form-label fw-semibold">

Tanggal Awal

</label>

<input
type="date"
name="tanggal_awal"
class="form-control"
value="{{ request('tanggal_awal') }}">

</div>



<div class="col-md-2">

<label class="form-label fw-semibold">

Tanggal Akhir

</label>

<input
type="date"
name="tanggal_akhir"
class="form-control"
value="{{ request('tanggal_akhir') }}">

</div>
<div class="col-md-3 d-flex align-items-end">

    <button class="btn btn-primary me-2">

        <i class="bi bi-search"></i>

    </button>

    <a href="{{ route('agenda.index') }}"
       class="btn btn-secondary me-2">

        <i class="bi bi-arrow-clockwise"></i>

    </a>

    @if(Auth::user()->role == 'admin')

        <span class="badge bg-success px-3 py-2">

            <i class="bi bi-shield-check"></i>

            Administrator

        </span>

    @endif


    <a href="{{ route('agenda.print') }}"
       target="_blank"
       class="btn btn-danger ms-2">

        <i class="bi bi-printer-fill"></i>

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

                        <th>No</th>
                        
                        <th>Surat</th>
                        
                        <th>Nama Kegiatan</th>
                        
                        <th>Tanggal</th>
                        
                        <th>Waktu</th>
                        
                        <th>Tempat</th>
                        
                        <th>Penyelenggara</th>
                        
                        <th>Status</th>
                        
                        <th>Aksi</th>
                        
                        </tr>
                </thead>

                <tbody>

                    @forelse($agenda as $item)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            @if($item->suratMasuk)
                        
                                <strong>
                                    {{ $item->suratMasuk->nomor_surat }}
                                </strong>
                        
                                <br>
                        
                                <small class="text-muted">
                                    {{ $item->suratMasuk->judul }}
                                </small>
                        
                            @else
                        
                                <span class="text-danger">
                                    Surat tidak ditemukan
                                </span>
                        
                            @endif
                        
                        </td>

                        <td>

                        {{ $item->nama_kegiatan }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

                        </td>

                        <td>

                            {{ $item->jam_mulai }}

                            -

                            {{ $item->jam_selesai }}

                        </td>

                        <td>

                            {{ $item->tempat }}

                        </td>

                        <td>

                            {{ $item->penyelenggara }}

                        </td>
                        <td>

                            @if($item->status == 'Terjadwal')
                            
                            <span class="status-badge status-terjadwal">
                                {{ $item->status }}
                            </span>
                            
                            @elseif($item->status == 'Diproses')
                            
                            <span class="status-badge status-diproses">
                                {{ $item->status }}
                            </span>
                            
                            @elseif($item->status == 'Selesai')
                            
                            <span class="status-badge status-selesai">
                                {{ $item->status }}
                            </span>
                            
                            @elseif($item->status == 'Ditunda')
                            
                            <span class="status-badge status-ditunda">
                                {{ $item->status }}
                            </span>
                            
                            @elseif($item->status == 'Dibatalkan')
                            
                            <span class="status-badge status-batal">
                                {{ $item->status }}
                            </span>
                            
                            @else
                            
                            <span class="status-badge bg-secondary">
                                {{ $item->status }}
                            </span>
                            
                            @endif
                            
                            </td>
                        
                        <td class="text-center">

                            {{-- Detail Surat --}}
                            @if($item->surat_masuk_id)

                                <a href="{{ route('suratmasuk.show', $item->surat_masuk_id) }}"
                                class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @else

                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-eye"></i>
                                </button>

                                @endif
                            
                            <a href="{{ route('agenda.whatsapp',$item->id) }}"
                                class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            
                            <a href="{{ route('agenda.edit',$item->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            <a href="{{ route('agenda.hasil',$item->id) }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-journal-check"></i>
                            </a>

                            {{-- Hapus Agenda --}}
                            <form action="{{ url('agenda/'.$item->id) }}"
                                  method="POST"
                                  style="display:inline">
                        
                                @csrf
                                @method('DELETE')
                        
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus agenda?')">
                        
                                    <i class="bi bi-trash"></i>
                        
                                </button>
                        
                            </form>
                        
                        </td>

                        @empty
                        
                        <tr>
                        
                            <td colspan="8" class="text-center py-4">
                        
                                <i class="bi bi-calendar-x fs-3"></i>
                        
                                <br>
                        
                                Belum ada data agenda
                        
                            </td>
                        
                        </tr>
                        
                        @endforelse
                        
                        </tbody>
                        
                        </table>
                        
                        </div>
                        
                        </div>
                        
                        </div>
                        
                        @endsection