<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DonorsImport;
use App\Imports\ProjectsImport;

class ImportController extends Controller
{

    public function importDonors(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new DonorsImport, $request->file('file'));

        return response()->json([
            'message' => 'Donors imported successfully'
        ]);
    }


    // public function importProjects(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:csv,txt'
    //     ]);

    //     Excel::import(new ProjectsImport, $request->file('file'));

    //     return response()->json([
    //         'message' => 'Projects imported successfully'
    //     ]);
    // }

}
