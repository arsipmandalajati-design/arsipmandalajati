<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $roles = DB::table('roles')->get();
        $roleId = $request->get('role_id', optional($roles->first())->id ?? 1);
        $selectedRole = DB::table('roles')->where('id', $roleId)->first();

        $menus = DB::table('menus')->get();

        // Ambil data menu yang sudah diizinkan untuk role ini
        $roleMenus = DB::table('role_menu')
                        ->where('role_id', $roleId)
                        ->pluck('menu_id')
                        ->toArray();

        return view('admin.permissions.index', compact('roles', 'selectedRole', 'menus', 'roleMenus'));
    }

    public function update(Request $request)
    {
        $roleId = $request->role_id;
        $menuId = $request->menu_id;
        $status = $request->status; // 1 atau 0

        if ($status == 1) {
            $exists = DB::table('role_menu')
                        ->where('role_id', $roleId)
                        ->where('menu_id', $menuId)
                        ->exists();
            if (!$exists) {
                DB::table('role_menu')->insert([
                    'role_id' => $roleId,
                    'menu_id' => $menuId
                ]);
            }
        } else {
            DB::table('role_menu')
              ->where('role_id', $roleId)
              ->where('menu_id', $menuId)
              ->delete();
        }

        // Redirect kembali ke halaman role menu dengan membawa role_id yang sedang dipilih
        return redirect()->route('role-permission.index', ['role_id' => $roleId])
                         ->with('success', 'Akses menu berhasil diperbarui!');
    }
}