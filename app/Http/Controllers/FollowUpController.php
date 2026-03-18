<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use App\Models\FollowUP;
use Illuminate\Http\JsonResponse;

class FollowUpController extends Controller
{
    public function index(): JsonResponse
    {
        $followUps = FollowUP::with([
            'beneficiary',
            'program',
            'employee.user',
        ])->latest()->paginate(15);

        return response()->json([
            'data' => $followUps,
        ], 200);
    }

    public function store(StoreFollowUpRequest $request): JsonResponse
    {
        $followUp = FollowUP::create($request->validated());

        $followUp->load([
            'beneficiary',
            'program',
            'employee.user',
        ]);

        return response()->json([
            'message' => 'تم إنشاء المتابعة بنجاح.',
            'data' => $followUp,
        ], 201);
    }

    public function show(FollowUP $followUp): JsonResponse
    {
        $followUp->load([
            'beneficiary',
            'program',
            'employee.user',
        ]);

        return response()->json([
            'data' => $followUp,
        ], 200);
    }

    public function update(UpdateFollowUpRequest $request, FollowUP $followUp): JsonResponse
    {
        $followUp->update($request->validated());

        $followUp->load([
            'beneficiary',
            'program',
            'employee.user',
        ]);

        return response()->json([
            'message' => 'تم تحديث بيانات المتابعة بنجاح.',
            'data' => $followUp,
        ], 200);
    }

    public function destroy(FollowUP $followUp): JsonResponse
    {
        $followUp->delete();

        return response()->json([
            'message' => 'تم حذف بيانات المتابعة بنجاح.',
        ], 200);
    }
}