<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptGrantRequest;
use App\Http\Requests\StoreGrantRequest;
use App\Http\Requests\UpdateGrantRequest;
use App\Models\Donor;
use App\Models\Grant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class GrantController extends Controller
{
    public function index()
    {
        $grants = Grant::with(['donor', 'projects'])->latest()->paginate(10);

        return response()->json([
            'data' => $grants
        ], 200);
    }

    public function show(Grant $grant)
    {
        $grant->load(['donor', 'projects']);

        return response()->json([
            'data' => $grant
        ], 200);
    }

    public function store(StoreGrantRequest $request)
    {
        $data = $request->validated();
        $data['donor_id'] = Auth::user()->donor->id;

        $projectIds = $data['projects'] ?? [];
        unset($data['projects']);

        $grant = Grant::create($data);

        if (!empty($projectIds)) {
            $grant->projects()->sync($projectIds);
        }

        $received_amount = $grant->received_amount_usd;

        $donor = Donor::findOrFail($grant->donor_id);
        $donor->increment('total_grants_usd', $received_amount);

        $grant->load(['donor', 'projects']);

        return response()->json([
            'message' => 'تم انشاء المنحة بنجاح.',
            'data' => $grant
        ], 201);
    }

    public function update(UpdateGrantRequest $request, Grant $grant)
{
    if ($grant->donor_id !== Auth::user()->donor->id) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 403);
    }

    DB::transaction(function () use ($request, $grant) {
        $oldReceivedAmount = $grant->received_amount_usd;

        $data = $request->validated();
        $data['donor_id'] = Auth::user()->donor->id;

        $projectIds = $data['projects'] ?? null;
        unset($data['projects']);

        $grant->update($data);

        if ($projectIds !== null) {
            $grant->projects()->sync($projectIds);
        }

        $newReceivedAmount = $grant->fresh()->received_amount_usd;
        $difference = $newReceivedAmount - $oldReceivedAmount;

        if ($difference != 0) {
            $donor = Donor::findOrFail($grant->donor_id);
            $donor->increment('total_grants_usd', $difference);
        }

        $grant->load(['donor', 'projects']);
    });

    $grant->refresh()->load(['donor', 'projects']);

    return response()->json([
        'message' => 'تم تحديث بيانات المنحة بنجاح.',
        'data' => $grant
    ], 200);
}

public function destroy(Grant $grant)
{
    if ($grant->donor_id !== Auth::user()->donor->id) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 403);
    }

    DB::transaction(function () use ($grant) {
        $receivedAmount = $grant->received_amount_usd;

        $donor = Donor::findOrFail($grant->donor_id);
        $donor->decrement('total_grants_usd', $receivedAmount);

        $grant->projects()->detach();
        $grant->status = 'cancelled';
        $grant->save();
    });

    return response()->json([
        'message' => 'تم الغاء المنحة بنجاح.'
    ], 200);
}


public function acceptGrant(AcceptGrantRequest $request)
{
    $user = Auth::user();

    if (
        !$user->employee ||
        !in_array($user->employee->position, ['system_admin', 'finance_officer'])
    ) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 403);
    }

    $data = $request->validated();

    $grant = null;

    DB::transaction(function () use ($data, &$grant) {
        $grant = Grant::with(['donor', 'projects'])->findOrFail($data['grant_id']);

        $newAmount = $data['new_amount'];

        $grant->increment('received_amount_usd', $newAmount);

        $donor = Donor::findOrFail($grant->donor_id);
        $donor->increment('total_grants_usd', $newAmount);

        $grant->refresh()->load(['donor', 'projects']);
    });

    return response()->json([
        'message' => 'تم قبول المنحة بنجاح.',
        'data' => $grant
    ], 200);
}

public function getGrantsByProject($projectId)
{
    $grants = Grant::with(['donor', 'projects'])
        ->whereHas('projects', function ($query) use ($projectId) {
            $query->where('projects.id', $projectId);
        })
        ->get();

    return response()->json([
        'message' => 'جميع المنح المرتبطة بهذا المشروع.',
        'data' => $grants
    ], 200);
}

public function getGrantsByDonor($donorId)
{
    $grants = Grant::with(['donor', 'projects'])
        ->where('donor_id', $donorId)
        ->get();

    return response()->json([
        'message' => 'جميع المنح المرتبطة بهذا المانح.',
        'data' => $grants
    ], 200);
}

}