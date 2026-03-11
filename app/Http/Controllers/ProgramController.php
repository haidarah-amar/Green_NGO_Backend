<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::paginate(10);
        return response()->json($programs);
    }
    public function show($id)
    {
        $program = Program::findOrFail($id);
        return response()->json($program);
    }
}
