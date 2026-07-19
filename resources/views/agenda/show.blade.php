@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.header-card{
    background:linear-gradient(135deg,#4f46e5,#6366f1,#818cf8);
    border-radius:20px;
    padding:30px;
    color:white;
    margin-bottom:25px;
}

.detail-card{
    border:none;
    border-radius:20px;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.section-title{
    font-weight:700;
    color:#4f46e5;
    border-left:5px solid #4f46e5;
    padding-left:10px;
    margin-bottom:20px;
}

.label{
    font-size:13px;
    color:#6b7280;
}

.value{
    font-weight:600;
    color:#111827;
    margin-bottom:18px;
}

.badge-status{
    padding:8px 18px;
    border-radius:20px;
    font-size:13px;
}

.img-doc{
    width:100%;
    max-height:420px;
    object-fit:cover;
    border-radius:15px;
    border:1px solid #ddd;
}

</style>

<div class="header-card">

    <h2 class="fw-bold">
        <i class="bi bi-calendar-event-fill"></i>
        Detail Agenda
    </h2>

    <p class="mb-0">
        Informasi lengkap agenda kegiatan Kecamatan.
    </p>

</div>

<div class="card detail-card">

<div class="card-body p-4">

<div class="section-title">
    Informasi Agenda
</div>

<div class="row">

    <div class="col-md-6">
        <div class="label">
            Nama Kegiatan
        </div>

        <div class="value">
            {{ $agenda->nama_kegiatan }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="label">
            Surat Asal
        </div>

        <div class="value">
            {{ optional($agenda->suratMasuk)->nomor_surat ?? '-' }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="label">
            Judul Surat
        </div>

        <div class="value">
            {{ optional($agenda->suratMasuk)->judul ?? '-' }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="label">
            Penyelenggara
        </div>

        <div class="value">
            {{ $agenda->penyelenggara }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="label">
            Tanggal
        </div>

        <div class="value">
            {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d F Y') }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="label">
            Jam
        </div>

        <div class="value">
            {{ $agenda->jam_mulai }}
            -
            {{ $agenda->jam_selesai }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="label">
            Status
        </div>

        <div class="value">

            @if($agenda->status=="Terjadwal")

                <span class="badge bg-primary badge-status">
                    {{ $agenda->status }}
                </span>

            @elseif($agenda->status=="Selesai")

                <span class="badge bg-success badge-status">
                    {{ $agenda->status }}
                </span>

            @else

                <span class="badge bg-secondary badge-status">
                    {{ $agenda->status }}
                </span>

            @endif

        </div>
    </div>

    <div class="col-md-12">
        <div class="label">
            Tempat
        </div>

        <div class="value">
            {{ $agenda->tempat }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="label">
            Materi
        </div>

        <div class="value">
            {{ $agenda->materi ?: '-' }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="label">
            Keterangan
        </div>

        <div class="value">
            {{ $agenda->keterangan ?: '-' }}
        </div>
    </div>

</div>

<hr>

<div class="section-title">
    Kebutuhan Kegiatan
</div>

<div class="row">

    <div class="col-md-2">
        <div class="label">Kursi</div>
        <div class="value">{{ $agenda->kursi }}</div>
    </div>

    <div class="col-md-2">
        <div class="label">Meja</div>
        <div class="value">{{ $agenda->meja }}</div>
    </div>

    <div class="col-md-2">
        <div class="label">Proyektor</div>
        <div class="value">{{ $agenda->proyektor }}</div>
    </div>

    <div class="col-md-2">
        <div class="label">Mic</div>
        <div class="value">{{ $agenda->mic }}</div>
    </div>

    <div class="col-md-2">
        <div class="label">Sound System</div>
        <div class="value">{{ $agenda->sound_system }}</div>
    </div>

    <div class="col-md-2">
        <div class="label">Kabel Roll</div>
        <div class="value">{{ $agenda->kabel_roll }}</div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="label">
            Lainnya
        </div>

        <div class="value">
            {{ $agenda->lainnya ?: '-' }}
        </div>
    </div>

</div>

<hr>

<div class="section-title">
    Dokumentasi
</div>

@if($agenda->dokumentasi)

    <img
        src="{{ asset('storage/'.$agenda->dokumentasi) }}"
        class="img-doc">

@else

    <div class="alert alert-warning">
        <i class="bi bi-image"></i>
        Belum ada dokumentasi.
    </div>

@endif


<hr>

<div class="section-title">
    Hasil Kegiatan
</div>

@if(
    $agenda->hasil_kegiatan ||
    $agenda->hasil_materi ||
    $agenda->catatan
)

    <div class="row">

        <div class="col-md-12">

            <div class="label">
                Hasil Kegiatan
            </div>

            <div class="value">
                {{ $agenda->hasil_kegiatan }}
            </div>

        </div>

        <div class="col-md-12">

            <div class="label">
                Hasil Materi
            </div>

            <div class="value">
                {{ $agenda->hasil_materi }}
            </div>

        </div>

        <div class="col-md-12">

            <div class="label">
                Catatan
            </div>

            <div class="value">
                {{ $agenda->catatan }}
            </div>

        </div>

    </div>

@else

    <div class="alert alert-info">

        <i class="bi bi-info-circle"></i>

        Belum ada hasil kegiatan yang diinput.

    </div>

@endif


<div class="d-flex justify-content-end gap-2 mt-4">

    <a href="{{ route('agenda.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>

    <a href="{{ route('agenda.edit',$agenda->id) }}"
        class="btn btn-warning">

        <i class="bi bi-pencil-square"></i>

        Edit

    </a>

    @if($agenda->status == 'Selesai')

        <a href="{{ route('agenda.hasil',$agenda->id) }}"
            class="btn btn-success">

            <i class="bi bi-eye"></i>

            Lihat Hasil

        </a>

    @else

        <a href="{{ route('agenda.hasil',$agenda->id) }}"
            class="btn btn-primary">

            <i class="bi bi-pencil-square"></i>

            Isi Hasil

        </a>

    @endif

</div>

</div>

</div>

@endsection