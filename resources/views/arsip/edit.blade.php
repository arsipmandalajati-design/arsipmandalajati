@extends('layouts.app')

@section('content')

<div class="card shadow border-0">

<div class="card-body">

<h3 class="mb-4">
Edit Data Arsip
</h3>

<form action="{{ route('arsip.update',$arsip->id) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Kode Arsip</label>

<input type="text"
name="kode_arsip"
class="form-control"
value="{{ $arsip->kode_arsip }}">
</div>

<div class="mb-3">
<label>Nama Arsip</label>

<input type="text"
name="nama_arsip"
class="form-control"
value="{{ $arsip->nama_arsip }}">
</div>

<div class="mb-3">
<label>Tanggal Arsip</label>

<input type="date"
name="tanggal_arsip"
class="form-control"
value="{{ $arsip->tanggal_arsip }}">
</div>

<button class="btn btn-warning">
Update
</button>

</form>

</div>
</div>

@endsection