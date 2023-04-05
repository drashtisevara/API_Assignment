<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Permission_Module;
use Validator;

class PermissionController extends Controller
{
    // All permission show with its access
    
    public function index(Request $request)
    {
        $permissions = Permission::with('access')->get();
        return response()->json([
            'status'    => 200,
            'message'   => '',
            'data'      => $permissions
        ]);
    }
    
    // Create a Permission

    public function store(Request $request)
    {
        $rules = array(
            "name"                      => "required",
            "description"               => "required",
            "modules"                   => "required|array",     
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return [
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ];
        }
        else {   
            $permission = Permission::create($request->only('name', 'description'));
            $permission->save();       
            $modules = $request->modules;
                foreach ($modules as $module) {
                    $permissionModule = new Permission_Module();
                    $permissionModule->module_id = $module['module_id'];
                    $permissionModule->add_access = $module['add_access'];
                    $permissionModule->view_access = $module['view_access'];
                    $permissionModule->delete_access = $module['delete_access'];
                    $permissionModule->edit_access = $module['edit_access'];
                    $permissionModule->permission_id = $permission->id;
                    $permissionModule->save();
                }
            return response()->json([
            'status'  => 200,
            'message' => 'Permission created successfully',
            'data'    => $permission
            ]);
        }
    }
    // Show Permission With pagination and searching
    public function show(Request $request, $id=null)
    {       
            $query = Permission::query();
            if ($request->has('search')) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            }
            $permissions = $query->paginate(10);
            return response()->json([
                'status'    => 200,
                'message'   => 'Permission fetched successfully',
                'data'      => $permissions
            ]);
    }
    // Edit Permission
    public function update(Request $request, $id)
    {
            $rules = array(
                "name"                      => "required",
                "description"               => "required",
                "modules"                   => "required|array",          
            );
            $validator=Validator::make($request->all(),$rules);       
            if($validator->fails()){
                return [
                    'status'    => 403,
                    'message'   => $validator->errors()->first(),
                    'data'      => []
                ];
            } else {
                $permission = Permission::find($id);
        
                if (!$permission) {
                    return [
                        'status'    => 404,
                        'message'   => 'Permission not found',
                        'data'      => []
                    ];
                }   
                $permission->name = $request->input('name');
                $permission->description = $request->input('description');
                $permission->save();       
                $modules = $request->modules;
                Permission_Module::where('permission_id', $permission->id)->delete();      
                    foreach ($modules as $module) {
                        $permissionModule = new Permission_Module();
                        $permissionModule->module_id = $module['module_id'];
                        $permissionModule->add_access = $module['add_access'];
                        $permissionModule->view_access = $module['view_access'];
                        $permissionModule->delete_access = $module['delete_access'];
                        $permissionModule->edit_access = $module['edit_access'];
                        $permissionModule->permission_id = $permission->id;
                        $permissionModule->save();
                    }       
                return response()->json([
                    'status'  => 200,
                    'message' => 'Permission updated successfully',
                    'data'    => $permission
                ]);
            }
    }
    // Delete Permission

    public function destroy(Permission $permission, $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return [
                'status'    => 404,
                'message'   => 'Permission not found',
                'data'      => []
            ];
        }

    // Delete associated permission modules
        Permission_Module::where('permission_id', $permission->id)->delete();

        $permission->delete();

        return [
            'status'    => 200,
            'message'   => 'Permission deleted successfully',
            'data'      => []
        ];
    }
}