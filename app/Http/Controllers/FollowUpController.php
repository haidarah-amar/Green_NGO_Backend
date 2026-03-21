<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use Illuminate\Http\JsonResponse;

class FollowUpController extends Controller
{
      public function index(): JsonResponse
    {
        $followUps = FollowUp::with([
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
        $followUp = FollowUp::create($request->validated());

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

    public function show(FollowUp $followUp): JsonResponse
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

    public function update(UpdateFollowUpRequest $request, FollowUp $followUp): JsonResponse
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

    public function destroy(FollowUp $followUp): JsonResponse
    {
        $followUp->delete();

        return response()->json([
            'message' => 'تم حذف بيانات المتابعة بنجاح.',
        ], 200);
    }

}
