@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Role</h4>

    <form action="{{ route('konfigurasi.role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('konfigurasi.role._form')
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('konfigurasi.role.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection