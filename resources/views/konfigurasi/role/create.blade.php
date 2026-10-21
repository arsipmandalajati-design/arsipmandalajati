@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Role</h4>

    <form action="{{ route('konfigurasi.role.store') }}" method="POST">
        @csrf
        @include('konfigurasi.role._form')
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('konfigurasi.role.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection