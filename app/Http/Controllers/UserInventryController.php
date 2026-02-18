<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

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

    public function getModels(Request $request)
    {
        $models = Inventory::where('type', $request->type)
            ->select('model')
            ->distinct()
            ->pluck('model');

        return response()->json($models);
    }

    public function getFinishes(Request $request)
    {
        $finishes = Inventory::where([
            'type'  => $request->type,
            'model' => $request->model,
        ])
        ->select('finish')
        ->distinct()
        ->pluck('finish');

        return response()->json($finishes);
    }

    public function getDesigns(Request $request)
    {
        $designs = Inventory::where([
            'type'   => $request->type,
            'model'  => $request->model,
            'finish' => $request->finish,
        ])
        ->select('design')
        ->distinct()
        ->pluck('design');

        return response()->json($designs);
    }

    public function getShades(Request $request)
    {
        $shadeString = Inventory::where('type', $request->type)
            ->where('model', $request->model)
            ->where('finish', $request->finish)
            ->where('design', $request->design)
            ->value('shade');

        if (!$shadeString) {
            return response()->json([]);
        }

        $shades = array_map('trim', explode(',', $shadeString));

        return response()->json($shades);
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
        [$width, $height] = explode(' x ', $request->size);

        $inventory = Inventory::where('type', $request->type)
            ->where('model', $request->model)
            ->where('finish', $request->finish)
            ->where('design', $request->design)
            ->where('shade', 'LIKE', '%' . $request->shade . '%')
            ->where('width', trim($width))
            ->where('height', trim($height))
            ->first();

        if (!$inventory) {
            return response()->json(['status' => 0]);
        }

        return response()->json([
            'status'    => 1,
            'id' => $inventory->id,
            'tspl'      => $inventory->tspl,
            'all_stock' => $inventory->all_stock,
            'ultimate'  => $inventory->ultimate,
        ]);
    }





}
