<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Laporan Data Arsip</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    font-size:13px;
    color:#222;
    margin:30px;
}

/* =======================
HEADER
======================= */

.header{

    display:flex;

    align-items:center;

}

.logo{

    width:90px;

}

.logo img{

    width:90px;

}

.header-text{

    flex:1;

    text-align:center;

    margin-right:90px;

}

.header-text h2{

    font-size:23px;

}

.header-text h3{

    font-size:20px;

    margin-top:3px;

}

.header-text p{

    font-size:13px;

}

.line{

    border-top:3px solid black;

    border-bottom:1px solid black;

    margin-top:12px;

    margin-bottom:25px;

}

/* =======================
JUDUL
======================= */

.title{

    text-align:center;

    margin-bottom:25px;

}

.title h2{

    font-size:22px;

    margin-bottom:8px;

}

.title p{

    font-size:13px;

}

/* =======================
TABLE
======================= */

.section{

    margin-top:25px;

}

.section h3{

    margin-bottom:10px;

    color:#0f766e;

}

table{

    width:100%;

    border-collapse:collapse;

    margin-bottom:25px;

}

table th{

    background:#dbeafe;

    border:1px solid black;

    padding:8px;

    text-align:center;

}

table td{

    border:1px solid black;

    padding:7px;

}

/* =======================
PAGE BREAK
======================= */

.page-break{

    page-break-after:always;

}

/* =======================
FOOTER
======================= */

.footer{

    margin-top:80px;

    width:300px;

    float:right;

    text-align:center;

}

.footer p{

    margin-top:5px;

}

.nama{

    margin-top:75px;

    font-weight:bold;

    text-decoration:underline;

}

@media print{

    @page{

        size:A4 portrait;

        margin:20mm;

    }

}

</style>

</head>

<body>

{{-- ========================================= --}}
{{-- HEADER --}}
{{-- ========================================= --}}

<div class="header">

    <div class="logo">

        <img src="{{ asset('images/logo.png') }}">

    </div>

    <div class="header-text">

        <h2>PEMERINTAH KOTA BANDUNG</h2>

        <h3>KECAMATAN MANDALAJATI</h3>

        <p>Jl. Pasir Impun No.33 Bandung</p>

        <p>Telepon (022) XXXXXXX</p>

    </div>

</div>

<div class="line"></div>

<div class="title">

    <h2>LAPORAN DATA ARSIP</h2>

    <p>
        Tanggal Cetak :
        {{ now()->translatedFormat('d F Y') }}
    </p>

</div>

{{-- ========================================= --}}
{{-- SURAT MASUK --}}
{{-- ========================================= --}}

<div class="section">

<h3>DATA SURAT MASUK</h3>

<table>

<thead>

<tr>

<th width="5%">No</th>

<th width="12%">Kode Arsip</th>

<th>Nomor Surat</th>

<th>Judul</th>

<th>Pengirim</th>

<th width="15%">Tanggal</th>

</tr>

</thead>

<tbody>

@forelse($suratMasuk as $item)

<tr>

<td align="center">{{ $loop->iteration }}</td>

<td>{{ optional($item->kodearsip)->kode }}</td>

<td>{{ $item->nomor_surat }}</td>

<td>{{ $item->judul }}</td>

<td>{{ $item->pengirim }}</td>

<td>{{ $item->tanggal_surat }}</td>

</tr>

@empty

<tr>

<td colspan="6" align="center">

Tidak ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- HEADER LAGI --}}
{{-- ========================================= --}}

<div class="header">

<div class="logo">

<img src="{{ asset('images/logo.png') }}">

</div>

<div class="header-text">

<h2>PEMERINTAH KOTA BANDUNG</h2>

<h3>KECAMATAN MANDALAJATI</h3>

<p>Jl. Pasir Impun No.33 Bandung</p>

<p>Telepon (022) XXXXXXX</p>

</div>

</div>

<div class="line"></div>

<div class="section">

<h3>DATA SURAT KELUAR</h3>

<table>

<thead>

<tr>

<th>No</th>

<th>Kode Arsip</th>

<th>Nomor Surat</th>

<th>Judul</th>

<th>Tujuan</th>

<th>Tanggal</th>

</tr>

</thead>

<tbody>

@forelse($suratKeluar as $item)

<tr>

<td align="center">{{ $loop->iteration }}</td>

<td>{{ optional($item->kodearsip)->kode }}</td>

<td>{{ $item->nomor_surat }}</td>

<td>{{ $item->judul }}</td>

<td>{{ $item->tujuan }}</td>

<td>{{ $item->tanggal_surat }}</td>

</tr>

@empty

<tr>

<td colspan="6" align="center">

Tidak ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="page-break"></div>

{{-- ========================================= --}}
{{-- HEADER LAGI --}}
{{-- ========================================= --}}

<div class="header">

<div class="logo">

<img src="{{ asset('images/logo.png') }}">

</div>

<div class="header-text">

<h2>PEMERINTAH KOTA BANDUNG</h2>

<h3>KECAMATAN MANDALAJATI</h3>

<p>Jl. Pasir Impun No.33 Bandung</p>

<p>Telepon (022) XXXXXXX</p>

</div>

</div>

<div class="line"></div>

<div class="section">

<h3>DATA MASTER ARSIP</h3>

<table>

<thead>

<tr>

<th width="10%">No</th>

<th width="20%">Kode Arsip</th>

<th>Nama Arsip</th>

</tr>

</thead>

<tbody>

@forelse($arsip as $item)

<tr>

<td align="center">{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama_arsip }}</td>

</tr>

@empty

<tr>

<td colspan="3" align="center">

Tidak ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="footer">

<p>

Bandung,
{{ now()->translatedFormat('d F Y') }}

</p>

<br>

<p>

Mengetahui,

</p>

<p>

Camat Mandalajati

</p>

<div class="nama">

(................................)

</div>

</div>

</body>

</html>