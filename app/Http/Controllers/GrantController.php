<?php

namespace App\Http\Controllers;

use App\Models\Grant;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGrantRequest;
use App\Http\Requests\UpdateGrantRequest;
use Illuminate\Support\Facades\DB;

class GrantController extends Controller
{
public function index()
{
    $grants = Grant::with(['donor','projects'])
        ->latest()
        ->paginate(10);

    return response()->json($grants);
}
public function show($id)
{
    $grant = Grant::with(['donor','projects'])
        ->findOrFail($id);

    return response()->json($grant);
}
public function store(StoreGrantRequest $request)
{
    $donor = Auth::user()->donor;

    $data = $request->validated();

    $data['donor_id'] = $donor->id;

   DB::transaction(function () use ($data, $donor, &$grant) {

    $grant = Grant::create($data);

    dd($data['projects']);

    if (!empty($data['projects'])) {
        $grant->projects()->sync($data['projects']);
    }

    $donor->increment('total_grants_usd', $grant->total_amount_usd);

});


    return response()->json([
        'message' => 'تم إضافة المنحة بنجاح',
        'data' => $grant
    ],201);
}
public function update(UpdateGrantRequest $request, $id)
{
    $donor = Auth::user()->donor;

    $grant = Grant::where('id', $id)
        ->where('donor_id', $donor->id)
        ->firstOrFail();

    $oldAmount = $grant->total_amount_usd;

    $data = $request->validated();

    DB::transaction(function () use ($grant, $data, $donor, $oldAmount) {

        $grant->update($data);

        if (!empty($data['projects'])) {
            $grant->projects()->sync($data['projects']);
        }

        $newAmount = $grant->total_amount_usd;

        $difference = $newAmount - $oldAmount;

        $donor->increment('total_grants_usd', $difference);

    });

    return response()->json([
        'message' => 'تم تحديث معلومات المنحة بنجاح',
        'data' => $grant->load('projects')
    ]);
}


public function destroy($id)
{

    $donor = Auth::user()->donor;

    $grant = Grant::where('id',$id)
        ->where('donor_id',$donor->id)
        ->firstOrFail();


    $donor->decrement('total_grants_usd', $grant->total_amount_usd);


    $grant->delete();


    return response()->json([
        'message' => 'تم الغاء المنحة بنجاح'
    ]);
}

public function grantsByDonor($donorId)
{

    $grants = Grant::where('donor_id',$donorId)
        ->with(['projects','donor'])
        ->get();

    return response()->json($grants);
}
public function grantsByProject($projectId)
{

    $grants = Grant::whereHas('projects', function ($q) use ($projectId) {

        $q->where('project_id',$projectId);

    })->with(['donor','projects'])->get();
    return response()->json($grants);
}
}