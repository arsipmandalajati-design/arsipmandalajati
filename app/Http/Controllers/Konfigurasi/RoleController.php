<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        return view('konfigurasi.role.index', compact('roles'));
    }

    public function create()
    {
        return view('konfigurasi.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama_role',
        ]);

        Role::create($request->all());

        return redirect()->route('konfigurasi.role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('konfigurasi.role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama_role,' . $role->id,
        ]);

        $role->update($request->all());

        return redirect()->route('konfigurasi.role.index')->with('success', 'Role berhasil diupdate.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('konfigurasi.role.index')->with('success', 'Role berhasil dihapus.');
    }
}