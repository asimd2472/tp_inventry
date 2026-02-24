<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

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
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->addColumn('design', function ($row) {
                    return $row->design;
                })
                ->addColumn('dimention', function ($row) {
                    return $row->dimention;
                })
                ->addColumn('colour', function ($row) {
                    return $row->colour;
                })
                ->addColumn('orientation', function ($row) {
                    return $row->orientation;
                })
                ->addColumn('special_feature', function ($row) {
                    return $row->special_feature;
                })
                ->addColumn('hyderabad', function ($row) {
                    return $row->hyderabad;
                })
                ->addColumn('ncr', function ($row) {
                    return $row->ncr;
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

        DB::beginTransaction();

        try {

            // Inventory::truncate();
            Inventory::query()->delete();

            $excel->import(new InventoryImport, $request->file('file'));

            DB::commit();

            return response()->json([
                'status' => 1,
                'msg' => 'Inventory Imported Successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
