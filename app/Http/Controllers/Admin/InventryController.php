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
                ->addColumn('model', function ($row) {
                    return $row->model;
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
                ->addColumn('tspl', function ($row) {
                    return $row->tspl;
                })
                ->addColumn('all_stock', function ($row) {
                    return $row->all_stock;
                })
                ->addColumn('ultimate', function ($row) {
                    return $row->ultimate;
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
