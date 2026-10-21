@extends('layouts.app')

@section('page-icon')
<i class="bi bi-send-fill"></i>
@endsection

@section('page-title')
Role
@endsection

@section('page-description')
Kelola data role yang ada di Kecamatan Mandalajati.
@endsection

@section('content')

<div class="container">
    <h4 class="mb-3">Daftar Role</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('konfigurasi.role.create') }}" class="btn btn-primary mb-3">+ Tambah Role</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->nama_role }}</td>
                <td>
                    <a href="{{ route('konfigurasi.role.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('konfigurasi.role.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus role ini? Data akses yang terkait role ini juga ikut hilang.')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center">Belum ada role</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection