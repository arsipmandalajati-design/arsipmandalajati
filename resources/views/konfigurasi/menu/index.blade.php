@extends('layouts.app')

@section('page-icon')
<i class="bi bi-send-fill"></i>
@endsection

@section('page-title')
Menu
@endsection

@section('page-description')
Kelola seluruh menu di Kecamatan Mandalajati.
@endsection

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Menu</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('konfigurasi.menu.create') }}" class="btn btn-primary mb-3">+ Tambah Menu</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Menu</th>
                <th>Slug</th>
                <th>Route</th>
                <th>Icon</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $menu->name }}</td>
                <td>{{ $menu->slug }}</td>
                <td>{{ $menu->route }}</td>
                <td>{{ $menu->icon }}</td>
                <td>{{ $menu->order }}</td>
                <td>
                    <a href="{{ route('konfigurasi.menu.edit', $menu->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('konfigurasi.menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Belum ada menu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection