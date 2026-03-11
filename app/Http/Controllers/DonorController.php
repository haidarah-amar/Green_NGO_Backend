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
        if (Donor::where('user_id', Auth::id())->exists()) {
            return response()->json([
                'message' => 'لا يمكنك إنشاء ملف تعريفي كمانح لأن لديك بالفعل واحد'
            ], 409);
        }

        $data = $request->validated();

        // Handle image_url as file or URL
        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('donor_images', 'public');
        }

        $donor = Donor::create([
            'user_id' => Auth::id(),
            ...$data
        ]);

        return response()->json([
            'message' => 'تم اكمال البيانات كمانح بنجاح',
            'data' => $donor
        ], 201);
    }

    public function show($id)
    {
        $donor = Donor::with('user')->findOrFail($id);

        return response()->json($donor);
    }

    public function update(UpdateDonorRequest $request, $id)
    {
        $donor = Donor::findOrFail($id);

        if ($donor->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $data = $request->validated();

        // Handle image_url as file or URL
        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('donor_images', 'public');
        }

        $donor->update($data);

        return response()->json([
            'message' => 'تم تحديث بيانات  بنجاح',
            'data' => $donor
        ]);
    }

    public function destroy($id)
    {
        $donor = Donor::findOrFail($id);

        if ($donor->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
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
