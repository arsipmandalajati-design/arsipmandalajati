@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header & Dropdown Role -->
    <div class="mb-4">
        <label for="selectRole" class="form-label fw-bold">Pengaturan Hak Akses Menu Role</label>
        <form method="GET" action="{{ route('role-permission.index') }}" id="formRole">
            <select class="form-select rounded-pill shadow-sm border-secondary-subtle py-2" id="selectRole" name="role_id" onchange="this.form.submit()">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $selectedRole->id == $role->id ? 'selected' : '' }}>
                        {{ $role->nama_role }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Daftar Menu dengan Form Auto-Submit per Switch -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-bars me-2"></i>Daftar Menu Aplikasi</h5>
        <div class="list-group list-group-flush">
            @foreach($menus as $menu)
                @php
                    $hasAccess = in_array($menu->id, $roleMenus);
                @endphp
                <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                    <div>
                        <h6 class="mb-0 fw-semibold text-dark">{{ $menu->name }}</h6>
                        <small class="text-muted">Route / Path: {{ $menu->route ?? $menu->slug ?? '-' }}</small>
                    </div>
                    <div>
                        <!-- Setiap kali switch diklik, dia submit form kecil ke controller update lalu balik lagi -->
                        <form action="{{ route('role-permission.update') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <input type="hidden" name="status" value="{{ $hasAccess ? 0 : 1 }}">
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       style="width: 3em; height: 1.5em; cursor: pointer;"
                                       onchange="this.form.submit()"
                                       {{ $hasAccess ? 'checked' : '' }}>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection