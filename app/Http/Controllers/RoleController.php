<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function index()
    {
        $roles = Role::with('users')->get();
        return view('roles.list', compact('roles'));
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        DB::beginTransaction();
        $role = Role::create(['name' => $request->name]);

        foreach ($request->all() as $key => $permission) {
            if ($permission == 'name' || $permission == '_token') {
                continue;
            }

            if (!Permission::where('name', $key)->exists()) {
                Permission::create(['name' => $key, 'guard_name' => 'web']);
            }
            if ($permission == "on") {
                $role->givePermissionTo($key);
            }
        }
        DB::commit();

        return redirect()->back()->with('success', 'Rol oluşturuldu');
    }

    function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        $role = Role::find($request->id);

        if (!$role) {
            return back()->withErrors(['Rol bulunamadı']);
        }

        if ($role->name != $request->name) {
            $request->validate([
                'name' => 'unique:roles,name',
            ]);
        }

        $role->name = $request->name;
        $role->save();

        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission->name);
        }

        foreach ($request->all() as $key => $permission) {
            if ($permission == 'name' || $key == 'id') {
                continue;
            }

            if ($permission == 'on') {
                $role->givePermissionTo($key);
            }
        }

        DB::commit();

        return back()->with('success', 'Rol düzenlendi');
    }

    function destroy($id)
    {

        $role = Role::find($id);
        if (!$role) {
            return redirect()->back()->withErrors(['Rol bulunamadı!']);
        }

        DB::beginTransaction();
        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission->name);
        }

        foreach ($role->users as $user) {
            $user->removeRole($role->name);
        }

        $role->delete();
        DB::commit();
        return  redirect()->back()->with('success', 'Rol silindi');
    }
}
