<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PejabatController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pejabat beserta relasi ke user
        $query = Pejabat::with('user')->latest();

        if ($request->has('nama') && $request->nama != '') {
            $keyword = $request->nama;
            $query->where(function($q) use ($keyword) {
                $q->where('nip', 'LIKE', "%{$keyword}%")
                  ->orWhere('jabatan', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama_pejabat', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('user', function($u) use ($keyword) {
                      $u->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $pejabats = $query->get();

        return view('pejabat.index', compact('pejabats'));
    }

    public function create()
    {
        return view('pejabat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pejabat' => 'required',
            'nip' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email|unique:users,email',
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $ttd = null;
        if ($request->hasFile('tanda_tangan')) {
            $ttd = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
        }

        // 1. Buat Akun User terlebih dahulu untuk mendapatkan user_id
        $user = User::create([
            'name' => $request->nama_pejabat,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'Pegawai', // Sesuaikan dengan kolom role aplikasi kamu
        ]);

        // 2. Simpan Data Pejabat dengan menghubungkan user_id
        Pejabat::create([
            'user_id' => $user->id,
            'nama_pejabat' => $request->nama_pejabat,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'golongan' => $request->golongan ?? null,
            'unit_kerja' => $request->unit_kerja ?? 'Kecamatan Mandalajati',
            'tanda_tangan' => $ttd,
        ]);

        return redirect()
            ->route('pejabat.index')
            ->with('success', 'Data pejabat dan akun user berhasil disinkronkan!');
    }

    public function edit($id)
    {
        $pejabat = Pejabat::findOrFail($id);
        return view('pejabat.edit', compact('pejabat')); // Pastikan variabel '$pejabat' dikirim ke view
    }

    // Memproses pembaruan data
    public function update(Request $request, $id)
{
    $pejabat = Pejabat::findOrFail($id);

    $request->validate([
        'nama_pejabat' => 'required|string|max:255',
        'nip'          => 'required|string|max:255',
        'jabatan'      => 'required|string',
        'email'        => 'required|email|unique:users,email,' . $pejabat->user_id,
        'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ]);

    // 1. Update nama dan email pada tabel users yang terikat
    if ($pejabat->user_id) {
        $user = User::find($pejabat->user_id);
        if ($user) {
            $user->update([
                'name'  => $request->nama_pejabat,
                'email' => $request->email,
            ]);
        }
    }

    // 2. Update data pada tabel pejabat (pastikan nama_pejabat ikut terisi)
    $data = [
        'nama_pejabat' => $request->nama_pejabat,
        'nip'          => $request->nip,
        'jabatan'      => $request->jabatan,
        'golongan'     => $request->golongan ?? $pejabat->golongan,
        'unit_kerja'   => $request->unit_kerja ?? $pejabat->unit_kerja,
    ];

    if ($request->hasFile('tanda_tangan')) {
        if ($pejabat->tanda_tangan && Storage::disk('public')->exists($pejabat->tanda_tangan)) {
            Storage::disk('public')->delete($pejabat->tanda_tangan);
        }
        $data['tanda_tangan'] = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
    }

    $pejabat->update($data);

    return redirect()->route('pejabat.index')->with('success', 'Data pejabat berhasil diperbarui.');
}

    public function destroy(Pejabat $pejabat)
    {
        // Hapus akun user yang terikat jika ada
        if ($pejabat->user_id) {
            $user = User::find($pejabat->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $pejabat->delete();

        return redirect()->route('pejabat.index')
            ->with('success', 'Data pejabat dan akun user berhasil dihapus');
    }
}