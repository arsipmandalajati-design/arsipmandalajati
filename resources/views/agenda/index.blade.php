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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
<label class="form-label fw-semibold">Nama Kegiatan</label>
<input type="text" name="nama_kegiatan" class="form-control" placeholder="Cari agenda..." value="{{ request('nama_kegiatan') }}">
</div>

<div class="col-md-2">
<label class="form-label fw-semibold">Status</label>
<select name="status" class="form-select">
<option value="">Semua</option>
<option value="Terjadwal" @if(request('status')=="Terjadwal") selected @endif>Terjadwal</option>
<option value="Selesai" @if(request('status')=="Selesai") selected @endif>Selesai</option>
<option value="Ditunda" @if(request('status')=="Ditunda") selected @endif>Ditunda</option>
</select>
</div>

<div class="col-md-2">
<label class="form-label fw-semibold">Tanggal Awal</label>
<input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
</div>

<div class="col-md-2">
<label class="form-label fw-semibold">Tanggal Akhir</label>
<input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
</div>
<div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-primary me-2"><i class="bi bi-search"></i></button>
    <a href="{{ route('agenda.index') }}" class="btn btn-secondary me-2"><i class="bi bi-arrow-clockwise"></i></a>
    @if(Auth::user()->role == 'admin')
        <span class="badge bg-success px-3 py-2"><i class="bi bi-shield-check"></i> Administrator</span>
    @endif
    <a href="{{ route('agenda.print') }}" target="_blank" class="btn btn-danger ms-2"><i class="bi bi-printer-fill"></i></a>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->suratMasuk)
                                <strong>{{ $item->suratMasuk->nomor_surat }}</strong>
                                <br>
                                <small class="text-muted">{{ $item->suratMasuk->judul }}</small>
                            @else
                                <span class="text-danger">Surat tidak ditemukan</span>
                            @endif
                        </td>
                        <td>{{ $item->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                        <td>{{ $item->tempat }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>
                            @if($item->status == 'Terjadwal')
                                <span class="status-badge status-terjadwal">{{ $item->status }}</span>
                            @elseif($item->status == 'Diproses')
                                <span class="status-badge status-diproses">{{ $item->status }}</span>
                            @elseif($item->status == 'Selesai')
                                <span class="status-badge status-selesai">{{ $item->status }}</span>
                            @elseif($item->status == 'Ditunda')
                                <span class="status-badge status-ditunda">{{ $item->status }}</span>
                            @elseif($item->status == 'Dibatalkan')
                                <span class="status-badge status-batal">{{ $item->status }}</span>
                            @else
                                <span class="status-badge bg-secondary">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- Tombol Trigger Modal --}}
                            <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            
                            <a href="{{ route('agenda.whatsapp',$item->id) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            
                            <a href="{{ route('agenda.hasil',$item->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-journal-check"></i>
                            </a>

                            <form action="{{ url('agenda/'.$item->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus agenda?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
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

<!-- ========================================================== -->
<!-- PISAHKAN MODAL DI LUAR TABLE (DI LUAR TBODY)               -->
<!-- ========================================================== -->
@foreach($agenda as $item)
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            
            <!-- Header Modal -->
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                <h5 class="modal-title fw-bold" id="detailModalLabel{{ $item->id }}">
                    <i class="bi bi-info-circle me-2"></i> Detail & Preview Agenda Kegiatan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body Modal -->
            <div class="modal-body p-4 bg-light">
                
                <!-- Informasi Utama Agenda & Surat -->
                <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 12px;">
                    <h6 class="fw-bold mb-3" style="color: #0f766e;">
                        <i class="bi bi-file-text-fill me-1"></i> Informasi Agenda & Surat
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="text-muted d-block" style="font-size: 12px;">Nama Kegiatan</span>
                            <strong>{{ $item->nama_kegiatan }}</strong>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block" style="font-size: 12px;">Nomor Surat Asal</span>
                            <strong>{{ optional($item->suratMasuk)->nomor_surat ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block" style="font-size: 12px;">Judul / Perihal Surat</span>
                            <strong>{{ optional($item->suratMasuk)->judul ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block" style="font-size: 12px;">Penyelenggara</span>
                            <strong>{{ $item->penyelenggara }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block" style="font-size: 12px;">Tanggal</span>
                            <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block" style="font-size: 12px;">Waktu</span>
                            <strong>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block" style="font-size: 12px;">Status</span>
                            <strong>{{ $item->status }}</strong>
                        </div>
                        <div class="col-12">
                            <span class="text-muted d-block" style="font-size: 12px;">Tempat</span>
                            <strong>{{ $item->tempat }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Kebutuhan Sarana -->
                <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 12px;">
                    <h6 class="fw-bold mb-3" style="color: #0f766e;">
                        <i class="bi bi-tools me-1"></i> Kebutuhan Sarana & Prasarana
                    </h6>
                    <div class="row text-center">
                        <div class="col-2 border-end"><small class="text-muted d-block">Kursi</small><strong>{{ $item->kursi ?? 0 }}</strong></div>
                        <div class="col-2 border-end"><small class="text-muted d-block">Meja</small><strong>{{ $item->meja ?? 0 }}</strong></div>
                        <div class="col-2 border-end"><small class="text-muted d-block">Proyektor</small><strong>{{ $item->proyektor ?? 0 }}</strong></div>
                        <div class="col-2 border-end"><small class="text-muted d-block">Mic</small><strong>{{ $item->mic ?? 0 }}</strong></div>
                        <div class="col-2 border-end"><small class="text-muted d-block">Sound</small><strong>{{ $item->sound_system ?? 0 }}</strong></div>
                        <div class="col-2"><small class="text-muted d-block">Kabel</small><strong>{{ $item->kabel_roll ?? 0 }}</strong></div>
                    </div>
                    @if($item->lainnya)
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted">Lainnya: </small><span>{{ $item->lainnya }}</span>
                        </div>
                    @endif
                </div>

                <!-- Hasil Notulen (Jika Ada) -->
                @if($item->hasil_kegiatan || $item->catatan)
                <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 12px;">
                    <h6 class="fw-bold mb-2" style="color: #0f766e;">
                        <i class="bi bi-journal-check me-1"></i> Hasil Notulen & Catatan
                    </h6>
                    <p class="mb-1"><strong>Hasil Kegiatan:</strong> {{ $item->hasil_kegiatan ?: '-' }}</p>
                    <p class="mb-0"><strong>Catatan:</strong> {{ $item->catatan ?: '-' }}</p>
                </div>
                @endif

                <!-- Preview Lampiran Berkas / Dokumentasi -->
                <div class="card border-0 shadow-sm p-3 bg-dark text-white" style="border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="m-0" style="font-size: 14px;">
                            <i class="bi bi-file-earmark-pdf me-1 text-danger"></i> Preview Lampiran Berkas
                        </h6>
                        @if($item->dokumentasi)
                            <a href="{{ asset('storage/' . $item->dokumentasi) }}" target="_blank" class="btn btn-sm btn-light text-dark fw-bold" style="font-size: 12px;">
                                <i class="bi bi-box-arrow-up-right"></i> Buka Tab Baru
                            </a>
                        @endif
                    </div>

                    <div class="bg-secondary rounded p-2 text-center" style="min-height: 180px; display: flex; align-items: center; justify-content: center;">
                        @if($item->dokumentasi)
                            <img src="{{ asset('storage/' . $item->dokumentasi) }}" class="img-fluid rounded" style="max-height: 260px; object-fit: contain;">
                        @else
                            <span class="text-white-50"><i class="bi bi-image"></i> Belum ada file dokumentasi yang diunggah.</span>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Footer Modal -->
            <div class="modal-footer bg-white border-top-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection