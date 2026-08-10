<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteVisitRequest;
use App\Models\SiteVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('super_admin.sitevisit.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
    
    public function store(StoreSiteVisitRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // dd($data);

        [$lat, $lng] = $this->parseGps($data['gps'] ?? null);

        $qty = $data['qty'] ?? [];
        $doors   = (int) ($qty['doors'] ?? 0);
        $windows = (int) ($qty['windows'] ?? 0);
        $frames  = (int) ($qty['frames'] ?? 0);
        $others  = (int) ($qty['others'] ?? 0);

        $visit = SiteVisit::create([
            'user_id'            => $request->user()?->id,
            'executive_name'     => $request->user()?->name,
            'executive_email'    => $request->user()?->email,
            'visit_date'         => $data['visit_date'],
            'visit_time'         => $data['visit_time'],

            'customer_name'      => $data['customer_name'],
            'mobile'             => $data['mobile'],
            'alt_mobile'         => $data['alt_mobile'] ?? null,
            'customer_email'     => $data['customer_email'] ?? null,

            'state'              => $data['state'],
            'district'           => $data['district'],
            'pincode'            => $data['pincode'] ?? null,
            'latitude'           => $lat,
            'longitude'          => $lng,
            'maps_link'          => $data['maps_link']
                ?? ($lat && $lng ? "https://www.google.com/maps?q={$lat},{$lng}" : null),

            'construction_stage' => $data['construction_stage'],
            'products'           => $data['products'],
            'categories'         => $data['categories'] ?? [],

            'qty_doors'          => $doors,
            'qty_windows'        => $windows,
            'qty_frames'         => $frames,
            'qty_others'         => $others,
            'qty_total'          => $doors + $windows + $frames + $others,

            'timeline'           => $data['timeline'],
            'budget'             => $data['budget'] ?? null,
            'competitor'         => $data['competitor'] ?? null,

            'interest'           => $data['interest'],
            'follow_up'          => isset($data['follow_up']),
            'remarks'            => $data['remarks'] ?? null,
        ]);

        return redirect()
            ->route('site-visit.form')
            ->with('status', "Visit report #{$visit->id} saved successfully.");
    }

    /** Simple listing for review. */
    

    /** "12.345678, 77.123456" -> [lat, lng] */
    private function parseGps(?string $gps): array
    {
        if (! $gps || ! str_contains($gps, ',')) {
            return [null, null];
        }

        [$lat, $lng] = array_map('trim', explode(',', $gps, 2));

        return [is_numeric($lat) ? $lat : null, is_numeric($lng) ? $lng : null];
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
