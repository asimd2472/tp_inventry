<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class UserInventryController extends Controller
{
    public function index(){
        $types = Inventory::select('type')
                ->whereNotNull('type')
                ->distinct()
                ->orderBy('type')
                ->pluck('type');

        return view('user.inventry_check', compact('types'));
    }

    public function getUserTypes(Request $request)
    {
        $userTypes = Inventory::where('type', $request->type)
            ->select('user_type')
            ->whereNotNull('user_type')
            ->distinct()
            ->pluck('user_type');

        return response()->json($userTypes);
    }

    public function getModels(Request $request)
    {
        $models = Inventory::where('type', $request->type)
            ->select('model')
            ->distinct()
            ->pluck('model');

        return response()->json($models);
    }

    // public function getFinishes(Request $request)
    // {

    //     $finishes = Inventory::where([
    //         'type'  => $request->type,
    //         'model' => $request->model,
    //     ])
    //     ->select('finish')
    //     ->distinct()
    //     ->pluck('finish');

    //     $description = Inventory::where([
    //         'type'  => $request->type,
    //         'model' => $request->model,
    //     ])->value('description');

    //     return response()->json([
    //         'finishes'    => $finishes,
    //         'description' => $description
    //     ]);

    // }

    public function getDesigns(Request $request)
    {
        $designs = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
        ])
        ->select('design')
        ->distinct()
        ->pluck('design');

        $description = Inventory::where([
            'type'  => $request->type,
            'model' => $request->model,
        ])->value('description');

        return response()->json([
            'designs'    => $designs,
            'description' => $description
        ]);
    }

    
    public function getDimention(Request $request){
        $dimention = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
            'design' => $request->design,
        ])
        ->select('dimention')
        ->distinct()
        ->pluck('dimention');

        return response()->json($dimention);
    }

    public function getColour(Request $request){
        $colour = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
            'design' => $request->design,
            'dimention' => $request->dimention,
        ])
        ->select('colour')
        ->distinct()
        ->pluck('colour');

        return response()->json($colour);
    }

    

    public function getOrientation(Request $request)
    {
        $orientation = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
            'design' => $request->design,
            'dimention' => $request->dimention,
            'colour' => $request->colour,
        ])
        ->select('orientation')
        ->distinct()
        ->pluck('orientation');

        return response()->json($orientation);
    }

    public function getSpecialFeature(Request $request)
    {
        $getSpecialFeature = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
            'design' => $request->design,
            'dimention' => $request->dimention,
            'colour' => $request->colour,
            'orientation' => $request->orientation,
        ])
        ->select('special_feature')
        ->distinct()
        ->pluck('special_feature');

        return response()->json($getSpecialFeature);
    }

    

    public function getSizes(Request $request)
    {
        $sizes = Inventory::where('type', $request->type)
        ->where('model', $request->model)
        ->where('finish', $request->finish)
        ->where('design', $request->design)
        ->where('shade', 'LIKE', '%' . $request->shade . '%')
        ->get()
        ->map(function ($item) {
            return $item->width . ' x ' . $item->height;
        })
        ->unique()
        ->values();

        return response()->json($sizes);
    }

    public function getStock(Request $request)
    {
        // [$width, $height] = explode(' x ', $request->size);

        // $inventory = Inventory::where('type', $request->type)
        //     ->where('model', $request->model)
        //     ->where('finish', $request->finish)
        //     ->where('design', $request->design)
        //     ->where('shade', 'LIKE', '%' . $request->shade . '%')
        //     ->where('width', trim($width))
        //     ->where('height', trim($height))
        //     ->first();

        // $inventory = Inventory::where('type', $request->type)
        //     ->where('model', $request->model)
        //     ->where('design', $request->design)
        //     ->where('dimention', $request->dimention)
        //     ->where('colour', $request->colour)
        //     ->where('orientation', $request->orientation)
        //     ->where('special_feature', $request->special_feature)
        //     ->first();

        $query = Inventory::query();

        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->model) {
            $query->where('model', $request->model);
        }
        if ($request->design) {
            $query->where('design', $request->design);
        }
        if ($request->dimention) {
            $query->where('dimention', $request->dimention);
        }
        if ($request->colour) {
            $query->where('colour', $request->colour);
        }
        if ($request->orientation) {
            $query->where('orientation', $request->orientation);
        }
        if ($request->special_feature) {
            $query->where('special_feature', $request->special_feature);
        }
        $inventory = $query->first();

        // dd($inventory);

        if (!$inventory) {
            return response()->json(['status' => 0]);
        }

        return response()->json([
            'status'    => 1,
            'id' => $inventory->id,
            'hyderabad'      => $inventory->hyderabad,
            'ncr' => $inventory->ncr,
        ]);
    }



    public function inventorySend(Request $request)
    {
        $user_mail = Auth::user()->email;

        // Export inventory data to Excel
        $fileName = 'inventory_data_' . time() . '.xlsx';
        $filePath = storage_path('app/' . $fileName);

        // Use Laravel Excel to export
        \Maatwebsite\Excel\Facades\Excel::store(new \App\Exports\InventoryExport, $fileName);

        // Send email with attachment
        \Mail::raw('Please find attached the inventory data.', function ($message) use ($user_mail, $filePath, $fileName) {
            $message->to($user_mail)
                ->subject('Inventory Data')
                ->attach($filePath, [
                    'as' => $fileName,
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]);
        });

        // Optionally, delete the file after sending
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return response()->json(['status' => 1, 'msg' => 'Inventory data sent successfully to your email.']);
    }


}
