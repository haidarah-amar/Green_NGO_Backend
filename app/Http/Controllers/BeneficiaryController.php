<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{

    public function index()
    {
        $beneficiaries = Beneficiary::with('user')->paginate(10);

        return response()->json($beneficiaries);
    }

    public function show($id)
    {
        $beneficiary = Beneficiary::with('user')->findOrFail($id);

        return response()->json($beneficiary);
    }

    public function store(StoreBeneficiaryRequest $request)
    {
        $beneficiary = Beneficiary::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return response()->json([
            'message' => 'تم اكمال البيانات كمستفيد بنجاح',
            'data' => $beneficiary
        ], 201);
    }

    public function update(UpdateBeneficiaryRequest $request, $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);

        $beneficiary->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث البيانات بنجاح',
            'data' => $beneficiary
        ]);
    }

    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);

        $beneficiary->delete();

        return response()->json([
            'message' => 'تم حذف البيانات بنجاح'
        ]);
    }
}