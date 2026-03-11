<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    public function index() {
        $successStories = SuccessStory::paginate(10);
        return response()->json($successStories);
    }
    public function show($id) {
        $successStory = SuccessStory::findOrFail($id);
        return response()->json($successStory);
    }
}
