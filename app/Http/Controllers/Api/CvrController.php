<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CvrDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class CvrController extends Controller
{
    
    public function cvr_save(Request $request){
        // dd($request->id);
        try {

            $dateTimeIST = Carbon::parse($request->date)->setTimezone('Asia/Kolkata');
            $date = $dateTimeIST->toDateString();
            $time = $dateTimeIST->toTimeString(); 

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


    public function upload_cvr_excel(Request $request){
        // $request->validate([
        //     'user_id' => 'required',
        //     'excel'   => 'required|file'
        // ]);



        $rows = Excel::toArray([], $request->file('excel'))[0];

        // Remove heading row
        array_shift($rows);

        // dd($rows);

        $response = [];

        // foreach ($rows as $row) {

        //     $meetingId = (string) round(microtime(true) * 1000) . rand(100,999);

        //     $actionPoints = [];

        //     if (!empty($row[11])) {
        //         $tasks = preg_split("/\r\n|\n|\r/", $row[11]);

        //         foreach ($tasks as $index => $task) {

        //             if (trim($task) == '') {
        //                 continue;
        //             }

        //             $actionPoints[] = [
        //                 "id" => "ap_{$meetingId}_{$index}",
        //                 "task" => trim($task),
        //                 "owner" => "Assigned Manually",
        //                 "deadline" => Carbon::parse($row[3])->format('Y-m-d'),
        //                 "priority" => "Medium",
        //                 "status" => "Pending"
        //             ];
        //         }
        //     }

        //     $date = Carbon::instance(
        //         ExcelDate::excelToDateTimeObject($row[3])
        //     )
        //     ->setTime(9, 52, 0)
        //     ->format('Y-m-d\TH:i:s.000\Z');

        //     $response[] = [
        //         "user_id" => (int)$request->user_id,
        //         "id" => $meetingId,
        //         "date" => Carbon::instance(
        //             \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])
        //         )->format('Y-m-d'),
        //         "original_date" => $date,
        //         "dealer" => [
        //             "name" => $row[7],
        //             "distributorName" => $row[5],
        //             "locationName" => $row[8],
        //             "customerName" => null,
        //             "customerPhone" => null
        //         ],

        //         "summary" => $row[10],
        //         "transcript" => $row[9],

        //         "actionPoints" => $actionPoints,

        //         "complaints" => [],

        //         "sentiment" => "Neutral",
        //         "sentimentReason" => null,

        //         "images" => [],

        //         "visitorName" => $row[6]
        //     ];
        // }

        foreach ($rows as $row) {

            $meetingId = (string) round(microtime(true) * 1000) . rand(100,999);

            $dateTime = Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])
            )->setTime(9, 52, 0);

            $date = $dateTime->format('Y-m-d');
            $time = $dateTime->format('H:i:s');

            $actionPoints = [];

            if (!empty($row[11])) {

                $tasks = preg_split("/\r\n|\n|\r/", $row[11]);

                foreach ($tasks as $index => $task) {

                        if (trim($task) == '') {
                            continue;
                        }

                        $actionPoints[] = [
                            "id" => "ap_{$meetingId}_{$index}",
                            "task" => trim($task),
                            "owner" => "Assigned Manually",
                            "deadline" => $date,
                            "priority" => "Medium",
                            "status" => "Pending"
                        ];
                    }
                }

            // Build JSON once
            $cvrData = [
                "user_id" => (int)$request->user_id,
                "id" => $meetingId,
                "date" => $dateTime->format('Y-m-d\TH:i:s.000\Z'),

                "dealer" => [
                    "name" => $row[7],
                    "distributorName" => $row[5],
                    "locationName" => $row[8],
                    "customerName" => null,
                    "customerPhone" => null
                ],

                "summary" => $row[10],
                "transcript" => $row[9],

                "actionPoints" => $actionPoints,
                "complaints" => [],
                "sentiment" => "Neutral",
                "sentimentReason" => null,
                "images" => [],
                "visitorName" => $row[6]
            ];

            // Save into database
            $cvr = CvrDetails::create([
                'visitor_date' => $date,
                'visitor_time' => $time,
                'cvr_id'       => $meetingId,
                'user_id'      => $request->user_id,
                'visitor_name' => $row[6],
                'cvr_data'     => $cvrData, // cast this column to array/json in model
            ]);

            // Return saved record (or use $cvrData if you don't want DB fields)
            $response[] = [
                'db_id' => $cvr->id,
                'data'  => $cvrData
            ];
        }

        return response()->json([
            'success' => true,
            'count'   => count($response),
            'data'    => $response
        ]);
    }

}
