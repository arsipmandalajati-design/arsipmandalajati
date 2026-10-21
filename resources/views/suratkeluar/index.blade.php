@extends('layouts.app')

@section('page-icon')
<i class="bi bi-send-fill"></i>
@endsection

@section('page-title')
Surat Keluar
@endsection

@section('page-description')
Kelola seluruh arsip data surat keluar di Kecamatan Mandalajati.
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.filter-group{
    position:relative;
}
.filter-label{
    position:absolute;
    top:-10px;
    left:15px;
    background:white;
    padding:0 8px;
    font-size:14px;
    font-weight:600;
    color:#111827;
    z-index:10;
}
.form-filter{
    height:55px;
    border:2px solid #22c1dc!important;
    border-radius:14px!important;
    background:#eaf9fb!important;
    box-shadow:none!important;
}
.form-filter:focus{
    border-color:#22c1dc!important;
    background:#eaf9fb!important;
    box-shadow:none!important;
}
.table{
    border-collapse:separate;
    border-spacing:0 10px;
}
.table tbody tr{
    background:white;
    box-shadow:0 3px 10px rgba(0,0,0,.05);
    transition:.3s;
}
.table tbody tr:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(0,0,0,.08);
}
.table td{
    vertical-align:middle;
}
.badge{
    padding:8px 12px;
    font-size:12px;
    border-radius:30px;
}
.page-header{
    border-radius:24px;
    overflow:hidden;
    position:relative;
    color:#fff;
    padding:30px;
    margin-bottom:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}
.page-header::before{
    content:"";
    position:absolute;
    width:170px;
    height:170px;
    right:-35px;
    top:-45px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}
.page-header::after{
    content:"";
    position:absolute;
    width:90px;
    height:90px;
    left:-20px;
    bottom:-20px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}
.btn-action{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
}
</style>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded',function(){
    Swal.fire({
        icon:'success',
        title:'Berhasil',
        text:'{{ session("success") }}',
        confirmButtonText:'OK'
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
        confirmButtonText:'OK'
    });
});
</script>
@endif

<div class="running-box mb-4">
    <div class="d-flex align-items-center">
        <div class="icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <div class="running-text">
            <span>
                📤 Kelola Surat Keluar dengan mudah • Pastikan seluruh data arsip surat keluar tercatat dengan akurat dan rapi.
            </span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('suratkeluar.index') }}" method="GET">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-funnel-fill text-primary"></i> Filter Pencarian Surat Keluar
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Pencarian</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nomor surat / tujuan / perihal..." value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="row align-items-end">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                                <a href="{{ route('suratkeluar.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>

                                @if(Auth::check())
                <a href="{{ route('suratkeluar.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Surat Keluar
                </a>
            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Tujuan Surat</th>
                        <th>Perihal / Judul</th>
                        <th>File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKeluars as $index => $item)
                    <tr>
                        <td>{{ $suratKeluars->firstItem() + $index }}</td>
                        <td>
                            <span class="fw-bold text-dark">{{ $item->nomor_surat }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d M Y') }}</td>
                        <td>{{ $item->tujuan }}</td>
                        <td>
                            {{-- Menampilkan Judul dan Perihal dengan aman --}}
                            <div class="fw-bold text-dark">{{ $item->judul ?? '-' }}</div>
                            <small class="text-muted">{{ $item->perihal ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            @if($item->file_surat)
                                <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill px-3" title="Lihat File PDF">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat
                                </a>
                            @else
                                <span class="badge bg-secondary">Tidak ada file</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- Tombol Detail memicu Modal --}}
                                    <button type="button" class="btn btn-sm btn-info text-white" title="Detail Surat" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalDetail{{ $item->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                {{-- Tombol Disposisi --}}
                                <a href="{{ route('suratkeluar.disposisi', $item->id) }}" class="btn btn-sm btn-warning text-white" title="Disposisi Surat">
                                    <i class="bi bi-send-fill"></i>
                                </a>
                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('suratkeluar.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit Surat">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('suratkeluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data surat keluar ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Surat">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data surat keluar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($suratKeluars as $item)
<!-- Modal Detail Surat Keluar -->
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            
            {{-- Header Modal --}}
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #003844, #0f766e);">
                <h5 class="modal-title fw-bold" id="modalDetailLabel{{ $item->id }}">
                    <i class="bi bi-file-earmark-text-fill me-2"></i> Detail Surat Keluar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body Modal --}}
            <div class="modal-body p-4">
                <div class="row">
                    {{-- Informasi Detail Teks --}}
                    <div class="col-md-6 mb-3 mb-md-0 border-end">
                        <div class="mb-3">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Kode Arsip</span>
                            <span class="badge bg-success bg-opacity-15 text-success px-3 py-2 rounded-pill fw-bold">
                                {{ $item->kodearsip->kode ?? '-' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Nomor Surat</span>
                            <strong class="text-dark">{{ $item->nomor_surat }}</strong>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Judul Surat</span>
                            <span class="text-dark">{{ $item->judul ?? '-' }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Tujuan</span>
                            <span class="text-dark">{{ $item->tujuan }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Tanggal Surat</span>
                            <span class="text-dark">{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}</span>
                        </div>

                        <div class="mb-0">
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: .5px;">Perihal</span>
                            <span class="text-dark">{{ $item->perihal ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Bagian Preview / File PDF --}}
                    <div class="col-md-6 d-flex flex-column justify-content-between">
                        <div>
                            <span class="d-block text-muted text-uppercase fw-bold mb-2" style="font-size: 11px; letter-spacing: .5px;">File Dokumen</span>
                            @if($item->file_surat)
                                <div class="border rounded-3 overflow-hidden mb-3 shadow-sm" style="height: 250px;">
                                    <iframe src="{{ asset('storage/' . $item->file_surat) }}" width="100%" height="100%" frameborder="0"></iframe>
                                </div>
                            @else
                                <div class="text-center py-4 bg-light rounded-3 mb-3">
                                    <i class="bi bi-file-earmark-x text-danger fs-1"></i>
                                    <p class="text-muted small mb-0 mt-2">File dokumen belum diunggah.</p>
                                </div>
                            @endif
                        </div>

                        @if($item->file_surat)
                            <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank" class="btn btn-sm btn-success w-100 rounded-pill">
                                <i class="bi bi-download me-1"></i> Buka / Download PDF Full
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-preview').on('click', function() {
        const nomor = $(this).data('nomor');
        const tujuan = $(this).data('tujuan');
        const tanggal = $(this).data('tanggal');
        const perihal = $(this).data('perihal');
        const keterangan = $(this).data('keterangan');
        const fileUrl = $(this).data('file');

        $('#md-nomor').text(nomor);
        $('#md-tujuan').text(tujuan);
        $('#md-tanggal').text(tanggal);
        $('#md-perihal').text(perihal);
        $('#md-keterangan').text(keterangan);

        if (fileUrl && fileUrl !== '' && fileUrl !== '#') {
            $('#md-pdf-viewer').removeClass('d-none').attr('src', fileUrl);
            $('#md-file-fallback').addClass('d-none');
            $('#md-download-btn').attr('href', fileUrl);
            $('#md-direct-download').attr('href', fileUrl).removeClass('d-none');
        } else {
            $('#md-pdf-viewer').addClass('d-none').attr('src', '');
            $('#md-file-fallback').removeClass('d-none');
            $('#md-download-btn').attr('href', '#');
            $('#md-direct-download').addClass('d-none');
        }
    });

    $('#previewModalSuratKeluar').on('hidden.bs.modal', function () {
        $('#md-pdf-viewer').attr('src', '');
    });
});
</script>
@endsection