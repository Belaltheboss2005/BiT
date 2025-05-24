<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SpatieController extends Controller
{
    public function manage()
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        return view('users.spatie', compact('roles', 'permissions', 'users'));
    }

    public function addRole(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate(['role_name' => 'required|string|unique:roles,name']);
        Role::create(['name' => $request->role_name]);
        return back()->with('success', 'Role added successfully!');
    }

    public function editRole(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'edit_role_id' => 'required|exists:roles,id',
            'edit_role_name' => 'required|string|unique:roles,name,' . $request->edit_role_id,
        ]);
        $role = Role::findOrFail($request->edit_role_id);
        $role->name = $request->edit_role_name;
        $role->save();
        return back()->with('success', 'Role updated successfully!');
    }

    public function addPermission(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate(['permission_name' => 'required|string|unique:permissions,name']);
        Permission::create(['name' => $request->permission_name]);
        return back()->with('success', 'Permission added successfully!');
    }

    public function editPermission(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'edit_permission_id' => 'required|exists:permissions,id',
            'edit_permission_name' => 'required|string|unique:permissions,name,' . $request->edit_permission_id,
        ]);
        $permission = Permission::findOrFail($request->edit_permission_id);
        $permission->name = $request->edit_permission_name;
        $permission->save();
        return back()->with('success', 'Permission updated successfully!');
    }

    public function assignPermission(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);
        $role->givePermissionTo($permission);
        return back()->with('success', 'Permission assigned to role successfully!');
    }

    public function assignRole(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);
        return back()->with('success', 'Role assigned to user successfully!');
    }

    public function deleteRole(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        $role = Role::findOrFail($request->role_id);
        // Remove role from all users before deleting
        foreach (User::role($role->name)->get() as $user) {
            $user->removeRole($role);
        }
        $role->delete();
        return back()->with('success', 'Role deleted successfully!');
    }

    public function deletePermission(Request $request)
    {
        // if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $permission = Permission::findOrFail($request->permission_id);
        // Remove permission from all roles before deleting
        foreach (Role::permission($permission->name)->get() as $role) {
            $role->revokePermissionTo($permission);
        }
        $permission->delete();
        return back()->with('success', 'Permission deleted successfully!');
    }
}
