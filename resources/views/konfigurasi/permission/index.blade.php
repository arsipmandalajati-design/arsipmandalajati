@extends('layouts.app')

@section('page-icon')
<i class="bi bi-send-fill"></i>
@endsection

@section('page-title')
Permission
@endsection

@section('page-description')
Kelola seluruh aksi pada pengguna di Kecamatan Mandalajati.
@endsection

@section('content')

<div class="container">
    <h4 class="mb-3">Daftar Permission</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('konfigurasi.permission.create') }}" class="btn btn-primary mb-3">+ Tambah Permission</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Module</th>
                <th>Nama Aksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->module }}</td>
                <td>{{ $p->name }}</td>
                <td>
                    <a href="{{ route('konfigurasi.permission.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('konfigurasi.permission.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permission ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Belum ada permission</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection