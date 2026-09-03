<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CvrDetails;
use App\Models\CvrActionPoints;
use App\Models\CvrComplaints;
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
        // Gemini is called once for each row, so allow the complete upload to finish.
        set_time_limit(300);

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
                $actionPointRecords = [];
                $complaintRecords = [];
                $geminiResult = null;

                $discussionSummary = trim((string) ($row[6] ?? ''));

                if ($discussionSummary !== '') {

                    $conversationText = "Discussion Summary:\n" . $discussionSummary;

                    // dd($conversationText);

                    $geminiResult = $this->analyzeWithGemini($conversationText)
                        ?? $this->fallbackAnalysis($discussionSummary);

                    // dd($geminiResult);
                }

                if ($geminiResult) {

                    foreach (($geminiResult['actionPoints'] ?? []) as $index => $ap) {
                        $ap = is_array($ap) ? $ap : ['task' => (string) $ap];
                        $actionPoint = [
                            "id"       => "ap_{$meetingId}_{$index}",
                            "task"     => $ap['task'] ?? '',
                            "owner"    => $ap['owner'] ?? 'Assigned Manually',
                            "deadline" => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) ($ap['deadline'] ?? ''))
                                ? $ap['deadline']
                                : $date,
                            "priority" => $ap['priority'] ?? 'Medium',
                            "status"   => "Pending"
                        ];
                        $actionPoints[] = $actionPoint;
                        $actionPointRecords[] = [
                            'action_id' => $actionPoint['id'],
                            'task' => $actionPoint['task'],
                            'owner' => $actionPoint['owner'],
                            'deadline' => $actionPoint['deadline'],
                            'priority' => $actionPoint['priority'],
                            'status' => $actionPoint['status'],
                        ];
                    }

                    foreach (($geminiResult['complaints'] ?? []) as $index => $comp) {
                        $comp = is_array($comp) ? $comp : ['description' => (string) $comp];
                        $complaint = [
                            "id"          => "comp_{$meetingId}_{$index}",
                            "category"    => $comp['category'] ?? 'Voucher Issues',
                            "description" => $comp['description'] ?? '',
                            "severity"    => $comp['severity'] ?? 'Critical'
                        ];
                        $complaints[] = $complaint;
                        $complaintRecords[] = [
                            'complaint_id' => $complaint['id'],
                            'category' => $complaint['category'],
                            'description' => $complaint['description'],
                            'severity' => $complaint['severity'],
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
                    'host' => $row[1],
                    'distributor' => $row[2],
                    'visitor' => $row[3],
                    'contact_no' => $row[4],
                    'location' => $row[5],
                    'visitor_date' => $date,
                    'visitor_time' => $time,
                    'cvr_id' => $meetingId,
                    'user_id' => $request->user_id,
                    'visitor_name' => $row[3],
                    'cvr_data' => $cvrData
                ]);

                if (!empty($actionPointRecords)) {
                    $actionPointRecords = array_map(function ($record) use ($cvr) {
                        return array_merge($record, ['cvr_id' => $cvr->id]);
                    }, $actionPointRecords);

                    CvrActionPoints::insert($actionPointRecords);
                }

                if (!empty($complaintRecords)) {
                    $complaintRecords = array_map(function ($record) use ($cvr) {
                        return array_merge($record, ['cvr_id' => $cvr->id]);
                    }, $complaintRecords);

                    CvrComplaints::insert($complaintRecords);
                }

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
    private function fallbackAnalysis(string $text): array
    {
        $actionPoints = [];
        $complaints = [];
        $lines = preg_split('/\r\n|\r|\n/', $text);

        foreach ($lines as $line) {
            $line = trim($line, " \t-*");
            if ($line === '') {
                continue;
            }

            if (preg_match('/\b(action|task|follow[- ]?up|need to|should|must|asked to|request(?:ed)?|confirm(?:ed)?|share|send|submit|provide|review)\b/i', $line)) {
                $actionPoints[] = [
                    'task' => preg_replace('/^\s*(action point|action|task|follow[- ]?up)\s*:?\s*/i', '', $line),
                    'owner' => 'Unknown',
                    'deadline' => 'Not specified',
                    'priority' => 'Medium',
                ];
            }

            if (preg_match('/\b(issue|problem|complaint|delay|difficult|shortage|not available|concern|challenge|competition|competitor|quoted less|price|pricing)\b/i', $line)) {
                $category = preg_match('/\b(competition|competitor|quoted less)\b/i', $line)
                    ? 'Competitor Activity'
                    : (preg_match('/\b(price|pricing|quote|quoted)\b/i', $line) ? 'Pricing' : 'Other');

                $complaints[] = [
                    'category' => $category,
                    'description' => $line,
                    'severity' => 'Major',
                ];
            }
        }

        return ['actionPoints' => $actionPoints, 'complaints' => $complaints];
    }

    private function analyzeWithGemini(string $text, int $retries = 1): ?array
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
        $response = Http::timeout(15)->connectTimeout(5)->withHeaders([
            'Content-Type'  => 'application/json',
            'X-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent',
            [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ],
            ]
        );

        $data = $response->json();
        // dd($response->json());

        // Retry on 503 (model overloaded)
        if (($data['error']['code'] ?? null) == 503 && $retries > 0) {
            sleep(1);
            return $this->analyzeWithGemini($text, $retries - 1);
        }

        if (!empty($data['error'])) {
            Log::warning('Gemini error', [
                'status' => $response->status(),
                'error' => $data['error'],
            ]);
            return null;
        }

        $resultText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if ($resultText === '') {
            Log::warning('Gemini returned no candidate text', [
                'status' => $response->status(),
                'response' => $data,
            ]);
            return null;
        }

        // dd($resultText);

        $resultText = trim(preg_replace('/```json|```/', '', $resultText));
        $jsonStart = strpos($resultText, '{');
        $jsonEnd = strrpos($resultText, '}');
        if ($jsonStart !== false && $jsonEnd !== false) {
            $resultText = substr($resultText, $jsonStart, $jsonEnd - $jsonStart + 1);
        }

        $parsed = json_decode($resultText, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($parsed)) {
            Log::warning('Gemini returned invalid JSON', ['response' => $resultText]);
            return null;
        }

        return [
            'actionPoints' => is_array($parsed['actionPoints'] ?? null) ? $parsed['actionPoints'] : [],
            'complaints' => is_array($parsed['complaints'] ?? null) ? $parsed['complaints'] : [],
        ];

    } catch (\Exception $e) {
        Log::warning('Gemini call failed: '.$e->getMessage());
        return null;
    }
}

}
