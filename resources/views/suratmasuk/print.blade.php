@php

$path = public_path('images/logo.png');

if(file_exists($path)){

    $type = pathinfo($path, PATHINFO_EXTENSION);

    $data = file_get_contents($path);

    $logo = 'data:image/'.$type.';base64,'.base64_encode($data);

}else{

    $logo='';

}

@endphp

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Laporan Surat Masuk</title>

<style>

body{

    font-family:"Times New Roman",serif;

    font-size:12px;

}

.header{

    width:100%;

    border-bottom:3px solid black;

    padding-bottom:10px;

    margin-bottom:20px;

}

table{

    width:100%;

    border-collapse:collapse;

}

th,td{

    border:1px solid black;

    padding:6px;

    font-size:12px;

}

th{

    background:#f2f2f2;

    text-align:center;

}

td{

    vertical-align:middle;

}

.total{

    margin-top:15px;

    font-weight:bold;

}

.ttd{

    width:250px;

    float:right;

    margin-top:50px;

    text-align:center;

}

.nama{

    margin-top:70px;

    text-decoration:underline;

    font-weight:bold;

}

</style>

</head>

<body>

<div class="header">

<table style="border:none;">

<tr style="border:none;">

<td width="100" align="center" style="border:none;">

@if($logo)

<img src="{{ $logo }}" width="90">

@endif

</td>

<td align="center" style="border:none;">

<h2 style="margin:0;">

PEMERINTAH KOTA BANDUNG

</h2>

<h1 style="margin:0;">

KECAMATAN MANDALAJATI

</h1>

<div style="font-size:14px;">

Jl. Pasir Impun No.33 Bandung

</div>

<div style="font-size:14px;">

Telp. (022) xxxxxxxx

</div>

<div style="font-size:14px;">

Email : kecamatanmandalajati@gmail.com

</div>

</td>

</tr>

</table>

</div>

<hr style="border:2px solid black; margin:0;">
<hr style="border:1px solid black; margin-top:2px;">
<div style="text-align:center; margin-top:15px;">

    <h2 style="margin:0;">

        DAFTAR DATA SURAT MASUK

    </h2>

    <div style="font-size:16px;">

        Sistem Manajemen Arsip Digital

        Kecamatan Mandalajati

    </div>

</div>

<table width="100%" style="border:none; margin-top:15px;">

<tr style="border:none;">

<td style="border:none;" align="left">

Jenis : Surat Masuk

</td>

<td style="border:none;" align="right">

Dicetak oleh :

{{ Auth::user()->name ?? 'Admin' }}

</td>

</tr>

</table>

<table>

<thead>

<tr>

<th width="5%">No</th>

<th width="12%">Kode Arsip</th>

<th width="18%">Nomor Surat</th>

<th width="22%">Judul Surat</th>

<th width="18%">Pengirim</th>

<th width="12%">Tanggal</th>

<th width="13%">Status</th>

</tr>

</thead>

<tbody>

@forelse($suratmasuk as $item)

<tr>

<td align="center">

{{ $loop->iteration }}

</td>

<td align="center">

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

<td align="center">

{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}

</td>

<td align="center">

{{ $item->status }}

</td>

</tr>

@empty

<tr>

<td colspan="7" align="center">

Tidak ada data surat masuk.

</td>

</tr>

@endforelse

</tbody>

</table>
<div class="total">

    Jumlah Surat Masuk :
    
    {{ $suratmasuk->count() }} Surat
    
    </div>
    
    <div class="ttd">
    
    Bandung,
    
    {{ date('d F Y') }}
    
    <br><br>
    
    Camat Mandalajati
    
    <br><br><br><br><br>
    
    <div class="nama">
    
    NAMA CAMAT
    
    </div>
    
    NIP. 19xxxxxxxxxxxxxxx
    
    </div>
    
    </body>
    
    </html>