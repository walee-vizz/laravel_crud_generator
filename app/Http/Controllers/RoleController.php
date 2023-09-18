<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('backend.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        if (!count($request->permissions)) {
            return redirect()->back()->with('error', 'You must atlest choose one permission.');
        }
        $role = Role::create([
            'name' => $request->name,
        ]);
        $user = Auth::user();
        $log = ['user_id' => $user->id, 'activity_type' => 'Created Role', 'description' => "$user->name Created role '{$role->name}'."];
        add_activity_logs($log);
        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            // dd($permission);
            $permission = Permission::findOrCreate($permission);
            $role->givePermissionTo($permission);
        }

        return redirect()->back()->with('success', 'Role created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('backend.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id.',id',
        ]);

        $data = [
            'name' => $role->name,
        ];
        $role_updated = Role::find($role->id)->update($data);



        $permissions = $request->permissions;

        $role->permissions()->detach();
        if ($permissions) {

            foreach ($permissions as $permission) {
                $permission = Permission::findOrCreate($permission);
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->back()->with('success', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $is_role_deleted = Role::find($role->id)->delete();
        if ($is_role_deleted) {
            $user = Auth::user();
            $log = [
                'user_id' => $user->id,
                'activity_type' => 'Role Deleted',
                'description' => "User {$user->name} Deleted role '{$role->name}'",
            ];
            add_activity_logs($log);
            return redirect()->back()->with('success', 'Role deleted Successfully');
        } else {

            return redirect()->back()->with('error', 'Role has filed to delete');
        }
    }
}
