<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpatieController extends Controller
{
    public function manage()
    {
        if (!Auth::user() && !Auth::user()->can('spatie_manage')) {
            abort(403, 'Unauthorized access');
        }
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        return view('users.spatie', compact('roles', 'permissions', 'users'));
    }

    public function addRole(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_addRole')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate(['role_name' => 'required|string|unique:roles,name']);
            Role::create(['name' => $request->role_name]);
            return back()->with('success', 'Role added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add role: ' . $e->getMessage());
        }
    }

    public function editRole(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_editRole')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'edit_role_id' => 'required|exists:roles,id',
                'edit_role_name' => 'required|string|unique:roles,name,' . $request->edit_role_id,
            ]);
            $role = Role::findOrFail($request->edit_role_id);
            $role->name = $request->edit_role_name;
            $role->save();
            return back()->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function addPermission(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_addPermission')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate(['permission_name' => 'required|string|unique:permissions,name']);
            Permission::create(['name' => $request->permission_name]);
            return back()->with('success', 'Permission added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add permission: ' . $e->getMessage());
        }
    }

    public function editPermission(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_editPermission')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'edit_permission_id' => 'required|exists:permissions,id',
                'edit_permission_name' => 'required|string|unique:permissions,name,' . $request->edit_permission_id,
            ]);
            $permission = Permission::findOrFail($request->edit_permission_id);
            $permission->name = $request->edit_permission_name;
            $permission->save();
            return back()->with('success', 'Permission updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update permission: ' . $e->getMessage());
        }
    }

    public function assignPermission(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_assignPermission')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'permission_id' => 'required|exists:permissions,id',
            ]);
            $role = Role::findOrFail($request->role_id);
            $permission = Permission::findOrFail($request->permission_id);
            if ($role->hasPermissionTo($permission)) {
                return back()->with('error', 'Role already has this permission!');
            }
            $role->givePermissionTo($permission);
            return back()->with('success', 'Permission assigned to role successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to assign permission: ' . $e->getMessage());
        }
    }

    public function assignRole(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_assignRole')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'role_id' => 'required|exists:roles,id',
            ]);
            $user = User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);
            if ($user->hasRole($role)) {
                return back()->with('error', 'User already has this role!');
            }
            $user->assignRole($role);
            return back()->with('success', 'Role assigned to user successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    public function deleteRole(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_deleteRole')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
            ]);
            $role = Role::findOrFail($request->role_id);
            foreach (User::role($role->name)->get() as $user) {
                $user->removeRole($role);
            }
            $role->delete();
            return back()->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    public function deletePermission(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('spatie_deletePermission')) {
            abort(403, 'Unauthorized access');
        }
        try {
            $request->validate([
                'permission_id' => 'required|exists:permissions,id',
            ]);
            $permission = Permission::findOrFail($request->permission_id);
            foreach (Role::permission($permission->name)->get() as $role) {
                $role->revokePermissionTo($permission);
            }
            $permission->delete();
            return back()->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }
}
