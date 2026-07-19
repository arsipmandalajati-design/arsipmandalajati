@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Registrasi Surat Masuk
@endsection

@section('page-description')
Registrasikan surat fisik maupun dokumen digital yang diterima Kecamatan sebagai arsip digital untuk diproses lebih lanjut.
@endsection

@section('content')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.page-header{
    background:linear-gradient(135deg,#667eea,#4f46e5);
    border-radius:20px;
    padding:30px;
    color:#fff;
    margin-bottom:25px;
}

.form-card{
    border:none;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
}

.form-control,
.form-select{
    border-radius:12px;
    min-height:48px;
}

.form-control:focus,
.form-select:focus{
    border-color:#4f46e5;
    box-shadow:none;
}

.section-title{
    font-size:16px;
    font-weight:700;
    color:#4f46e5;
    border-left:4px solid #4f46e5;
    padding-left:10px;
    margin-bottom:20px;
}

.btn-save{
    background:#4f46e5;
    border:none;
    border-radius:12px;
    padding:10px 25px;
}

.btn-save:hover{
    background:#4338ca;
}

.btn-back{
    border-radius:12px;
    padding:10px 25px;
}

.card-header{
    font-weight:600;
}

</style>

{{-- ALERT VALIDASI --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ========================================================= --}}
{{-- INFORMASI ARSIP --}}
{{-- ========================================================= --}}

<div class="section-title">
    Informasi Arsip
</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Pilih Kode Arsip
        </label>

        <select
            name="kode_arsip_id"
            id="kode_arsip_id"
            class="form-select"
            required>

            <option value="">Pilih Kode Arsip...</option>

            @foreach($kodearsip as $item)

            <option
                value="{{ $item->id }}"
                data-kode="{{ $item->kode }}">

                {{ $item->kode }}
                -
                {{ $item->nama_arsip }}

            </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Ketik Kode Arsip (Opsional)
        </label>

        <input
            type="text"
            id="kode_manual"
            class="form-control"
            placeholder="Contoh : HM.01">

        <small class="text-muted">
            Kosongkan jika menggunakan kode arsip dari daftar.
        </small>

    </div>

</div>
{{-- ========================================================= --}}
{{-- INFORMASI SURAT --}}
{{-- ========================================================= --}}

<div class="section-title mt-4">
    Informasi Surat
</div>

<div class="row">

    {{-- JENIS SURAT --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Jenis Surat
        </label>

        <select
            name="jenis_surat"
            id="jenis_surat"
            class="form-select"
            required>

            <option value="">-- Pilih Jenis Surat --</option>

            <option value="Internal">
                Internal Kecamatan
            </option>

            <option value="Eksternal">
                Eksternal
            </option>

        </select>

        <small class="text-muted">
            Internal = kegiatan Kecamatan.<br>
            Eksternal = surat dari luar instansi.
        </small>

    </div>

    {{-- SUMBER ARSIP --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Sumber Arsip
        </label>

        <select
            name="sumber_arsip"
            class="form-select"
            required>

            <option value="Dokumen Digital">
                Dokumen Digital
            </option>

            <option value="Hasil Scan Dokumen Fisik">
                Hasil Scan Dokumen Fisik
            </option>

        </select>

    </div>

    {{-- NOMOR REGISTRASI --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Nomor Registrasi
        </label>

        <input
            type="text"
            id="nomor_manual"
            class="form-control"
            placeholder="Contoh : 058-Pel.PDH">

    </div>

    {{-- NOMOR SURAT OTOMATIS --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            <i class="bi bi-file-earmark-lock me-1"></i>

            Nomor Surat Otomatis

        </label>

        <input
            type="text"
            id="nomor_surat"
            name="nomor_surat"
            class="form-control bg-light"
            readonly>

        <small class="text-muted">
            Nomor surat dibuat otomatis berdasarkan kode arsip.
        </small>

    </div>

</div>

{{-- ========================================================= --}}
{{-- DETAIL SURAT --}}
{{-- ========================================================= --}}

<div class="section-title mt-4">
    Detail Surat
</div>

<div class="row">

    {{-- JUDUL --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Judul Surat
        </label>

        <input
            type="text"
            name="judul"
            class="form-control"
            placeholder="Masukkan judul surat"
            required>

    </div>

    {{-- PENGIRIM --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Asal Surat / Instansi
        </label>

        <input
            type="text"
            name="pengirim"
            class="form-control"
            placeholder="Contoh : Kelurahan, Universitas, Instansi"
            required>

        <small class="text-muted">
            Isi nama instansi atau pihak yang mengirim surat.
        </small>

    </div>

    {{-- TANGGAL SURAT --}}
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">
            Tanggal Surat
        </label>

        <input
            type="date"
            name="tanggal_surat"
            class="form-control"
            required>

    </div>

    {{-- PERIHAL --}}
    <div class="col-md-12 mb-3">

        <label class="form-label fw-semibold">
            Perihal
        </label>

        <textarea
            name="perihal"
            rows="4"
            class="form-control"
            placeholder="Masukkan perihal surat"
            required></textarea>

    </div>

</div>

{{-- ========================================================= --}}
{{-- DOKUMEN SURAT --}}
{{-- ========================================================= --}}

<div class="section-title mt-4">
    Dokumen Surat
</div>

<div class="row">

    <div class="col-md-12 mb-3">

        <label class="form-label fw-semibold">

            <i class="bi bi-file-earmark-arrow-up"></i>

            Upload File Surat

        </label>

        <input
            type="file"
            name="file_surat"
            class="form-control"
            accept=".pdf,.jpg,.jpeg,.png"
            required>

        <small class="text-muted">
            Format PDF, JPG, JPEG, PNG.
            Maksimal ukuran 2 MB.
        </small>

    </div>

</div>

<hr class="my-4">
{{-- ========================================================= --}}
{{-- BOOKING TEMPAT --}}
{{-- ========================================================= --}}

<div id="bookingCard" class="card border-0 shadow-sm" style="display:none;">

    <div class="card-header bg-primary text-white">
        <i class="bi bi-calendar-event"></i>
        Booking Tempat (Opsional)
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Booking tempat digunakan apabila surat merupakan kegiatan internal Kecamatan yang membutuhkan ruangan.
        </div>

        <div class="row">

            {{-- TEMPAT --}}
            <div class="col-md-12 mb-3">

                <label class="form-label fw-semibold">
                    Tempat
                </label>

                <select id="tempat"
                    name="tempat"
                    class="form-select">

                    <option value="">
                        -- Pilih Tempat --
                    </option>

                    <option value="Aula Kecamatan">
                        Aula Kecamatan
                    </option>

                    <option value="Ruang Camat">
                        Ruang Camat
                    </option>

                    <option value="Ruang Sekretaris">
                        Ruang Sekretaris
                    </option>

                    <option value="Ruang Rapat">
                        Ruang Rapat
                    </option>

                    <option value="Halaman Kecamatan">
                        Halaman Kecamatan
                    </option>

                </select>

            </div>

            {{-- TANGGAL --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Tanggal Kegiatan
                </label>

                <input type="date"
                    id="tanggal_kegiatan"
                    name="tanggal_kegiatan"
                    class="form-control">

            </div>

            {{-- JAM MULAI --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Jam Mulai
                </label>

                <input type="time"
                id="jam_mulai"
                name="jam_mulai"
                class="form-control"
                    value="{{ old('jam_mulai') }}">

            </div>

            {{-- JAM SELESAI --}}
            <div class="col-md-3 mb-3">

                <label class="form-label fw-semibold">
                    Jam Selesai
                </label>

                <input
                    type="time"
                    id="jam_selesai"
                    name="jam_selesai"
                    class="form-control"
                    value="{{ old('jam_selesai') }}">

            </div>

            <div id="bookingAlert"
     class="alert alert-danger mt-3 d-none">

    <i class="bi bi-exclamation-triangle-fill"></i>

    Jadwal sudah dibooking.

</div>

            {{-- MATERI --}}
            <div class="col-md-12 mb-3">

                <label class="form-label fw-semibold">
                    Materi Kegiatan
                </label>

                <input
                    type="text"
                    name="materi"
                    class="form-control"
                    placeholder="Contoh : Rapat Evaluasi Bulanan"
                    value="{{ old('materi') }}">

            </div>

        </div>

        <hr>

        <h5 class="fw-bold text-primary">
            <i class="bi bi-box-seam"></i>
            Kebutuhan Kegiatan
        </h5>

        <div class="row">

            {{-- JUMLAH PESERTA --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Jumlah Peserta
                </label>

                <input
                    type="number"
                    name="jumlah_peserta"
                    class="form-control"
                    value="{{ old('jumlah_peserta',0) }}">

            </div>

        </div>

        <div class="row">

            <div class="col-md-3 mb-3">

                <label>Kursi</label>

                <input
                    type="number"
                    name="kursi"
                    class="form-control"
                    value="{{ old('kursi',0) }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Meja</label>

                <input
                    type="number"
                    name="meja"
                    class="form-control"
                    value="{{ old('meja',0) }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Proyektor</label>

                <input
                    type="number"
                    name="proyektor"
                    class="form-control"
                    value="{{ old('proyektor',0) }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Mic</label>

                <input
                    type="number"
                    name="mic"
                    class="form-control"
                    value="{{ old('mic',0) }}">

            </div>

        </div>

        <div class="row">

            <div class="col-md-4 mb-3">

                <label>Sound System</label>

                <input
                    type="number"
                    name="sound_system"
                    class="form-control"
                    value="{{ old('sound_system',0) }}">

            </div>

            <div class="col-md-4 mb-3">

                <label>Kabel Roll</label>

                <input
                    type="number"
                    name="kabel_roll"
                    class="form-control"
                    value="{{ old('kabel_roll',0) }}">

            </div>

            <div class="col-md-4 mb-3">

                <label>Lainnya</label>

                <input
                    type="text"
                    name="lainnya"
                    class="form-control"
                    placeholder="Contoh : Whiteboard, Flipchart"
                    value="{{ old('lainnya') }}">

            </div>

        </div>

    </div>

</div>
{{-- ========================================================= --}}
{{-- BUTTON --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-end gap-2 mt-4">

    <a href="{{ route('suratmasuk.index') }}"
        class="btn btn-secondary btn-back">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

    <button type="submit"
        class="btn btn-primary btn-save">

        <i class="bi bi-save"></i>
        Simpan Surat

    </button>

</div>

</form>

</div>
</div>

{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    toggleBooking();
    generateNomor();

    document.getElementById('jenis_surat')
        .addEventListener('change', toggleBooking);

    document.getElementById('kode_arsip_id')
        .addEventListener('change', generateNomor);

    document.getElementById('kode_manual')
        .addEventListener('keyup', generateNomor);

    document.getElementById('nomor_manual')
        .addEventListener('keyup', generateNomor);

});


// ==========================
// TAMPILKAN BOOKING
// ==========================

function toggleBooking(){

    let jenis = document.getElementById("jenis_surat").value;

    if(jenis=="Internal"){

        document.getElementById("bookingCard").style.display="block";

    }else{

        document.getElementById("bookingCard").style.display="none";

    }

}



// ==========================
// NOMOR OTOMATIS
// ==========================

function generateNomor(){

    let dropdown=document.getElementById("kode_arsip_id");

    let selected=dropdown.options[dropdown.selectedIndex];

    let kodeDropdown=selected ? selected.getAttribute("data-kode") : "";

    let kodeManual=document.getElementById("kode_manual").value.trim();

    let kode=kodeManual!="" ? kodeManual : kodeDropdown;

    let nomor=document.getElementById("nomor_manual").value.trim();

    let tahun=new Date().getFullYear();

    let bulan=new Date().getMonth()+1;

    let romawi=[
        "",
        "I",
        "II",
        "III",
        "IV",
        "V",
        "VI",
        "VII",
        "VIII",
        "IX",
        "X",
        "XI",
        "XII"
    ];

    if(kode!="" && nomor!=""){

        document.getElementById("nomor_surat").value=

            "No."+kode+
            "/"+nomor+
            "-Kec.MDLJ/T/"+
            romawi[bulan]+
            "/"+
            tahun;

    }else{

        document.getElementById("nomor_surat").value="";

    }

}



// ==========================
// CEK BOOKING
// ==========================

function cekBooking(){

    let tanggal=$("#tanggal_kegiatan").val();

    let tempat=$("#tempat").val();

    let mulai=$("#jam_mulai").val();

    let selesai=$("#jam_selesai").val();

    if(
        tanggal=="" ||
        tempat=="" ||
        mulai=="" ||
        selesai==""
    ){
        return;
    }

    $.ajax({

        url:"{{ route('agenda.cekBooking') }}",

        type:"GET",

        data:{

            tanggal:tanggal,

            tempat:tempat,

            jam_mulai:mulai,

            jam_selesai:selesai

        },

        success:function(res){

            if(res.bentrok){

                $("#bookingAlert")
                    .removeClass("d-none");

                Swal.fire({

                    icon:"warning",

                    title:"Jadwal Bentrok",

                    text:"Tempat sudah digunakan pada jam tersebut.",

                    timer:2000,

                    showConfirmButton:false

                });

                $(".btn-save").prop("disabled",true);

            }else{

                $("#bookingAlert")
                    .addClass("d-none");

                $(".btn-save").prop("disabled",false);

            }

        }

    });

}

$("#tanggal_kegiatan,#tempat,#jam_mulai,#jam_selesai")
.on("change keyup",cekBooking);

</script>
@endsection