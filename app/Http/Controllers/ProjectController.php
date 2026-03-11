<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
        return response()->json($projects);
    }
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }
}
