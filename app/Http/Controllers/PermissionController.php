<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $data = [
            'name' => $request->name,
        ];

        $is_permissions_created = Permission::create($data);

        if ($is_permissions_created) {
            $user= Auth::user();
            $log = ['user_id' => $user->id, 'activity_type' => 'created permission', 'description' => "$user->name Created permission ( $is_permissions_created->name )."];
            add_activity_logs($log);
            return redirect()->back()->with('success', 'Permission created successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('backend.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id.',id',
        ]);
        $data = [
            'name' => $request->name,
        ];

        $is_permissions_updated = tap($permission)->update($data);

        if ($is_permissions_updated) {
            $user= Auth::user();
            $log = ['user_id' => $user->id, 'activity_type' => 'Updated permission', 'description' => "$user->name Updated permission."];
            add_activity_logs($log);
            return redirect()->back()->with('success', 'Permission updated successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $is_permissions_deleted = Permission::find($permission->id)->delete();


        if ($is_permissions_deleted) {
            $user= Auth::user();
            $log = ['user_id' => $user->id, 'activity_type' => 'Deleted permission', 'description' => "$user->name  Deleted permission ( $permission->name)."];
            add_activity_logs($log);
            return redirect()->back()->with('success', 'Permission deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to delete');
        }
    }
}
