<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Inventory;

class InventryController extends Controller
{
    public function index(Request $request)
    {   
        
        if ($request->ajax()) {

            $inventory = Inventory::orderBy('id', 'asc')->get();
            return DataTables::of($inventory)
                ->addColumn('multipleCheckbox', function ($row) {
                    return '<input type="checkbox" class="emp_checkbox" data-emp-id="'.$row->id.'">';
                })
                ->addColumn('type', function ($row) {
                    return $row->type;
                })
                ->addColumn('user_type', function ($row) {
                    return $row->user_type;
                })
                ->addColumn('model', function ($row) {
                    return $row->model;
                })
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->addColumn('finish', function ($row) {
                    return $row->finish;
                })
                ->addColumn('design', function ($row) {
                    return $row->design;
                })
                ->addColumn('shade', function ($row) {
                    return $row->shade;
                })
                ->addColumn('width', function ($row) {
                    return $row->width;
                })
                ->addColumn('height', function ($row) {
                    return $row->height;
                })
                ->addColumn('d_alhada', function ($row) {
                    return $row->d_alhada;
                })
                ->addColumn('d_tspl', function ($row) {
                    return $row->d_tspl;
                })
                ->addColumn('d_ultimate', function ($row) {
                    return $row->d_ultimate;
                })
                ->addColumn('d_gmp', function ($row) {
                    return $row->d_ultimate;
                })
                ->addColumn('h_alhada', function ($row) {
                    return $row->h_alhada;
                })
                ->addColumn('h_tspl', function ($row) {
                    return $row->h_tspl;
                })
                ->addColumn('h_ultimate', function ($row) {
                    return $row->h_ultimate;
                })
                ->addColumn('h_gmp', function ($row) {
                    return $row->h_gmp;
                })
                ->rawColumns(['multipleCheckbox'])
                ->make(true);
        }

        return view('admin.inventry.index');
    }

    public function inventry_upload()
    {   
        return view('admin.inventry.inventry_upload');
    }

    public function upload_inventry(Request $request, Excel $excel)
    {   
        $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    try {

        $excel->import(new InventoryImport, $request->file('file'));

        return response()->json([
            'status' => 1,
            'msg' => 'Inventory Imported Successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 0,
            'msg' => $e->getMessage()
        ]);
    }
    }
}
