<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CvrDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\DB;

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


    // public function upload_cvr_excel(Request $request){
       



    //     $rows = Excel::toArray([], $request->file('excel'))[0];

    //     // Remove heading row
    //     array_shift($rows);

    //     $response = [];

    //     foreach ($rows as $row) {

    //         $meetingId = (string) round(microtime(true) * 1000) . rand(100,999);

    //         $dateTime = Carbon::instance(
    //             \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])
    //         )->setTime(9, 52, 0);

    //         $date = $dateTime->format('Y-m-d');
    //         $time = $dateTime->format('H:i:s');

    //         $actionPoints = [];

    //         if (!empty($row[11])) {

    //             $tasks = preg_split("/\r\n|\n|\r/", $row[11]);

    //             foreach ($tasks as $index => $task) {

    //                     if (trim($task) == '') {
    //                         continue;
    //                     }

    //                     $actionPoints[] = [
    //                         "id" => "ap_{$meetingId}_{$index}",
    //                         "task" => trim($task),
    //                         "owner" => "Assigned Manually",
    //                         "deadline" => $date,
    //                         "priority" => "Medium",
    //                         "status" => "Pending"
    //                     ];
    //                 }
    //             }

    //         // Build JSON once
    //         $cvrData = [
    //             "user_id" => (int)$request->user_id,
    //             "id" => $meetingId,
    //             "date" => $dateTime->format('Y-m-d\TH:i:s.000\Z'),

    //             "dealer" => [
    //                 "name" => $row[7],
    //                 "distributorName" => $row[5],
    //                 "locationName" => $row[8],
    //                 "customerName" => null,
    //                 "customerPhone" => null
    //             ],

    //             "summary" => $row[10],
    //             "transcript" => $row[9],

    //             "actionPoints" => $actionPoints,
    //             "complaints" => [],
    //             "sentiment" => "Neutral",
    //             "sentimentReason" => null,
    //             "images" => [],
    //             "visitorName" => $row[6]
    //         ];

    //         // Save into database
    //         $cvr = CvrDetails::create([
    //             'visitor_date' => $date,
    //             'visitor_time' => $time,
    //             'cvr_id'       => $meetingId,
    //             'user_id'      => $request->user_id,
    //             'visitor_name' => $row[6],
    //             'cvr_data'     => $cvrData, // cast this column to array/json in model
    //         ]);

    //         // Return saved record (or use $cvrData if you don't want DB fields)
    //         $response[] = [
    //             'db_id' => $cvr->id,
    //             'data'  => $cvrData
    //         ];
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'count'   => count($response),
    //         'data'    => $response
    //     ]);
    // }

    public function upload_cvr_excel(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'excel'   => 'required|file|mimes:xlsx,xls,csv'
        // ]);

        $rows = Excel::toArray([], $request->file('excel'))[0];

        // dd($rows);

        // Remove header
        array_shift($rows);

        $response = [];

        DB::beginTransaction();

        // try {

            foreach ($rows as $row) {

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $meetingId = (string) round(microtime(true) * 1000) . rand(100,999);

                // Excel Date
                // if (is_numeric($row[0])) {
                //     $dateTime = Carbon::instance(
                //         ExcelDate::excelToDateTimeObject($row[0])
                //     )->setTime(9,52,0);
                // } else {
                //     $dateTime = Carbon::createFromFormat('d-m-Y', trim($row[0]))
                //         ->setTime(9,52,0);
                // }

                // dd($dateTime);

                // $date = $dateTime->format('Y-m-d');
                // $time = $dateTime->format('H:i:s');

                $value = trim((string) $row[0]); // Date column

                if (is_numeric($value)) {

                    // Excel serial date (e.g. 46139)
                    $dateTime = Carbon::instance(
                        ExcelDate::excelToDateTimeObject($value)
                    );

                } else {

                    // Try different date formats
                    $formats = [
                        'd-m-Y',
                        'd/m/Y',
                        'Y-m-d',
                        'm/d/Y',
                    ];

                    $dateTime = null;

                    foreach ($formats as $format) {
                        try {
                            $dateTime = Carbon::createFromFormat($format, $value);
                            break;
                        } catch (\Exception $e) {
                        }
                    }

                    if (!$dateTime) {
                        throw new \Exception("Invalid date format: ".$value);
                    }
                }

                $dateTime->setTime(9, 52, 0);

                

                $date = $dateTime->format('Y-m-d');
                $time = $dateTime->format('H:i:s');

                // dd($date);

                /*
                |--------------------------------------------------------------------------
                | Action Points
                |--------------------------------------------------------------------------
                */

                $actionPoints = [];

                if (!empty($row[7])) {

                    $tasks = preg_split('/\r\n|\r|\n/', $row[7]);

                    foreach ($tasks as $index => $task) {

                        $task = trim($task);

                        if ($task == '') {
                            continue;
                        }

                        $actionPoints[] = [
                            "id" => "ap_{$meetingId}_{$index}",
                            "task" => $task,
                            "owner" => "Assigned Manually",
                            "deadline" => $date,
                            "priority" => "Medium",
                            "status" => "Pending"
                        ];
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Complaints
                |--------------------------------------------------------------------------
                */

                // $complaints = [];
                // if (!empty($row[8])) {

                //     $items = preg_split('/\r\n|\r|\n/', $row[8]);

                //     foreach ($items as $item) {

                //         $item = trim($item);

                //         if ($item != '') {
                //             $complaints[] = $item;
                //         }
                //     }
                // }

                $complaints = [];

                if (!empty($row[8])) {

                    $items = preg_split('/\r\n|\r|\n/', $row[8]);

                    foreach ($items as $index => $item) {

                        $item = trim($item);

                        if ($item == '') {
                            continue;
                        }

                        $complaints[] = [
                            "id" => "comp_{$meetingId}_{$index}",
                            "category" => "Voucher Issues", // Default category
                            "description" => $item,
                            "severity" => "Critical" // Default severity
                        ];
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | CVR JSON
                |--------------------------------------------------------------------------
                */

                $cvrData = [

                    "user_id" => (int)$request->user_id,

                    "id" => $meetingId,

                    "date" => $dateTime->format('Y-m-d\TH:i:s.000\Z'),

                    "dealer" => [

                        "name" => $row[1],                  // Host
                        "distributorName" => $row[2],       // Distributor
                        "locationName" => $row[5],          // Location
                        "customerName" => null,
                        "customerPhone" => $row[4],         // Contact No of Host
                    ],

                    "summary" => $row[6],

                    "transcript" => $row[6],

                    "actionPoints" => $actionPoints,

                    "complaints" => $complaints,

                    "sentiment" => "Neutral",

                    "sentimentReason" => null,

                    "images" => [],

                    "visitorName" => $row[3]
                ];

                $cvr = CvrDetails::create([
                    'visitor_date' => $date,
                    'visitor_time' => $time,
                    'cvr_id' => $meetingId,
                    'user_id' => $request->user_id,
                    'visitor_name' => $row[3],
                    'cvr_data' => $cvrData
                ]);

                $response[] = [
                    'db_id' => $cvr->id,
                    'data' => $cvrData
                ];
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'CVR uploaded successfully.',
                'count' => count($response),
                'data' => $response
            ]);

        // } catch (\Exception $e) {

        //     DB::rollBack();

        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage()
        //     ],500);
        // }
    }

}
