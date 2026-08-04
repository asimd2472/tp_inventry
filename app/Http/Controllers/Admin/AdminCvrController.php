<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CvrActionPoints;
use App\Models\CvrComplaints;
use App\Models\CvrDetails;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminCvrController extends Controller
{
    public function cvr(){
        return view('admin.cvr.index');
    }

    public function uploadCvr(Request $request){
        
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls|max:10240'
        ]);

        $userId = Auth::id();
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

                $hasActionPoints = !empty(trim((string) ($row[7] ?? '')));
                $hasComplaints   = !empty(trim((string) ($row[8] ?? '')));

                if ($hasActionPoints || $hasComplaints) {

                    $conversationText = "Executive Summary:\n" . ($row[6] ?? '') . "\n\n"
                        . ($hasActionPoints ? "Action Points (raw):\n" . $row[7] . "\n\n" : '')
                        . ($hasComplaints ? "Key Issues & Complaints (raw):\n" . $row[8] : '');

                    $geminiResult = $this->analyzeWithGemini($conversationText);

                    // dd($geminiResult);
                }

                if ($geminiResult) {

                    foreach (($geminiResult['actionPoints'] ?? []) as $index => $ap) {
                        $actionPoint = [
                            "id"       => "ap_{$meetingId}_{$index}",
                            "task"     => $ap['task'] ?? '',
                            "owner"    => $ap['owner'] ?? 'Assigned Manually',
                            "deadline" => $ap['deadline'] ?? $date,
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

                } else {

                    // ---- Fallback: your original manual line-split parsing ----

                    if ($hasActionPoints) {
                        $tasks = preg_split('/\r\n|\r|\n/', $row[7]);
                        foreach ($tasks as $index => $task) {
                            $task = trim($task);
                            if ($task === '') continue;
                            $actionPoint = [
                                "id" => "ap_{$meetingId}_{$index}",
                                "task" => $task,
                                "owner" => "Assigned Manually",
                                "deadline" => $date,
                                "priority" => "Medium",
                                "status" => "Pending"
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
                    }

                    if ($hasComplaints) {
                        $items = preg_split('/\r\n|\r|\n/', $row[8]);
                        foreach ($items as $index => $item) {
                            $item = trim($item);
                            if ($item === '') continue;
                            $complaint = [
                                "id" => "comp_{$meetingId}_{$index}",
                                "category" => "Voucher Issues",
                                "description" => $item,
                                "severity" => "Critical"
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
                }

                /*
                |--------------------------------------------------------------------------
                | CVR JSON
                |--------------------------------------------------------------------------
                */

                $cvrData = [

                    "user_id" => (int) $userId,

                    "id" => $meetingId,

                    "date" => $dateTime->format('Y-m-d\TH:i:s.000\Z'),

                    "dealer" => [

                        "name" => $row[1],               
                        "distributorName" => $row[2],      
                        "locationName" => $row[5],          
                        "customerName" => $row[3],
                        "customerPhone" => $row[4], 
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
                    'user_id' => $userId,
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

    public function repository(Request $request)
    {
        $payload = $this->buildRepositoryPayload($request);

        return view('admin.cvr.repository', $payload);
    }

    public function repositoryData(Request $request)
    {
        return response()->json($this->buildRepositoryPayload($request));
    }

    private function buildRepositoryPayload(Request $request): array
    {
        $currentUser = Auth::user();
        $userId = Auth::id();
        $search = trim((string) $request->get('search', ''));
        $tab = in_array($request->get('tab'), ['all', 'my'], true) ? $request->get('tab') : 'my';
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 20;
        $canViewAll = $currentUser && (int) $currentUser->super_admin === 1;

        $query = CvrDetails::with(['actionPoints', 'complaints', 'user'])
            ->when($canViewAll && $tab === 'all', function ($query) {
                // admin can view all CVRs
            }, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('host', 'like', "%{$search}%")
                        ->orWhere('distributor', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('visitor', 'like', "%{$search}%")
                        ->orWhere('visitor_name', 'like', "%{$search}%")
                        ->orWhere('contact_no', 'like', "%{$search}%")
                        ->orWhere('cvr_id', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('visitor_date')
            ->orderByDesc('id');

        $allResults = (clone $query)->get();
        $cvrs = (clone $query)->paginate($perPage, ['*'], 'page', $page);

        $totalVisits = $allResults->count();
        $openActions = 0;
        $criticalIssues = 0;
        $items = [];

        foreach ($allResults as $cvr) {
            foreach ($cvr->actionPoints as $ap) {
                $status = strtolower(trim($ap->status ?? 'pending'));

                if (!in_array($status, ['completed', 'done', 'closed'])) {
                    $openActions++;
                }
            }

            foreach ($cvr->complaints as $comp) {
                if (strtolower(trim($comp->severity ?? '')) === 'critical') {
                    $criticalIssues++;
                }
            }
        }

        foreach ($cvrs as $cvr) {
            $data = $cvr->cvr_data ?? [];
            $actionPoints = $cvr->actionPoints;
            $complaints = $cvr->complaints;

            $pending = 0;
            $completed = 0;

            foreach ($actionPoints as $ap) {
                $status = strtolower(trim($ap->status ?? 'pending'));

                if (in_array($status, ['completed', 'done', 'closed'])) {
                    $completed++;
                } else {
                    $pending++;
                }
            }

            $issuesCount = $complaints->count();

            if ($cvr->visitor_date) {
                $date = Carbon::parse($cvr->visitor_date)->format('d/m/y');
            } elseif (!empty($data['date'])) {
                $date = Carbon::parse($data['date'])->format('d/m/y');
            } else {
                $date = '—';
            }

            $dealerName = $cvr->host ?: ($data['dealer']['name'] ?? 'Unknown Dealer');
            $contact = $cvr->visitor ?: ($data['visitorName'] ?? ($data['dealer']['customerName'] ?? '—'));
            $location = $cvr->location ?: ($data['dealer']['locationName'] ?? '');
            $summary = $data['summary'] ?? '';
            $sentiment = ucfirst(strtolower($data['sentiment'] ?? 'Neutral'));
            $uploadedBy = $cvr->user->name ?? 'Unknown User';

            $searchParts = [
                $dealerName,
                $contact,
                $location,
                $cvr->distributor ?? '',
                $summary,
                $sentiment,
                $uploadedBy,
            ];

            foreach ($actionPoints as $ap) {
                $searchParts[] = $ap->task ?? '';
                $searchParts[] = $ap->owner ?? '';
            }

            foreach ($complaints as $comp) {
                $searchParts[] = $comp->description ?? '';
                $searchParts[] = $comp->category ?? '';
            }

            $items[] = [
                'id' => $cvr->id,
                'dealer' => $dealerName,
                'location' => $location,
                'date' => $date,
                'contact' => $contact,
                'summary' => $summary,
                'sentiment' => $sentiment,
                'uploaded_by' => $uploadedBy,
                'pending' => $pending,
                'completed' => $completed,
                'issues' => $issuesCount,
                'search_text' => strtolower(implode(' ', array_filter($searchParts))),
            ];
        }

        return [
            'items' => $items,
            'totalVisits' => $totalVisits,
            'openActions' => $openActions,
            'criticalIssues' => $criticalIssues,
            'search' => $search,
            'tab' => $tab,
            'canViewAll' => $canViewAll,
            'pagination' => [
                'current_page' => $cvrs->currentPage(),
                'last_page' => $cvrs->lastPage(),
                'total' => $cvrs->total(),
                'from' => $cvrs->firstItem(),
                'to' => $cvrs->lastItem(),
                'has_more_pages' => $cvrs->hasMorePages(),
                'prev_page' => $cvrs->currentPage() > 1 ? $cvrs->currentPage() - 1 : null,
                'next_page' => $cvrs->hasMorePages() ? $cvrs->currentPage() + 1 : null,
            ],
            'itemsHtml' => view('admin.cvr.partials.repository-items', ['items' => $items])->render(),
        ];
    }

    private function analyzeWithGemini(string $text, int $retries = 2): ?array
    {   

        $prompt = <<<PROMPT
    You are a sales visit assistant.

    Return STRICT JSON only. No explanation.

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

    IMPORTANT:
    - Always return objects (NOT strings)
    - Fill all fields

    Conversation:
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
        // dd($data);

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

    private function getAuthorizedCvr(int $id): CvrDetails
    {
        $user = Auth::user();
        $query = CvrDetails::with(['actionPoints', 'complaints', 'user'])->where('id', $id);

        if (!( $user && (int) $user->super_admin === 1 )) {
            $query->where('user_id', Auth::id());
        }

        return $query->firstOrFail();
    }

    public function viewCvrDetails($id)
    {
        $cvr = $this->getAuthorizedCvr((int) $id);

        $data = $cvr->cvr_data ?? [];
        $actionPoints = $cvr->actionPoints;
        $complaints = $cvr->complaints;

        $dealerName = $cvr->host ?: ($data['dealer']['name'] ?? 'Unknown Dealer');
        $distributor = $cvr->distributor ?: ($data['dealer']['distributorName'] ?? '');
        $visitor = $cvr->visitor ?: ($data['visitorName'] ?? ($data['dealer']['customerName'] ?? ''));
        $contact = $cvr->contact_no ?: ($data['dealer']['customerPhone'] ?? '');
        $location = $cvr->location ?: ($data['dealer']['locationName'] ?? '');
        $date = $cvr->visitor_date ? Carbon::parse($cvr->visitor_date)->format('d/m/Y') : 'N/A';
        $time = $cvr->visitor_time ?? 'N/A';
        $summary = $data['summary'] ?? '';
        $sentiment = ucfirst(strtolower($data['sentiment'] ?? 'Neutral'));
        $uploadedBy = $cvr->user->name ?? 'Unknown User';

        return view('admin.cvr.details', compact(
            'cvr',
            'dealerName',
            'distributor',
            'visitor',
            'contact',
            'location',
            'date',
            'time',
            'summary',
            'sentiment',
            'uploadedBy',
            'actionPoints',
            'complaints'
        ));
    }

    public function updateSummary(Request $request, $id)
    {
        $cvr = $this->getAuthorizedCvr((int) $id);

        $data = $request->validate([
            'summary' => 'nullable|string',
        ]);

        $cvrData = is_array($cvr->cvr_data) ? $cvr->cvr_data : [];
        $cvrData['summary'] = $data['summary'] ?? '';
        $cvr->cvr_data = $cvrData;
        $cvr->save();

        return response()->json([
            'success' => true,
            'summary' => $data['summary'] ?? '',
        ]);
    }

    public function addActionPoint(Request $request, $id)
    {
        $cvr = $this->getAuthorizedCvr((int) $id);

        $data = $request->validate([
            'task' => 'required|string|max:2000',
            'owner' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'priority' => 'nullable|string|max:50',
        ]);

        $ap = CvrActionPoints::create([
            'cvr_id' => $cvr->id,
            'action_id' => 'ap_'.uniqid(),
            'task' => $data['task'],
            'owner' => $data['owner'] ?? null,
            'deadline' => $data['deadline'] ?? null,
            'priority' => $data['priority'] ?? 'Medium',
            'status' => 'Pending',
            'status_change_by' => null,
        ]);

        $html = view('admin.cvr.partials.action-point-item', ['ap' => $ap])->render();

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function addComplaint(Request $request, $id)
    {
        $cvr = $this->getAuthorizedCvr((int) $id);

        $data = $request->validate([
            'category' => 'nullable|string|max:255',
            'description' => 'required|string|max:5000',
            'severity' => 'nullable|string|max:50',
        ]);

        $comp = CvrComplaints::create([
            'cvr_id' => $cvr->id,
            'complaint_id' => 'comp_'.uniqid(),
            'category' => $data['category'] ?? null,
            'description' => $data['description'],
            'severity' => $data['severity'] ?? 'Minor',
        ]);

        $html = view('admin.cvr.partials.complaint-item', ['comp' => $comp])->render();

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function deleteActionPoint($id)
    {
        $ap = CvrActionPoints::findOrFail($id);
        $this->getAuthorizedCvr((int) $ap->cvr_id);

        $ap->delete();

        return response()->json(['success' => true]);
    }

    public function deleteComplaint($id)
    {
        $comp = CvrComplaints::findOrFail($id);
        $this->getAuthorizedCvr((int) $comp->cvr_id);

        $comp->delete();

        return response()->json(['success' => true]);
    }

    public function updateActionPointStatus(Request $request, $id)
    {
        $ap = CvrActionPoints::findOrFail($id);
        $this->getAuthorizedCvr((int) $ap->cvr_id);

        $data = $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Closed',
        ]);

        $ap->status = $data['status'];
        $ap->status_change_by = (string) Auth::id();
        $ap->save();

        return response()->json([
            'success' => true,
            'status' => $ap->status,
            'status_change_by' => $ap->status_change_by,
            'updated_at' => $ap->updated_at ? $ap->updated_at->format('d M, Y H:i') : null,
        ]);
    }
}
