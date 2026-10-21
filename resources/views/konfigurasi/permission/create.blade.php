@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Permission</h4>

    <form action="{{ route('konfigurasi.permission.store') }}" method="POST">
        @csrf
        @include('konfigurasi.permission._form')
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('konfigurasi.permission.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection