@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- DETAIL SURAT & LOGISTIK -->
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Surat Masuk</h6>
                    <a href="{{ route('suratmasuk.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Nomor Registrasi</th>
                            <td><b class="text-primary">{{ $suratmasuk->nomor_registrasi }}</b></td>
                        </tr>
                        <tr>
                            <th>Nomor Surat</th>
                            <td>{{ $suratmasuk->nomor_surat }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Surat</th>
                            <td>
                                <span class="badge {{ $suratmasuk->jenis_surat == 'Internal' ? 'badge-info' : 'badge-warning' }}">
                                    {{ $suratmasuk->jenis_surat }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Kode / Kategori Arsip</th>
                            <td>{{ $suratmasuk->kodearsip->kode ?? '-' }} - {{ $suratmasuk->kodearsip->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Judul / Perihal</th>
                            <td>{{ $suratmasuk->judul }} <br><small class="text-muted">{{ $suratmasuk->perihal }}</small></td>
                        </tr>
                        <tr>
                            <th>Pengirim</th>
                            <td>{{ $suratmasuk->pengirim }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Surat / Diterima</th>
                            <td>{{ \Carbon\Carbon::parse($suratmasuk->tanggal_surat)->format('d-m-Y') }} / {{ \Carbon\Carbon::parse($suratmasuk->tanggal_diterima)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status Disposisi</th>
                            <td>
                                <span class="badge badge-secondary">{{ $suratmasuk->status }}</span>
                            </td>
                        </tr>
                    </table>

                    {{-- DETAIL LOGISTIK AGENDA (JIKA SURAT INTERNAL) --}}
                    @if($suratmasuk->jenis_surat === 'Internal' && $suratmasuk->agenda)
                        <h6 class="font-weight-bold text-primary mt-4 mb-3">Detail Agenda & Kebutuhan Logistik</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered">
                                <tr>
                                    <th>Tempat Kegiatan</th>
                                    <td>{{ $suratmasuk->agenda->tempat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Kegiatan</th>
                                    <td>
                                        {{ $suratmasuk->agenda->tanggal ? \Carbon\Carbon::parse($suratmasuk->agenda->tanggal)->format('d-m-Y') : '-' }} 
                                        ({{ $suratmasuk->agenda->jam_mulai ?? '-' }} s/d {{ $suratmasuk->agenda->jam_selesai ?? '-' }})
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Peserta</th>
                                    <td>{{ $suratmasuk->agenda->jumlah_peserta ?? 0 }} Orang</td>
                                </tr>
                                <tr>
                                    <th>Logistik/Peralatan</th>
                                    <td>
                                        <ul class="mb-0 pl-3">
                                            <li>Kursi: {{ $suratmasuk->agenda->kursi ?? 0 }}</li>
                                            <li>Meja: {{ $suratmasuk->agenda->meja ?? 0 }}</li>
                                            <li>Proyektor: {{ $suratmasuk->agenda->proyektor ?? 0 }}</li>
                                            <li>Mic: {{ $suratmasuk->agenda->mic ?? 0 }}</li>
                                            <li>Sound System: {{ $suratmasuk->agenda->sound_system ?? 0 }}</li>
                                            <li>Kabel Roll: {{ $suratmasuk->agenda->kabel_roll ?? 0 }}</li>
                                            <li>Lainnya: {{ $suratmasuk->agenda->lainnya ?? '-' }}</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PREVIEW BERKAS DIRECT EMBED -->
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Berkas Surat</h6>
                    @if($suratmasuk->file_surat)
                        <a href="{{ asset('storage/' . $suratmasuk->file_surat) }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Unduh File
                        </a>
                    @endif
                </div>
                <div class="card-body p-2 text-center" style="min-height: 450px; background-color: #f8f9fc;">
                    @if($suratmasuk->file_surat && Storage::disk('public')->exists($suratmasuk->file_surat))
                        @php
                            $extension = pathinfo($suratmasuk->file_surat, PATHINFO_EXTENSION);
                            $fileUrl = asset('storage/' . $suratmasuk->file_surat);
                        @endphp

                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <img src="{{ $fileUrl }}" class="img-fluid rounded border shadow-sm" style="max-height: 500px;" alt="Preview Surat">
                        @elseif(strtolower($extension) === 'pdf')
                            <iframe src="{{ $fileUrl }}" width="100%" height="500px" style="border: none;"></iframe>
                        @else
                            <div class="alert alert-info mt-5">
                                Format file (<b>.{{ $extension }}</b>) tidak mendukung live preview.<br>
                                Silakan unduh berkas untuk melihat.
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-excel fa-3x text-gray-300 mb-3"></i>
                            <p class="text-danger mb-0">Berkas/File fisik tidak ditemukan di server.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection