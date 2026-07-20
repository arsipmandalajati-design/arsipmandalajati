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

<div class="running-box">
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
                                <button class="btn btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                                <a href="{{ route('suratmasuk.index', request('type') ? ['type' => request('type')] : []) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>

                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'pegawai')
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
                                <small class="text-muted">{{ Str::limit($item->perihal,40) }}</small>
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
                                    {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
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
                                    <span class="text-danger">Belum Ada</span>
                                @endif
                            </td>
                            
                            {{-- AKSI --}}
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    {{-- ================= ADMIN (LIHAT, DISPOSISI, EDIT, & HAPUS) ================= --}}
                                    @if(Auth::user()->role == 'admin')
                                        {{-- Tombol Detail memicu Modal --}}
                                        <button type="button" 
                                                class="btn btn-info btn-sm text-white btn-preview" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#previewModalSuratMasuk"
                                                data-kode="{{ $item->kodearsip->kode ?? '-' }}"
                                                data-nomor="{{ $item->nomor_surat }}"
                                                data-judul="{{ $item->judul }}"
                                                data-pengirim="{{ $item->pengirim }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}"
                                                data-status="{{ $item->status }}"
                                                data-perihal="{{ $item->perihal }}"
                                                data-file="{{ $item->file_surat ? asset('storage/' . $item->file_surat) : '' }}"
                                                title="Detail & Preview Surat">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <a href="{{ route('suratmasuk.disposisi', $item->id) }}" class="btn btn-primary btn-sm" title="Kirim Disposisi">
                                            <i class="bi bi-send-fill"></i>
                                        </a>

                                        <a href="{{ route('suratmasuk.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit Surat">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('suratmasuk.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    {{-- ================= PEGAWAI (HANYA LIHAT DAN EDIT) ================= --}}
                                    @elseif(Auth::user()->role == 'pegawai')
                                        {{-- Tombol Detail memicu Modal --}}
                                        <button type="button" 
                                                class="btn btn-info btn-sm text-white btn-preview" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#previewModalSuratMasuk"
                                                data-kode="{{ $item->kodearsip->kode ?? '-' }}"
                                                data-nomor="{{ $item->nomor_surat }}"
                                                data-judul="{{ $item->judul }}"
                                                data-pengirim="{{ $item->pengirim }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}"
                                                data-status="{{ $item->status }}"
                                                data-perihal="{{ $item->perihal }}"
                                                data-file="{{ $item->file_surat ? asset('storage/' . $item->file_surat) : '' }}"
                                                title="Detail & Preview Surat">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <a href="{{ route('suratmasuk.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit Surat">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
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

<!-- MODAL DETAIL SEJAJAR & PREVIEW DOKUMEN -->
<div class="modal fade" id="previewModalSuratMasuk" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 90%;">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="previewModalLabel">
                    <i class="bi bi-envelope-open-fill me-2"></i> Detail & Preview Surat Masuk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- SISI KIRI: Detail Informasi Sejajar -->
                    <div class="col-lg-5">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-primary"></i> Informasi Surat</h5>
                        <div class="card shadow-sm border-0 bg-light p-3" style="border-radius: 15px;">
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">Kode Arsip</div>
                                <div class="col-sm-8">: <span id="md-kode" class="badge bg-dark"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">No. Surat</div>
                                <div class="col-sm-8">: <span id="md-nomor" class="text-primary fw-bold"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">Judul Surat</div>
                                <div class="col-sm-8">: <span id="md-judul" class="fw-bold"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">Asal Surat</div>
                                <div class="col-sm-8">: <span id="md-pengirim"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">Tanggal Surat</div>
                                <div class="col-sm-8">: <span id="md-tanggal"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 fw-bold text-muted">Status</div>
                                <div class="col-sm-8">: <span id="md-status" class="badge"></span></div>
                            </div>
                            <hr>
                            <div class="form-group mb-0">
                                <label class="fw-bold text-muted mb-1">Perihal / Ringkasan:</label>
                                <div class="p-2 border rounded bg-white" id="md-perihal" style="min-height: 100px; max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SISI KANAN: Preview Dokumen PDF / Gambar -->
                    <div class="col-lg-7 mt-4 mt-lg-0">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-pdf-fill text-danger"></i> Preview Lampiran</h5>
                        <div class="card shadow-sm border-0 bg-dark rounded-3" style="height: 520px; overflow: hidden;">
                            <iframe id="md-pdf-viewer" src="" width="100%" height="100%" style="border: none;"></iframe>
                            <div id="md-file-fallback" class="text-center my-auto d-none p-4 text-white">
                                <i class="bi bi-file-earmark-x fs-1 text-danger"></i>
                                <p class="mt-2">Format tidak didukung preview instan atau berkas tidak tersedia.</p>
                                <a id="md-download-btn" href="#" target="_blank" class="btn btn-light btn-sm fw-bold mt-2">
                                    <i class="bi bi-download"></i> Unduh File
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius:10px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // ==========================================
    // 1. HANDLER MODAL PREVIEW (SURAT MASUK)
    // ==========================================
    $('.btn-preview').on('click', function() {
        const kode = $(this).data('kode');
        const nomor = $(this).data('nomor');
        const judul = $(this).data('judul');
        const pengirim = $(this).data('pengirim');
        const tanggal = $(this).data('tanggal');
        const status = $(this).data('status');
        const perihal = $(this).data('perihal');
        const fileUrl = $(this).data('file');

        // Injeksikan data ke elemen modal
        $('#md-kode').text(kode);
        $('#md-nomor').text(nomor);
        $('#md-judul').text(judul);
        $('#md-pengirim').text(pengirim);
        $('#md-tanggal').text(tanggal);
        $('#md-perihal').text(perihal);
        $('#md-status').text(status);

        // Styling dinamis badge status di dalam modal
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

        // Kontrol tampilan preview berkas
        if (fileUrl && (fileUrl.toLowerCase().endsWith('.pdf') || fileUrl.match(/\.(jpeg|jpg|gif|png)$/i) != null)) {
            $('#md-pdf-viewer').removeClass('d-none').attr('src', fileUrl);
            $('#md-file-fallback').addClass('d-none');
        } else {
            $('#md-pdf-viewer').addClass('d-none').attr('src', '');
            $('#md-file-fallback').removeClass('d-none');
            $('#md-download-btn').attr('href', fileUrl || '#');
        }
    });

    // Reset iframe saat modal ditutup agar ringkas memory browser
    $('#previewModalSuratMasuk').on('hidden.bs.modal', function () {
        $('#md-pdf-viewer').attr('src', '');
    });

    // ==========================================
    // 2. FUNGSI CEK BOOKING JADWAL (AGENDA)
    // ==========================================
    function cekBooking(){
        let tempat = $("#tempat").val();
        let tanggal = $("#tanggal").val();
        let mulai = $("#jam_mulai").val();
        let selesai = $("#jam_selesai").val();
    
        // Jika form booking belum terisi semua, abaikan pengecekan
        if(!tempat || !tanggal || !mulai || !selesai){
            return;
        }
    
        // Ajax request ke route pengecekan agenda
        $.get("{{ route('agenda.cekBooking') }}", {
            tempat: tempat,
            tanggal: tanggal,
            jam_mulai: mulai,
            jam_selesai: selesai
        })
        .done(function(res){
            // Hapus pesan error/warning penunjang jika ada dari request sebelumnya
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
            // Jangan memblokir form simpan surat jika server-side check mengalami sedikit gangguan internal
            console.error("Gagal memverifikasi jadwal otomatis:", error);
            $(".btn-save").prop("disabled", false);
        });
    }
    
    // Gunakan selector yang tepat sesuai id elemen input di form registrasi surat masuk Anda
    // Pastikan element select tempat memiliki id="tempat" atau sesuaikan targetnya di bawah ini:
    $("#tempat, #tanggal_kegiatan, #jam_mulai, #jam_selesai").on("change", cekBooking);
});
</script>
@endsection