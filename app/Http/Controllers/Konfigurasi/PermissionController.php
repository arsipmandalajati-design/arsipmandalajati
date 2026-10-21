<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get();
        return view('konfigurasi.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('konfigurasi.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'module' => 'required|string|max:50',
        ]);

        Permission::create($request->all());

        return redirect()->route('konfigurasi.permission.index')->with('success', 'Permission berhasil ditambahkan.');
    }

    public function edit(Permission $permission)
    {
        return view('konfigurasi.permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'module' => 'required|string|max:50',
        ]);

        $permission->update($request->all());

        return redirect()->route('konfigurasi.permission.index')->with('success', 'Permission berhasil diupdate.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('konfigurasi.permission.index')->with('success', 'Permission berhasil dihapus.');
    }
}