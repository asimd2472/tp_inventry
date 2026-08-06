<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CvrDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        try {

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

                // $actionPoints = [];

                // if (!empty($row[7])) {

                //     $tasks = preg_split('/\r\n|\r|\n/', $row[7]);

                //     foreach ($tasks as $index => $task) {

                //         $task = trim($task);

                //         if ($task == '') {
                //             continue;
                //         }

                //         $actionPoints[] = [
                //             "id" => "ap_{$meetingId}_{$index}",
                //             "task" => $task,
                //             "owner" => "Assigned Manually",
                //             "deadline" => $date,
                //             "priority" => "Medium",
                //             "status" => "Pending"
                //         ];
                //     }
                // }

                // $complaints = [];

                // if (!empty($row[8])) {

                //     $items = preg_split('/\r\n|\r|\n/', $row[8]);

                //     foreach ($items as $index => $item) {

                //         $item = trim($item);

                //         if ($item == '') {
                //             continue;
                //         }

                //         $complaints[] = [
                //             "id" => "comp_{$meetingId}_{$index}",
                //             "category" => "Voucher Issues", // Default category
                //             "description" => $item,
                //             "severity" => "Critical" // Default severity
                //         ];
                //     }
                // }

                /*
                |--------------------------------------------------------------------------
                | Action Points & Complaints (Gemini-assisted)
                |--------------------------------------------------------------------------
                */

                $actionPoints = [];
                $complaints   = [];
                $geminiResult = null;

                $hasActionPoints = !empty(trim((string) ($row[7] ?? '')));
                $hasComplaints   = !empty(trim((string) ($row[8] ?? '')));

                if ($hasActionPoints || $hasComplaints) {

                    $conversationText = "Executive Summary:\n" . ($row[6] ?? '') . "\n\n"
                        . ($hasActionPoints ? "Action Points (raw):\n" . $row[7] . "\n\n" : '')
                        . ($hasComplaints ? "Key Issues & Complaints (raw):\n" . $row[8] : '');

                    // dd($conversationText);

                    $geminiResult = $this->analyzeWithGemini($conversationText);

                    // dd($geminiResult);
                }

                if ($geminiResult) {

                    foreach (($geminiResult['actionPoints'] ?? []) as $index => $ap) {
                        $actionPoints[] = [
                            "id"       => "ap_{$meetingId}_{$index}",
                            "task"     => $ap['task'] ?? '',
                            "owner"    => $ap['owner'] ?? 'Assigned Manually',
                            "deadline" => $ap['deadline'] ?? $date,
                            "priority" => $ap['priority'] ?? 'Medium',
                            "status"   => "Pending"
                        ];
                    }

                    foreach (($geminiResult['complaints'] ?? []) as $index => $comp) {
                        $complaints[] = [
                            "id"          => "comp_{$meetingId}_{$index}",
                            "category"    => $comp['category'] ?? 'Voucher Issues',
                            "description" => $comp['description'] ?? '',
                            "severity"    => $comp['severity'] ?? 'Critical'
                        ];
                    }

                } else {

                    // ---- Fallback: your original manual line-split parsing ----

                    if ($hasActionPoints) {
                        $tasks = preg_split('/\r\n|\r|\n/', $row[7]);
                        foreach ($tasks as $index => $task) {
                            $task = trim($task);
                            if ($task === '') continue;
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

                    if ($hasComplaints) {
                        $items = preg_split('/\r\n|\r|\n/', $row[8]);
                        foreach ($items as $index => $item) {
                            $item = trim($item);
                            if ($item === '') continue;
                            $complaints[] = [
                                "id" => "comp_{$meetingId}_{$index}",
                                "category" => "Other Issues",
                                "description" => $item,
                                "severity" => "Critical"
                            ];
                        }
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
                        "customerName" => $row[3],
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

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }




    /**
     * Call Gemini to structure action points & complaints from raw text.
     */
    private function analyzeWithGemini(string $text, int $retries = 2): ?array
    {   

    //     $prompt = <<<PROMPT
    // You are a sales visit assistant.

    // Return STRICT JSON only. No explanation.

    // {
    // "summary": "string",
    // "actionPoints": [
    //     {
    //     "task": "string",
    //     "owner": "string",
    //     "deadline": "string",
    //     "priority": "High | Medium | Low"
    //     }
    // ],
    // "complaints": [
    //     {
    //     "category": "string",
    //     "description": "string",
    //     "severity": "Critical | Major | Minor"
    //     }
    // ]
    // }

    // IMPORTANT:
    // - Always return objects (NOT strings)
    // - Fill all fields

    // Conversation:
    // {$text}
    // PROMPT;

    $prompt = <<<PROMPT
You are an expert business analyst specializing in customer visits, sales meetings, dealer interactions, service visits, market surveys, and complaint analysis.

Your task is to analyze the provided text and transform it into structured data.

IMPORTANT RULES

1. Return ONLY valid JSON.
2. Do not return markdown.
3. Do not wrap the output inside triple backticks.
4. Do not include explanations.
5. Do not leave any field empty.
6. Never return plain strings where objects are expected.
7. Extract information only from the provided text.
8. If information is not explicitly available, infer it from the context.
9. If nothing is found, return an empty array ([]).

------------------------------------------------------------------
ACTION POINT RULES
------------------------------------------------------------------

For every action point:

- Extract the task.
- Identify the most likely owner.
- Estimate the priority level.
- Estimate the deadline if possible.

Allowed owners:

- Sales Team
- Marketing Team
- Operations Team
- Service Team
- Dealer
- Distributor
- Management
- Customer
- Unknown

Priority rules:

- High
- Medium
- Low

------------------------------------------------------------------
COMPLAINT RULES
------------------------------------------------------------------

For every issue, complaint, risk, obstacle, challenge, or concern:

- Create a category name.
- Categorize the issue according to its meaning.
- Use a short, standardized category name.
- Do not create duplicate categories.

Examples of categories:

- Product Quality
- Pricing
- Delivery Delay
- Product Availability
- Inventory
- Marketing
- Promotion
- Product Awareness
- Customer Service
- Lead Generation
- Communication
- Training
- Competitor Activity
- Payment
- Technical Issue
- Display Visibility
- Dealer Support
- Logistics
- Warranty
- Service Delay
- Operations
- Other

Severity rules:

- Critical
- Major
- Minor

------------------------------------------------------------------
SUMMARY RULES
------------------------------------------------------------------

Create a concise executive summary in fewer than 100 words.

------------------------------------------------------------------
RETURN FORMAT
------------------------------------------------------------------

{
    "summary": "string",
    "actionPoints": [
        {
            "task": "string",
            "owner": "string",
            "deadline": "string",
            "priority": "High | Medium | Low"
        }
    ],
    "complaints": [
        {
            "category": "string",
            "description": "string",
            "severity": "Critical | Major | Minor"
        }
    ]
}

------------------------------------------------------------------
TEXT
------------------------------------------------------------------

{$text}

PROMPT;

    // dd($prompt);

    try {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'X-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent',
            [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
            ]
        );

        $data = $response->json();
        // dd($response->json());

        // Retry on 503 (model overloaded)
        if (($data['error']['code'] ?? null) == 503 && $retries > 0) {
            sleep(2);
            return $this->analyzeWithGemini($text, $retries - 1);
        }

        if (!empty($data['error'])) {
            Log::warning('Gemini error: '.json_encode($data['error']));
            return null;
        }

        $resultText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // dd($resultText);

        $resultText = trim(preg_replace('/```json|```/', '', $resultText));

        $parsed = json_decode($resultText, true);

        return json_last_error() === JSON_ERROR_NONE ? $parsed : null;

    } catch (\Exception $e) {
        Log::warning('Gemini call failed: '.$e->getMessage());
        return null;
    }
}

}
