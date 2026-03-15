<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuccessStoryRequest;
use App\Http\Requests\UpdateSuccessStoryRequest;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function beneficiaryStories($beneficiaryId)
{

    $stories = SuccessStory::where('beneficiary_id',$beneficiaryId)
        ->with('program')
        ->latest()
        ->get();

    return response()->json($stories);
}


    public function store(StoreSuccessStoryRequest $request)
{

    $data = $request->validated();

    $beneficiary = Auth::user()->beneficiary;

    $data['beneficiary_id'] = $beneficiary->id;


    if ($request->hasFile('image')) {

        $path = $request->file('image')->store('success_stories/images','public');

        $data['image_url'] = Storage::url($path);
    }


    if ($request->hasFile('video')) {

        $path = $request->file('video')->store('success_stories/videos','public');

        $data['video_url'] = Storage::url($path);
    }


    if ($data['income_before'] > 0) {

        $data['income_improvemnet_pct'] =
        (($data['income_after'] - $data['income_before']) / $data['income_before']) * 100;
    }


    $story = SuccessStory::create($data);

    return response()->json([
        'message' => 'تم إنشاء قصة النجاح بنجاح',
        'data' => $story
    ],201);
}


public function update(UpdateSuccessStoryRequest $request, $id)
{
    $beneficiary = Auth::user()->beneficiary;

    $story = SuccessStory::where('id',$id)
        ->where('beneficiary_id',$beneficiary->id)
        ->firstOrFail();

    $data = $request->validated();


    if ($request->hasFile('image')) {

        $path = $request->file('image')->store('success_stories/images','public');

        $data['image_url'] = Storage::url($path);
    }


    if ($request->hasFile('video')) {

        $path = $request->file('video')->store('success_stories/videos','public');

        $data['video_url'] = Storage::url($path);
    }


    if (isset($data['income_before']) || isset($data['income_after'])) {

        $before = $data['income_before'] ?? $story->income_before;
        $after = $data['income_after'] ?? $story->income_after;

        if ($before > 0) {

            $data['income_improvemnet_pct'] =
            (($after - $before) / $before) * 100;
        }
    }


    $story->update($data);


    return response()->json([
        'message' => 'تم تحديث قصة النجاح',
        'data' => $story
    ]);
}
public function destroy($id)
{
    $beneficiary = Auth::user()->beneficiary;

    $story = SuccessStory::where('id',$id)
        ->where('beneficiary_id',$beneficiary->id)
        ->firstOrFail();

    $story->delete();

    return response()->json([
        'message' => 'تم حذف قصة النجاح'
    ]);
}


}
