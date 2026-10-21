<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        return view('konfigurasi.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('konfigurasi.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:menus,slug',
            'route' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        Menu::create($request->all());

        return redirect()->route('konfigurasi.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('konfigurasi.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:menus,slug,' . $menu->id,
            'route' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $menu->update($request->all());

        return redirect()->route('konfigurasi.menu.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('konfigurasi.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}