@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-fill"></i>
@endsection

@section('page-title')
Surat Masuk
@endsection

@section('page-description')
Kelola seluruh surat masuk Kecamatan Mandalajati.
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

<div class="running-box mb-4">
    <div class="d-flex align-items-center">
        <div class="icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <div class="running-text">
            <span>
                📥 Kelola Surat Masuk dengan mudah • Pastikan seluruh surat telah diverifikasi dan didisposisikan kepada pegawai yang bersangkutan.
            </span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('suratmasuk.index') }}" method="GET">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif

            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-funnel-fill text-primary"></i> Filter Pencarian Surat
                    </h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="fw-semibold">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-semibold">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-semibold">Kode Arsip</label>
                            <input type="text" name="kode_arsip" class="form-control" placeholder="Cari kode arsip..." value="{{ request('kode_arsip') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="fw-semibold">Perihal</label>
                            <input type="text" name="perihal" class="form-control" placeholder="Cari perihal..." value="{{ request('perihal') }}">
                        </div>
                    </div>
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="fw-semibold">Status Surat</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Menunggu Verifikasi" {{ request('status')=='Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="Sudah Diverifikasi" {{ request('status')=='Sudah Diverifikasi' ? 'selected' : '' }}>Sudah Diverifikasi</option>
                                <option value="Sudah Disposisi" {{ request('status')=='Sudah Disposisi' ? 'selected' : '' }}>Sudah Disposisi</option>
                                <option value="Sudah Dijadikan Agenda" {{ request('status')=='Sudah Dijadikan Agenda' ? 'selected' : '' }}>Sudah Dijadikan Agenda</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                                <a href="{{ route('suratmasuk.index', request('type') ? ['type' => request('type')] : []) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>

                                {{-- Tombol Tambah, sekarang ikut switch "tambah" --}}
                                @if(userCan('suratmasuk', 'tambah'))
                                    <a href="{{ route('suratmasuk.create') }}" class="btn btn-primary">
                                        @if(request('type') == 'agenda')
                                            <i class="bi bi-calendar-plus"></i> Tambah Agenda
                                        @else
                                            <i class="bi bi-plus-circle"></i> Tambah Surat Masuk
                                        @endif
                                    </a>
                                @endif

                                <a href="{{ route('suratmasuk.print') }}" class="btn btn-danger">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Kode Arsip</th>
                <th>Nomor Surat</th>
                <th>Judul Surat</th>
                @if(request('type') == 'agenda')
                    <th>Tempat Booking</th>
                    <th>Jadwal Kegiatan</th>
                @else
                    <th>Asal Surat</th>
                    <th>Tanggal</th>
                @endif
                <th>Status</th>
                <th>Tujuan Disposisi</th>
                <th>File</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratmasuk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    
                    {{-- KODE ARSIP --}}
                    <td>
                        <span class="badge bg-dark">{{ $item->kodearsip->kode ?? '-' }}</span>
                    </td>
                    
                    {{-- NOMOR SURAT --}}
                    <td>
                        <small class="fw-bold text-primary">{{ $item->nomor_surat }}</small>
                    </td>
                    
                    {{-- JUDUL --}}
                    <td>
                        <strong>{{ $item->judul }}</strong>
                        <br>
                        <small class="text-muted">{{ Str::limit($item->perihal, 40) }}</small>
                    </td>
                    
                    {{-- KOLOM CONDITIONAL (SURAT VS AGENDA) --}}
                    @if(request('type') == 'agenda')
                        <td>
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $item->tempat ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <small class="fw-bold d-block text-dark">
                                <i class="bi bi-calendar-event me-1"></i> {{ $item->tanggal_kegiatan ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') : '-' }}
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-clock me-1"></i> {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '' }} - {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '' }}
                            </small>
                        </td>
                    @else
                        <td>
                            <i class="bi bi-building"></i> {{ $item->pengirim }}
                        </td>
                        <td>
                            {{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') : '-' }}
                        </td>
                    @endif
                    
                    {{-- STATUS --}}
                    <td>
                        @if($item->status == 'Belum Disposisi')
                            <span class="badge bg-secondary">Belum Disposisi</span>
                        @elseif($item->status == 'Diproses')
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @elseif($item->status == 'Sudah Disposisi')
                            <span class="badge bg-success">Sudah Disposisi</span>
                        @elseif($item->status == 'Sudah Dijadikan Agenda')
                            <span class="badge bg-primary">Sudah Dijadikan Agenda</span>
                        @else
                            <span class="badge bg-secondary">{{ $item->status }}</span>
                        @endif
                    </td>
                    
                    {{-- TUJUAN DISPOSISI --}}
                    <td>
                        @if($item->userDisposisi)
                            <span class="badge bg-secondary">{{ $item->userDisposisi->name }}</span>
                        @else
                            -
                        @endif
                    </td>
                    
                    {{-- FILE --}}
                    <td>
                        @if($item->file_surat)
                            <a href="{{ asset('storage/'.$item->file_surat) }}" target="_blank" class="btn btn-info btn-sm text-white" title="Lihat File">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </a>
                        @else
                            <span class="text-danger small">Belum Ada</span>
                        @endif
                    </td>
                    
                    {{-- AKSI --}}
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">

                            @if(userCan('suratmasuk', 'lihat'))
                                <button type="button" 
                                        class="btn btn-info btn-sm text-white btn-preview" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#previewModalSuratMasuk"
                                        data-kode="{{ $item->kodearsip->kode ?? '-' }}"
                                        data-nomor="{{ $item->nomor_surat }}"
                                        data-judul="{{ $item->judul }}"
                                        data-pengirim="{{ $item->pengirim }}"
                                        data-tanggal="{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') : '-' }}"
                                        data-status="{{ $item->status }}"
                                        data-perihal="{{ $item->perihal }}"
                                        data-file="{{ $item->file_surat ? asset('storage/' . str_replace('public/', '', $item->file_surat)) : '' }}"
                                        title="Detail & Preview Surat">
                                    <i class="bi bi-eye"></i>
                                </button>
                            @endif

                            @if(userCan('suratmasuk', 'disposisi'))
                                <a href="{{ route('suratmasuk.disposisi', $item->id) }}" class="btn btn-primary btn-sm" title="Kirim Disposisi">
                                    <i class="bi bi-send-fill"></i>
                                </a>
                            @endif

                            @if(userCan('suratmasuk', 'ubah'))
                                <a href="{{ route('suratmasuk.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit Surat">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif

                            {{-- HAPUS — sekarang ikut switch "hapus" di Akses Role, bukan hardcode role admin lagi --}}
                            @if(userCan('suratmasuk', 'hapus'))
                                <form action="{{ route('suratmasuk.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus surat masuk ini? Semua data terkait juga akan dihapus.');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm rounded-3"
                                            title="Hapus Surat">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>

                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-secondary"></i>
                        <br><br>
                        <strong>
                            {{ request('type') == 'agenda' ? 'Belum ada agenda kegiatan terdaftar.' : 'Belum ada data surat masuk.' }}
                        </strong>
                        <br>
                        <small class="text-muted">
                            {{ request('type') == 'agenda' ? 'Jadwal agenda akan muncul setelah surat internal dimasukkan.' : 'Silakan tambahkan surat masuk terlebih dahulu.' }}
                        </small>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
</div>

<!-- MODAL DETAIL & PREVIEW DOKUMEN -->
<div class="modal fade" id="previewModalSuratMasuk" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="previewModalLabel">
                    <i class="bi bi-envelope-open-fill me-2"></i> Detail & Preview Surat Masuk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i> Informasi Surat
                            </h5>
                            
                            <div class="row g-2" style="font-size: 0.95rem;">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td class="fw-bold text-muted" style="width: 35%;">Kode Arsip</td>
                                            <td style="width: 5%;">:</td>
                                            <td><span id="md-kode" class="badge bg-dark"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">No. Surat</td>
                                            <td>:</td>
                                            <td><span id="md-nomor" class="text-primary fw-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Judul Surat</td>
                                            <td>:</td>
                                            <td><span id="md-judul" class="fw-bold text-dark"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td class="fw-bold text-muted" style="width: 35%;">Asal Surat</td>
                                            <td style="width: 5%;">:</td>
                                            <td><span id="md-pengirim" class="text-dark"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Tgl. Surat</td>
                                            <td>:</td>
                                            <td><span id="md-tanggal" class="text-dark"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Status</td>
                                            <td>:</td>
                                            <td><span id="md-status" class="badge"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="fw-bold text-muted mb-1 small text-uppercase">Perihal / Ringkasan:</label>
                                <div class="p-3 border rounded bg-white text-dark shadow-inner" id="md-perihal" style="min-height: 70px; max-height: 120px; overflow-y: auto; font-size: 0.9rem;"></div>
                            </div>
                        </div>
                    </div>
                    
                   <div class="col-12">
                        <div class="card shadow-sm border-0 bg-dark rounded-3 overflow-hidden">
                            <div class="card-header bg-secondary bg-opacity-25 text-white py-2 px-3 d-flex justify-content-between align-items-center">
                                <span class="small fw-bold">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Preview Lampiran Berkas
                                </span>
                                <a id="md-direct-download" href="#" target="_blank" class="btn btn-sm btn-outline-light d-none" title="Buka / Download di tab baru">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tab Baru
                                </a>
                            </div>
                            <div class="card-body p-0 position-relative" style="height: 550px;">
                                <iframe id="md-pdf-viewer" src="" width="100%" height="100%" style="border: none; background: #fff;"></iframe>
                                
                                <div id="md-file-fallback" class="text-center position-absolute top-50 start-50 translate-middle d-none p-4 text-white w-100">
                                    <i class="bi bi-file-earmark-x fs-1 text-danger"></i>
                                    <p class="mt-2 text-light mb-2">Berkas tidak dilampirkan atau format tidak mendukung preview langsung.</p>
                                    <a id="md-download-btn" href="#" target="_blank" class="btn btn-light btn-sm fw-bold shadow d-none">
                                        <i class="bi bi-download me-1"></i> Unduh Berkas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-0 py-3 px-4">
                <button type="button" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal" style="border-radius:10px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-preview').on('click', function() {
        const kode = $(this).data('kode');
        const nomor = $(this).data('nomor');
        const judul = $(this).data('judul');
        const pengirim = $(this).data('pengirim');
        const tanggal = $(this).data('tanggal');
        const status = $(this).data('status');
        const perihal = $(this).data('perihal');
        const fileUrl = $(this).data('file');

        $('#md-kode').text(kode);
        $('#md-nomor').text(nomor);
        $('#md-judul').text(judul);
        $('#md-pengirim').text(pengirim);
        $('#md-tanggal').text(tanggal);
        $('#md-perihal').text(perihal);
        $('#md-status').text(status);

        $('#md-status').removeClass('bg-secondary bg-warning text-dark bg-success bg-primary');
        if(status === 'Sudah Disposisi') {
            $('#md-status').addClass('bg-success text-white');
        } else if(status === 'Diproses' || status === 'Menunggu Verifikasi') {
            $('#md-status').addClass('bg-warning text-dark');
        } else if(status === 'Sudah Dijadikan Agenda') {
            $('#md-status').addClass('bg-primary text-white');
        } else {
            $('#md-status').addClass('bg-secondary text-white');
        }

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

    $('#previewModalSuratMasuk').on('hidden.bs.modal', function () {
        $('#md-pdf-viewer').attr('src', '');
    });

    function cekBooking(){
        let tempat = $("#tempat").val();
        let tanggal = $("#tanggal").val();
        let mulai = $("#jam_mulai").val();
        let selesai = $("#jam_selesai").val();
    
        if(!tempat || !tanggal || !mulai || !selesai){
            return;
        }
    
        $.get("{{ route('agenda.cekBooking') }}", {
            tempat: tempat,
            tanggal: tanggal,
            jam_mulai: mulai,
            jam_selesai: selesai
        })
        .done(function(res){
            $('.alert-verification-jadwal').remove(); 

            if(res.bentrok){
                Swal.fire({
                    icon: 'warning',
                    title: 'Jadwal Bentrok',
                    text: 'Ruangan sudah dipakai pada jam tersebut.',
                    confirmButtonColor: '#dc3545'
                });
                $(".btn-save").prop("disabled", true);
            } else {
                $(".btn-save").prop("disabled", false);
            }
        })
        .fail(function(xhr, status, error){
            console.error("Gagal memverifikasi jadwal otomatis:", error);
            $(".btn-save").prop("disabled", false);
        });
    }
    
    $("#tempat, #tanggal_kegiatan, #jam_mulai, #jam_selesai").on("change", cekBooking);
});
</script>
@endsection