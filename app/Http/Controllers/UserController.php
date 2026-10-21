<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('pejabat');

        if ($request->has('nama') && $request->nama != '') {
            $keyword = $request->nama;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('email', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('pejabat', function($p) use ($keyword) {
                      $p->where('nip', 'LIKE', "%{$keyword}%")
                        ->orWhere('jabatan', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Pegawai',
            'nip' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:255',
            'nomor_wa' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nomor_wa' => $request->nomor_wa,
        ]);

        // Simpan data ke tabel pejabats (sesuaikan nama relasi/tabel)
        Pejabat::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'golongan' => $request->golongan,
            'unit_kerja' => $request->unit_kerja ?? 'Kecamatan Mandalajati',
        ]);

        return redirect()->route('users.index')->with('success', 'Data pegawai & pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::with('pejabat')->findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:Admin,Pegawai',
            'nip' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:255',
            'nomor_wa' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nomor_wa' => $request->nomor_wa,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Update atau buat data pejabat terkait
        Pejabat::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_pejabat' => $request->name, // Pastikan baris ini ada
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'golongan' => $request->golongan,
                'unit_kerja' => $request->unit_kerja,
            ]
        );

        return redirect()->route('users.index')->with('success', 'Data pegawai & pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus data pejabat terkait terlebih dahulu (jika tidak pakai onDelete cascade di database)
        Pejabat::where('user_id', $user->id)->delete();
        
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data berhasil dihapus.');
    }
}