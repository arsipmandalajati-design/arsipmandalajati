@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Menu</h4>

    <form action="{{ route('konfigurasi.menu.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('konfigurasi.menu._form')
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('konfigurasi.menu.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection