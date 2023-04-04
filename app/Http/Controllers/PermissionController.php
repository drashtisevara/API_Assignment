<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Permisionmodel;
use Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $permissions = Permission::with('access')->get();
        return response()->json([
            'status'    => 200,
            'message'   => '',
            'data'      => $permissions
        ]);
    }


    public function store(Request $request)
    {
        $rules = array(
            "name"                      => "required",
            "description"               => "required",
            "modules"                   => "required|array",
            "permisionmodels.*.module_id"       => "required|exists:modules,id",
            "permisionmodels.*.add_access"      => "required|boolean",
            "permisionmodels.*.edit_access"     => "required|boolean",
            "permisionmodels.*.view_access"     => "required|boolean",
            "permisionmodels.*.delete_access"   => "required|boolean",
           
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
        foreach ($request->input('modules') as $module) {
            $permisionmodel = new Permisionmodel([
                'module_id' => $module['module_id'],
                'delete_access' => $module['delete_access'],
                'edit_access' => $module['edit_access'],
                'add_access' => $module['add_access'],
                'view_access' => $module['view_access'],
            ]);
            $permission->access()->save($permisionmodel);
            return response()->json([
                'status'    => 200,
                'message'   => 'Permission created successfully',
                'data'      => $permission
            ]);
        }
   
 
   
    }
    }
    /**
     * Display the specified resource.
     */
        public function show(Request $request, $id=null)
        {
        
            $query = Permission::query();

            // Searching
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                    //   ->orWhere('description', 'like', '%'.$search.'%');
                });
            }
    
            // Pagination
            $permissions = $query->paginate(10);
            return response()->json([
                'status'    => 200,
                'message'   => 'Permission fetched successfully',
                'data'      => $permissions
            ]);
            
        }
   
    

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            "name"                      => "required",
            "description"               => "required",
            "modules"                   => "required|array",
            "modules.*.module_id"       => "required|exists:modules,id",
            "modules.*.add_access"      => "required|boolean",
            "modules.*.edit_access"     => "required|boolean",
            "modules.*.view_access"     => "required|boolean",
            "modules.*.delete_access"   => "required|boolean",
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ]);
        } else {
            $permission = Permission::findOrFail($request->id);
            $permission->name=$request->name;
            $permission->description=$request->description;

         
           
            foreach ($request->input('modules') as $module) {
                $permisionmodel = new Permisionmodel([
                    'module_id' => $module['module_id'],
                    'delete_access' => $module['delete_access'],
                    'edit_access' => $module['edit_access'],
                    'add_access' => $module['add_access'],
                    'view_access' => $module['view_access'],
                ]);
        
            // save the permission
            
        
            return response()->json(['message' => 'Permission updated successfully'], 200);

            
        $permission->load('modules');
        $permission->save();

        return response()->json([
            'status'    => 200,
            'message'   => 'Permission updated successfully',
            'data'      => $permission
        ]);
    }
}
    }
  

    public function destroy(Permission $permission)
{
    $permission->delete();

    return response()->json([
        'status'    => 200,
        'message'   => 'Permission deleted successfully',
        'data'      => []
    ]);
}

}