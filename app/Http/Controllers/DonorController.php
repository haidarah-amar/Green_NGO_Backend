<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{

    public function index()
    {
        $donors = Donor::with('user')->paginate(10);

        return response()->json($donors);
    }

    public function store(StoreDonorRequest $request)
    {
            if(Donor::where('user_id',Auth::id())->exists()){
        return response()->json([
            'message' => 'لا يمكنك إنشاء ملف تعريفي كمانح لأن لديك بالفعل واحد'
        ],409);
    }
        $donor = Donor::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return response()->json([
            'message' => 'تم اكمال البيانات كمانح بنجاح',
            'data' => $donor
        ],201);
    }

    public function show($id)
    {
        $donor = Donor::with('user')->findOrFail($id);

        return response()->json($donor);
    }

    public function update(UpdateDonorRequest $request,$id)
    {
        $donor = Donor::findOrFail($id);


        if($donor->user_id !== Auth::id()){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        }

        $donor->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث بيانات  بنجاح',
            'data' => $donor
        ]);
    }

    public function destroy($id)
    {
        $donor = Donor::findOrFail($id);

        if($donor->user_id !== Auth::id()){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        }

        $donor->delete();

        return response()->json([
            'message' => 'تم حذف بيانات  بنجاح'
        ]);
    }

    public function getPartners()
    {
        $partners = Donor::orderByDesc('total_grants_usd')->with('user')
            ->take(10)
            ->get();

        return response()->json($partners);
    }
}
