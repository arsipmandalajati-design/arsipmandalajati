<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AksesUserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('name')->get();
        return view('konfigurasi.akses-user.index', compact('users'));
    }

    public function getMatrix(Request $request)
    {
        $userId = $request->user_id;

        $activeIds = DB::table('user_has_permissions')
            ->where('user_id', $userId)
            ->pluck('permission_id')
            ->toArray();

        $menus = Menu::orderBy('order')->get();

        $data = $menus->map(function ($menu) use ($activeIds) {
            $perms = Permission::where('module', $menu->slug)->orderBy('name')->get();

            return [
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

    public function toggle(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active) {
            DB::table('user_has_permissions')->updateOrInsert([
                'user_id' => $request->user_id,
                'permission_id' => $request->permission_id,
            ]);
        } else {
            DB::table('user_has_permissions')
                ->where('user_id', $request->user_id)
                ->where('permission_id', $request->permission_id)
                ->delete();
        }

        return response()->json(['success' => true]);
    }
}