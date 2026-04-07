<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CvrDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CvrController extends Controller
{
    
    public function cvr_save(Request $request){
        // dd($request->id);
        try {

            $dateTime = Carbon::parse($request->date);
            $date = $dateTime->toDateString();
            $time = $dateTime->toTimeString();

            $check_cvr = CvrDetails::where('cvr_id', $request->id)->first();
            
            if($check_cvr){
                $check_cvr->update([
                    'user_id' => $request->user_id,
                    'visitor_name' => $request->visitorName,
                    'cvr_data' => $request->json()->all()
                ]);
            }else{
                CvrDetails::create([
                    'visitor_date' => $date,
                    'visitor_time' => $time,
                    'cvr_id' => $request->id,
                    'user_id' => $request->user_id,
                    'visitor_name' => $request->visitorName,
                    'cvr_data' => $request->json()->all()
                ]);
            }

            return response()->json([
                'status' => 1,
                'msg' => 'CVR data saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

}
