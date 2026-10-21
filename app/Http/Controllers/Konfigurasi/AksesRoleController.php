<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AksesRoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        return view('konfigurasi.akses-role.index', compact('roles'));
    }

    // dipanggil AJAX saat pilih role
    public function getMatrix(Request $request)
    {
        $roleId = $request->role_id;

        $activeIds = DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->pluck('permission_id')
            ->toArray();

        $menus = Menu::orderBy('order')->get();

        $data = $menus->map(function ($menu) use ($activeIds) {
            $perms = Permission::where('module', $menu->slug)->orderBy('name')->get();

            return [
                'menu_id' => $menu->id,
                'nama_menu' => $menu->name,
                'actions' => $perms->map(function ($p) use ($activeIds) {
                    return [
                        'permission_id' => $p->id,
                        'name' => $p->name,
                        'active' => in_array($p->id, $activeIds),
                    ];
                }),
            ];
        })->filter(fn($m) => count($m['actions']) > 0)->values();

        return response()->json($data);
    }

    // dipanggil AJAX tiap toggle diklik, auto-save
    public function toggle(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active) {
            DB::table('role_has_permissions')->updateOrInsert([
                'role_id' => $request->role_id,
                'permission_id' => $request->permission_id,
            ]);
        } else {
            DB::table('role_has_permissions')
                ->where('role_id', $request->role_id)
                ->where('permission_id', $request->permission_id)
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    // fitur "Copy dari role"
    public function copyFromRole(Request $request)
    {
        $request->validate([
            'source_role_id' => 'required|exists:roles,id',
            'target_role_id' => 'required|exists:roles,id',
        ]);

        DB::table('role_has_permissions')->where('role_id', $request->target_role_id)->delete();

        $source = DB::table('role_has_permissions')->where('role_id', $request->source_role_id)->get();
        foreach ($source as $item) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $request->target_role_id,
                'permission_id' => $item->permission_id,
            ]);
        }

        return response()->json(['success' => true]);
    }
}