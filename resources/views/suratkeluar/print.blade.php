@php

use Carbon\Carbon;

Carbon::setLocale('id');

$path = public_path('images/logo.png');

if(file_exists($path)){

    $type = pathinfo($path, PATHINFO_EXTENSION);

    $data = file_get_contents($path);

    $logo = 'data:image/'.$type.';base64,'.base64_encode($data);

}else{

    $logo = '';

}

@endphp

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Laporan Surat Keluar</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:"Times New Roman",serif;

    font-size:12px;

    color:#000;

}

.header{

    width:100%;

    margin-bottom:8px;

}

.header table{

    border:none;

}

.header td{

    border:none;

}

.logo{

    width:85px;

}

.instansi{

    text-align:center;

    line-height:1.4;

}

.instansi h2{

    font-size:20px;

    margin:0;

}

.instansi h1{

    font-size:24px;

    margin:2px 0;

}

.instansi p{

    font-size:13px;

}

.garis1{

    border:2px solid #000;

    margin-top:8px;

}

.garis2{

    border:1px solid #000;

    margin-top:2px;

    margin-bottom:20px;

}

.judul{

    text-align:center;

    margin-bottom:18px;

}

.judul h3{

    font-size:18px;

    margin-bottom:4px;

}

.judul p{

    font-size:13px;

}

.info{

    width:100%;

    margin-bottom:15px;

}

.info td{

    border:none;

    font-size:12px;

    padding:2px;

}

table{

    width:100%;

    border-collapse:collapse;

}

th{

    border:1px solid #000;

    background:#e9ecef;

    padding:7px;

    text-align:center;

    font-size:12px;

}

td{

    border:1px solid #000;

    padding:6px;

    font-size:12px;

    vertical-align:top;

}

.text-center{

    text-align:center;

}

.text-right{

    text-align:right;

}

</style>

</head>

<body>

<div class="header">

<table width="100%">

<tr>

<td width="90" align="center">

@if($logo)

<img src="{{ $logo }}" class="logo">

@endif

</td>

<td>

<div class="instansi">

<h2>PEMERINTAH KOTA BANDUNG</h2>

<h1>KECAMATAN MANDALAJATI</h1>

<p>

Jl. Pasir Impun No.33 Bandung

</p>

<p>

Telepon (022) xxxxxxxx

</p>

<p>

Email : kecamatanmandalajati@gmail.com

</p>

</div>

</td>

</tr>

</table>

</div>

<div class="garis1"></div>

<div class="garis2"></div>

<div class="judul">

<h3>

LAPORAN DATA SURAT KELUAR

</h3>

<p>

Sistem Manajemen E-Arsip Kecamatan Mandalajati

</p>

</div>

<table class="info">

<tr>

<td width="50%">

<b>Jenis Laporan</b>

: Surat Keluar

</td>

<td class="text-right">

<b>Dicetak Oleh</b>

:

{{ Auth::user()->name ?? 'Administrator' }}

</td>

</tr>

<tr>

<td>

<b>Total Data</b>

:

{{ $suratkeluar->count() }}

Surat

</td>

<td class="text-right">

<b>Tanggal Cetak</b>

:

{{ Carbon::now()->translatedFormat('d F Y') }}

</td>

</tr>

</table>

<table>

<thead>

<tr>

<th width="5%">

No

</th>

<th width="10%">

Kode Arsip

</th>

<th width="18%">

Nomor Surat

</th>

<th width="18%">

Judul Surat

</th>

<th width="15%">

Pengirim

</th>

<th width="15%">

Tujuan

</th>

<th width="19%">

Perihal

</th>

<th width="10%">

Tanggal

</th>

</tr>

</thead>

<tbody>
    @forelse($suratkeluar as $item)

<tr>

<td class="text-center">

{{ $loop->iteration }}

</td>

<td class="text-center">

{{ $item->kodearsip->kode ?? '-' }}

</td>

<td>

{{ $item->nomor_surat }}

</td>

<td>

{{ $item->judul }}

</td>

<td>

{{ $item->pengirim }}

</td>

<td>

{{ $item->tujuan }}

</td>

<td>

{{ $item->perihal }}

</td>

<td class="text-center">

{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">

Tidak ada data surat keluar.

</td>

</tr>

@endforelse

</tbody>

</table>


<br><br>

<table style="border:none;width:100%;">

<tr style="border:none;">

<td style="border:none;width:55%;vertical-align:top;">

<b>Keterangan :</b>

<br>

Laporan ini dibuat secara otomatis oleh

Sistem Manajemen E-Arsip Kecamatan Mandalajati.

</td>

<td style="border:none;width:45%;"></td>

</tr>

</table>
<div style="margin-top:15px;">

    <b>
    
    Jumlah Surat Keluar :
    
    </b>
    
    {{ $suratkeluar->count() }}
    
    Surat
    
    </div>
    
    
    <table
    style="
    width:100%;
    border:none;
    margin-top:60px;
    ">
    
    <tr style="border:none;">
    
    <td
    style="
    border:none;
    width:55%;
    ">
    
    </td>
    
    <td
    style="
    border:none;
    width:45%;
    text-align:center;
    ">
    
    Bandung,
    
    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    
    <br><br>
    
    <b>
    
    Camat Mandalajati
    
    </b>
    
    <br><br><br><br><br>
    
    <div
    style="
    font-weight:bold;
    text-decoration:underline;
    ">
    
    NAMA CAMAT
    
    </div>
    
    NIP. 19xxxxxxxxxxxxxxx
    
    </td>
    
    </tr>
    
    </table>
    
    
    <div
    style="
    margin-top:60px;
    font-size:11px;
    text-align:center;
    color:#666;
    ">
    
    Dokumen ini dicetak secara otomatis oleh
    
    <b>
    
    Sistem Manajemen E-Arsip Kecamatan Mandalajati
    
    </b>
    
    pada
    
    {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
    
    WIB.
    
    </div>
    
    </body>
    
    </html>