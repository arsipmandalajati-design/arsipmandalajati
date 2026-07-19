@php

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


<title>

Laporan Agenda Kegiatan

</title>



<style>


body{

    font-family:"Times New Roman", serif;

    font-size:12px;

}



.header{

    width:100%;

    padding-bottom:10px;

    margin-bottom:10px;

    border-bottom:3px solid black;

}



.logo{

    width:90px;

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



.no-border{

    border:none!important;

}



.judul{

    text-align:center;

}



.judul h2{

    margin:0;

}



.judul h1{

    margin:3px 0;

}



.subjudul{

    font-size:14px;

}



.info{

    margin-top:15px;

    margin-bottom:15px;

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



.clear{

    clear:both;

}



</style>


</head>



<body>




<!-- KOP SURAT -->

<div class="header">


<table>


<tr>


<td width="100" align="center" class="no-border">


@if($logo)

<img src="{{ $logo }}" class="logo">

@endif


</td>





<td align="center" class="no-border">


<h2>

PEMERINTAH KOTA BANDUNG

</h2>



<h1>

KECAMATAN MANDALAJATI

</h1>



<div class="subjudul">

Jl. Pasir Impun No.33 Bandung

</div>



<div class="subjudul">

Telp. (022) xxxxxxxx

</div>



<div class="subjudul">

Email : kecamatanmandalajati@gmail.com

</div>



</td>



</tr>


</table>


</div>





<hr style="border:2px solid black;margin:0;">


<hr style="border:1px solid black;margin-top:3px;">






<!-- JUDUL LAPORAN -->


<div class="judul">


<h2>

DAFTAR DATA AGENDA KEGIATAN

</h2>



<div class="subjudul">

Sistem Manajemen Arsip Digital

</div>



<div class="subjudul">

Kecamatan Mandalajati

</div>



</div>







<table style="margin-top:20px;">


<tr>


<td class="no-border">

Jenis :
Agenda Kegiatan

</td>



<td class="no-border" align="right">

Dicetak oleh :

{{ Auth::user()->name ?? 'Admin' }}

</td>



</tr>


</table>





<br>

<table>

    <thead>
    
    <tr>
    
    <th>No</th>
    
    <th>Nama Agenda</th>
    
    <th>Tanggal</th>
    
    <th>Waktu</th>
    
    <th>Tempat</th>
    
    <th>Penyelenggara</th>
    
    <th>Status</th>
    
    </tr>
    
    </thead>
    
    
    
    <tbody>
    
    
    @forelse($agenda as $item)
    
    
    <tr>
    
    
    <td align="center">
    
    {{ $loop->iteration }}
    
    </td>
    
    
    
    <td>
    
    {{ $item->nama_kegiatan }}
    
    </td>
    
    
    
    <td align="center">
    
    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
    
    </td>
    
    
    
    <td align="center">
    
    {{ $item->jam_mulai }}
    
    -
    
    {{ $item->jam_selesai }}
    
    </td>
    
    
    
    <td>
    
    {{ $item->tempat }}
    
    </td>
    
    
    
    <td>
    
    {{ $item->penyelenggara }}
    
    </td>
    
    
    
    <td align="center">
    
    {{ $item->status }}
    
    </td>
    
    
    
    </tr>
    
    
    
    @empty
    
    
    <tr>
    
    <td colspan="7" align="center">
    
    Belum ada data agenda
    
    </td>
    
    </tr>
    
    
    @endforelse
    
    
    
    </tbody>
    
    
    </table>
    
    
    
    
    
    <div class="total">
    
    
    Jumlah Agenda :
    
    {{ $agenda->count() }}
    
    Agenda
    
    
    </div>
    
    
    
    
    
    
    <div class="ttd">
    
    
    Bandung,
    
    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    
    
    
    <br>
    
    <br>
    
    <br>
    
    
    
    Camat Mandalajati
    
    
    
    
    
    <div class="nama">
    
    NAMA CAMAT
    
    </div>
    
    
    
    NIP. 19xxxxxxxxxxxxxxx
    
    
    
    </div>
    
    
    
    
    </body>
    
    
    </html>