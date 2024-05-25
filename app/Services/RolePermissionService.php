<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RolePermissionService
{
    public static function getUserRolePermissions()
    {
        $user = Auth::user();
        $data = Role::where('id', $user->role)->first();
        $permissions = $data->permissions->pluck('name')->toArray();
        return $permissions;
    }
}
