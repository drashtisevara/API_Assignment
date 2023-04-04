<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use Validator;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Module::query();

        // Check if search parameter exists
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        $modules = $query->paginate(10);
    
        return response()->json($modules);
        

        return response()->json([
            'status'    => 200,
            'message'   => 'Modules fetched successfully',
            'data'      => $modules
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|unique:modules',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ];
        } else {
            $module = Module::create($request->only('name', 'description'));

            return response()->json([
                'status'    => 200,
                'message'   => 'Module created successfully',
                'data'      => $module
            ]);
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|unique:modules,name,'.$id,
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status'    => 403,
                'message'   => $validator->errors()->first(),
                'data'      => []
            ];
        } else {
            $module = Module::find($request->id);
            $module->name=$request->name;
            $module->description=$request->description;
            $module->update();
            return response()->json([
                'status'    => 200,
                'message'   => 'Module updated successfully',
                'data'      => $module
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $module=Module::find($id);
            $result=$module->delete();
            return response()->json([
                'status'    => 200,
                'message'   => 'Module deleted successfully',
                'data'      => []
            ]);
        
    }
}