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

    public function getFinishes(Request $request)
    {
        // $finishes = Inventory::where([
        //     'type'  => $request->type,
        //     'model' => $request->model,
        // ])
        // ->select('finish')
        // ->distinct()
        // ->pluck('finish');

        // return response()->json($finishes);

        // dd($request->all());

        $finishes = Inventory::where([
            'type'  => $request->type,
            'model' => $request->model,
        ])
        ->select('finish')
        ->distinct()
        ->pluck('finish');

        $description = Inventory::where([
            'type'  => $request->type,
            'model' => $request->model,
        ])->value('description');

        return response()->json([
            'finishes'    => $finishes,
            'description' => $description
        ]);

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
            'd_alhada'      => $inventory->d_alhada,
            'd_tspl' => $inventory->d_tspl,
            'd_ultimate'  => $inventory->d_ultimate,
            'd_gmp'  => $inventory->d_gmp,

            'h_alhada'  => $inventory->h_alhada,
            'h_tspl'  => $inventory->h_tspl,
            'h_ultimate'  => $inventory->h_ultimate,
            'h_gmp'  => $inventory->h_gmp,
        ]);
    }





}
