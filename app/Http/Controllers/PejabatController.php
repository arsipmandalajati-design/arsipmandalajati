<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use Illuminate\Http\Request;

class PejabatController extends Controller
{

    public function index()
    {
        $pejabats = Pejabat::latest()->get();

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
        'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ]);

    $ttd = null;

    if($request->hasFile('tanda_tangan')){
        $ttd = $request->file('tanda_tangan')
                    ->store('tanda_tangan','public');
    }

    Pejabat::create([
        'nama_pejabat' => $request->nama_pejabat,
        'nip' => $request->nip,
        'jabatan' => $request->jabatan,
        'tanda_tangan' => $ttd,
    ]);

    return redirect()
            ->route('pejabat.index')
            ->with('success','Data pejabat berhasil ditambahkan');
}

    public function edit(Pejabat $pejabat)
    {
        return view('pejabat.edit',compact('pejabat'));
    }

    public function update(Request $request, Pejabat $pejabat)
    {

        $request->validate([

            'nama_pejabat'=>'required',

            'nip'=>'required',

            'jabatan'=>'required',

            'tanda_tangan'=>'nullable|image'

        ]);

        if($request->hasFile('tanda_tangan')){

            $file = $request->file('tanda_tangan')
                    ->store('tanda_tangan','public');

            $pejabat->tanda_tangan = $file;

        }

        $pejabat->nama_pejabat = $request->nama_pejabat;

        $pejabat->nip = $request->nip;

        $pejabat->jabatan = $request->jabatan;

        $pejabat->save();

        return redirect()->route('pejabat.index')
            ->with('success','Data berhasil diupdate');

    }

    public function destroy(Pejabat $pejabat)
    {

        $pejabat->delete();

        return redirect()->route('pejabat.index')
            ->with('success','Data berhasil dihapus');

    }

}