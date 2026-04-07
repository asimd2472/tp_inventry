<?php

namespace App\Http\Controllers;

use App\Exports\CvrExport;
use App\Models\CvrDetails;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;

class CvrController extends Controller
{

    public function cvrDetails(Request $request)
    {   
        // dd($request->all());
        $query = CvrDetails::query();

        if ($request->visitor_name) {
            $query->where('visitor_name', 'LIKE', '%' . $request->visitor_name . '%');
        }

        // Filter by Date Range (DB column)
        if ($request->from_date) {
            $query->whereDate('visitor_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('visitor_date', '<=', $request->to_date);
        }

        $cvr_details = $query->orderBy('id', 'DESC')
        ->paginate(20)
        ->appends($request->all());

        return view('admin.cvr_details.index', compact('cvr_details'));
    }

    public function export(Request $request)
    {
        return Excel::download(new CvrExport($request), 'cvr_details.xlsx');
    }
}
