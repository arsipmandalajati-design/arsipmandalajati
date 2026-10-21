@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Menu</h4>

    <form action="{{ route('konfigurasi.menu.store') }}" method="POST">
        @csrf
        @include('konfigurasi.menu._form')
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('konfigurasi.menu.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection