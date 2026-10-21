@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Permission</h4>

    <form action="{{ route('konfigurasi.permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('konfigurasi.permission._form')
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('konfigurasi.permission.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection