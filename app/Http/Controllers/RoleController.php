<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;

class RoleController extends Controller
{
    // Show all roles that means list page
    public function index(Request $request)
    {
        $roles = Role::all();
        $perPage = $request->input('perPage', 10); // set default pagination limit to 10
        $search = $request->input('search');
            
        $roles = Role::query();
            
            if ($search) {
                $roles->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            }
            
        $roles = $roles->paginate($perPage);
        // $roles->orderBy('created_at', 'desc');
        return response()->json([
                    'status'    => 200,
                    'message'   => 'Roles fetched successfully',
                    'data'      => $roles
        ]);
    }
    
    // Create a Role
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|unique:roles',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ];
        } else {
            $role = Role::create($request->only('name', 'description'));
            $role->permissions()->sync($request->input('permissions'));
            return response()->json([
                'status'    => 200,
                'message'   => 'Role created successfully',
                'data'      => $role
            ]);
        }
    }
    // Update a role
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|unique:roles,name,'.$id,
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ];
        } else {
            $role = Role::find($request->id);
            $role->name=$request->name;
            $role->description=$request->description;
            $role->update();

            return response()->json([
                'status'    => 200,
                'message'   => 'Role updated successfully',
                'data'      => $role
            ]);
        }
    }
    // Delete a role
    public function destroy(string $id)
    {
        $role=Role::find($id);
        $result=$role->delete();
        $role->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Role deleted successfully',
            'data'      => []
        ]);
    }
    // Assign Role Permissions
    public function rolepermission(Request $request, Role $role)
    {
        $roles = $request->input('permissions', []);
        // Sync the permissions with the role
        $role->syncPermissions($permissions);

        return response()->json([
            'status'   => 200,
            'message'  => 'Permissions assigned successfully',
            'data'     => [
                'role' => $role,
                'permissions' => $permissions
            ]
        ]);
    }

}