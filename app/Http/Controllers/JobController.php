<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission_Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        // Get all jobs
        $jobs = Job::all();

        // Return jobs as JSON
        return response()->json($jobs);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new job instance
        $job = new Job;

        // Set the job properties
        $job->name = $request->name;
        $job->description = $request->description;

        // Save the job to the database
        $job->save();

        // Return the created job as JSON
        return response()->json($job, 201);
    }

    public function show($id)
    {
        // Get the job with the specified ID
        $job = Job::findOrFail($id);

        // Return the job as JSON
        return response()->json($job);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Get the job with the specified ID
        $job = Job::findOrFail($id);

        // Update the job properties
        $job->name = $request->name;
        $job->description = $request->description;

        // Save the updated job to the database
        $job->save();

        // Return the updated job as JSON
        return response()->json($job);
    }

    public function destroy($id)
    {
        // Get the job with the specified ID
        $job = Job::findOrFail($id);

        // Delete the job from the database
        $job->delete();

        // Return a success message as JSON
        return response()->json(['message' => 'Job deleted successfully']);
    }
}