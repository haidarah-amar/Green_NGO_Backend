<?php

namespace App\Http\Controllers;

use App\Models\KpiSummary;
use Illuminate\Http\Request;

class KpiSummaryController extends Controller
{
    public function index()
    {
        $kpiSummary = KpiSummary::all()->paginate(10);

        return response()->json($kpiSummary);
    }

    public function show($id)
    {
        $kpiSummary = KpiSummary::findOrFail($id);

        return response()->json($kpiSummary);
    }
}
