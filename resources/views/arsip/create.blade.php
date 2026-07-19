@extends('layouts.app')

@section('page-icon')
<i class="bi bi-envelope-paper-fill"></i>
@endsection

@section('page-title')
Tambah Data Arsip
@endsection

@section('page-description')
Kecamatan Mandalajati.
@endsection

@section('content')

<select name="kode_arsip_id" class="form-select">

    <option value="">
        Pilih Kode Arsip
    </option>

    @foreach($kodearsip as $item)

    <option value="{{ $item->id }}">
        {{ $item->kode }} - {{ $item->nama_arsip }}
    </option>

    @endforeach

</select>

<div class="mb-3">
<label>Nama Arsip</label>
<input type="text"
name="nama_arsip"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Tanggal Arsip</label>
<input type="date"
name="tanggal_arsip"
class="form-control"
required>
</div>



<div class="mb-3">
    <label class="form-label">Upload File Arsip</label>

    <input type="file"
           name="file_arsip"
           class="form-control">
</div>

<button class="btn btn-primary">
Simpan
</button>

<a href="{{ route('arsip.index') }}"
class="btn btn-secondary">
Kembali
</a>

</form>

</div>
</div>

@endsection