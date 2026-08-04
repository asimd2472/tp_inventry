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
        $user = auth()->user();
        $tab = in_array($request->get('tab'), ['all', 'my'], true) ? $request->get('tab') : 'my';
        $search = trim((string) $request->get('search', ''));

        if ($user && (int) $user->is_admin === 1 && $tab === 'all') {
            $request->merge(['export_all' => true]);
        } else {
            $request->merge([
                'export_all' => false,
                'user_id' => $user ? $user->id : null,
            ]);
        }

        if ($search !== '') {
            $request->merge(['search_export' => $search]);
        }

        return Excel::download(new CvrExport($request), 'cvr_details.xlsx');
    }

    public function cvr(){
        return view('admin.cvr.index');
    }
}
