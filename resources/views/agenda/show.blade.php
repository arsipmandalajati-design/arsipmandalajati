@extends('layouts.app') <!-- Sesuaikan dengan layout utamamu -->

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Agenda: {{ $agenda->nama_kegiatan }}</h4>
        </div>
        <div class="card-body">
            <!-- Informasi Kegiatan -->
            <h5 class="text-secondary border-bottom pb-2">Informasi Kegiatan</h5>
            <table class="table table-borderless">
                <tr>
                    <td style="width: 25%;"><strong>Nama Kegiatan</strong></td>
                    <td>: {{ $agenda->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Waktu</strong></td>
                    <td>: {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }} WIB</td>
                </tr>
                <tr>
                    <td><strong>Tempat</strong></td>
                    <td>: {{ $agenda->tempat }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>: <span class="badge bg-info">{{ $agenda->status }}</span></td>
                </tr>
            </table>

            <!-- Informasi Surat Asal (Tanpa harus pindah halaman ke Surat Masuk) -->
            <h5 class="text-secondary border-bottom pb-2 mt-4">Informasi Surat Asal</h5>
            @if($agenda->suratMasuk)
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 25%;"><strong>Nomor Surat</strong></td>
                        <td>: {{ $agenda->suratMasuk->no_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Perihal / Judul Surat</strong></td>
                        <td>: {{ $agenda->suratMasuk->judul ?? $agenda->suratMasuk->perihal ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pengirim</strong></td>
                        <td>: {{ $agenda->suratMasuk->pengirim ?? '-' }}</td>
                    </tr>
                </table>
            @else
                <p class="text-muted fst-italic">Tidak ada data surat asal yang terikat.</p>
            @endif

            <!-- HASIL KEGIATAN -->
            <hr>

            <h5 class="text-success border-bottom pb-2 mt-4">
                Hasil Pelaksanaan
            </h5>
            
            <table class="table table-borderless">
            
            <tr>
                <td width="25%"><strong>Hasil Kegiatan</strong></td>
                <td>: {{ $agenda->hasil_kegiatan ?? '-' }}</td>
            </tr>
            
            <tr>
                <td><strong>Hasil Materi</strong></td>
                <td>: {{ $agenda->hasil_materi ?? '-' }}</td>
            </tr>
            
            <tr>
                <td><strong>Catatan</strong></td>
                <td>: {{ $agenda->catatan ?? '-' }}</td>
            </tr>
            
            <tr>
                <td><strong>Dokumentasi</strong></td>
            
                <td>
            
                    @if($agenda->dokumentasi)
            
                        <img
                            src="{{ asset('storage/'.$agenda->dokumentasi) }}"
                            class="img-fluid rounded shadow"
                            style="max-width:350px;">
            
                    @else
            
                        -
            
                    @endif
            
                </td>
            
            </tr>
            
            </table>
            <!-- Tombol Aksi Kembali -->
            <div class="mt-4">
                <a href="{{ route('agenda.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Agenda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection