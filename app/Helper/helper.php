<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('userCan')) {
    function userCan(string $module, string $action): bool
    {
        static $cache = null;

        if ($cache === null) {
            $roleId = auth()->user()->role_id ?? null;

            $cache = DB::table('role_has_permissions')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', $roleId)
                ->select('permissions.module', 'permissions.name')
                ->get()
                ->map(fn($r) => $r->module . '.' . $r->name)
                ->toArray();
        }

        return in_array($module . '.' . $action, $cache);
    }
}