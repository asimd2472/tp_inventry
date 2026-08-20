<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Exports\SiteVisitExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteVisitRequest;
use App\Models\SiteVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SiteVisitController extends Controller
{
    public function index()
    {
        return view('super_admin.sitevisit.create');
    }

    public function store(StoreSiteVisitRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

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
            'follow_update'      => isset($data['follow_up']) ? ($data['follow_update'] ?? null) : null,
            'remarks'            => $data['remarks'] ?? null,
        ]);

        $message = "Visit report #{$visit->id} saved successfully.";
        $redirectUrl = route('admin.site_visit_record');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'visit_id' => $visit->id,
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect()
            ->route('admin.site_visit_record')
            ->with('status', $message);
    }

    public function site_visit_record(Request $request)
    {
        $this->authorizeSiteVisitDashboard();

        return view('super_admin.sitevisit.record', $this->buildRecordPayload($request));
    }

    public function siteVisitRecordData(Request $request)
    {
        $this->authorizeSiteVisitDashboard();

        return response()->json($this->buildRecordPayload($request));
    }

    public function export(Request $request)
    {
        $this->authorizeSiteVisitDashboard();

        $query = SiteVisit::query()->with(['user.manager']);
        $this->applyExportAccessScope($query, Auth::user(), $request);

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if (!empty($dateFrom)) {
            $query->whereDate('visit_date', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $query->whereDate('visit_date', '<=', $dateTo);
        }

        $rows = $query
            ->orderBy('visit_date')
            ->orderBy('id')
            ->get()
            ->map(function (SiteVisit $visit) {
                return [
                    'Sales Manager' => $visit->user?->manager?->name ?? '—',
                    'Sales Executive' => $visit->user?->name ?? $visit->executive_name ?? 'Unknown',
                    'Customer Name' => $visit->customer_name ?? '',
                    'Mobile' => $visit->mobile ?? '',
                    'District' => $visit->district ?? '',
                    'State' => $visit->state ?? '',
                    'Visit Date' => $visit->visit_date ? Carbon::parse($visit->visit_date)->format('d/m/Y') : '',
                    'Visit Time' => $visit->visit_time ? Carbon::parse($visit->visit_time)->format('h:i A') : '',
                    'Construction Stage' => $visit->construction_stage ?? '',
                    'Products' => is_array($visit->products) ? implode(', ', $visit->products) : ($visit->products ?? ''),
                    'Interest' => $visit->interest ?? '',
                    'Qty Total' => (int) ($visit->qty_total ?? 0),
                    'Follow Up' => $visit->follow_up ? 'Yes' : 'No',
                    'Remarks' => $visit->remarks ?? '',
                ];
            })
            ->all();

        $type = strtolower((string) $request->input('type', 'csv'));
        $exportMode = strtolower((string) $request->input('export_mode', 'consolidated'));
        $fileName = 'site-visit-' . $exportMode . '-' . now()->format('YmdHis');

        if (in_array($type, ['excel', 'xlsx'], true)) {
            return Excel::download(new SiteVisitExport($rows), $fileName . '.xlsx');
        }

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            $headers = [
                'Sales Manager',
                'Sales Executive',
                'Customer Name',
                'Mobile',
                'District',
                'State',
                'Visit Date',
                'Visit Time',
                'Construction Stage',
                'Products',
                'Interest',
                'Qty Total',
                'Follow Up',
                'Remarks',
            ];

            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row['Sales Manager'] ?? '',
                    $row['Sales Executive'] ?? '',
                    $row['Customer Name'] ?? '',
                    $row['Mobile'] ?? '',
                    $row['District'] ?? '',
                    $row['State'] ?? '',
                    $row['Visit Date'] ?? '',
                    $row['Visit Time'] ?? '',
                    $row['Construction Stage'] ?? '',
                    $row['Products'] ?? '',
                    $row['Interest'] ?? '',
                    $row['Qty Total'] ?? '',
                    $row['Follow Up'] ?? '',
                    $row['Remarks'] ?? '',
                ]);
            }

            fclose($handle);
        }, $fileName . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function authorizeSiteVisitDashboard(): void
    {
        $user = Auth::user();

        abort_unless(
            $this->isSuperUser($user)
            || $this->isSalesManager($user)
            || $this->isSalesExecutive($user),
            403
        );
    }

    private function isSuperUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return (int) $user->super_admin === 1 || $user->hasRole('Super User');
    }

    private function isSalesManager(?User $user): bool
    {
        return $user !== null && $user->hasRole('Sales Manager');
    }

    private function isSalesExecutive(?User $user): bool
    {
        return $user !== null && $user->hasRole('Sales Executive');
    }

    private function getSalesManagerFilterOptions(): array
    {
        return User::role('Sales Manager')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($user) => ['id' => $user->id, 'name' => $user->name])
            ->all();
    }

    private function getSalesExecutiveFilterOptions(int $managerId): array
    {
        return User::query()
            ->where('manager_id', $managerId)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($user) => ['id' => $user->id, 'name' => $user->name])
            ->all();
    }

    private function getTeamUserIdsForManager(int $managerId): array
    {
        $employeeIds = User::query()
            ->where('manager_id', $managerId)
            ->pluck('id')
            ->all();

        return array_values(array_unique(array_merge([$managerId], $employeeIds)));
    }

    private function resolveTeamFilterContext(?User $user, Request $request): array
    {
        $context = [
            'show' => false,
            'type' => null,
            'options' => [],
            'value' => '',
            'label' => '',
        ];

        if (!$user) {
            return $context;
        }

        if ($this->isSuperUser($user)) {
            $selectedManagerId = (int) $request->get('sales_manager', 0);

            return [
                'show' => true,
                'type' => 'sales_manager',
                'label' => 'Sales Manager',
                'options' => $this->getSalesManagerFilterOptions(),
                'value' => $selectedManagerId > 0 ? (string) $selectedManagerId : '',
            ];
        }

        if ($this->isSalesManager($user)) {
            $selectedExecutiveId = (int) $request->get('sales_executive', 0);

            return [
                'show' => true,
                'type' => 'sales_executive',
                'label' => 'Sales Executive',
                'options' => $this->getSalesExecutiveFilterOptions($user->id),
                'value' => $selectedExecutiveId > 0 ? (string) $selectedExecutiveId : '',
            ];
        }

        return $context;
    }

    private function applyAccessScope($query, ?User $user, Request $request): void
    {
        if (!$user) {
            $query->whereRaw('1 = 0');

            return;
        }

        if ($this->isSuperUser($user)) {
            $salesManagerId = (int) $request->get('sales_manager', 0);
            if ($salesManagerId > 0) {
                $manager = User::role('Sales Manager')->where('id', $salesManagerId)->first();
                if ($manager) {
                    $query->whereIn('user_id', $this->getTeamUserIdsForManager($salesManagerId));
                }
            }

            return;
        }

        if ($this->isSalesManager($user)) {
            $accessibleUserIds = array_values(array_unique(array_merge(
                [$user->id],
                User::query()->where('manager_id', $user->id)->pluck('id')->all()
            )));

            $query->whereIn('user_id', $accessibleUserIds);

            $salesExecutiveId = (int) $request->get('sales_executive', 0);
            if ($salesExecutiveId > 0) {
                $executive = User::query()
                    ->where('id', $salesExecutiveId)
                    ->where('manager_id', $user->id)
                    ->first();

                if ($executive) {
                    $query->where('user_id', $salesExecutiveId);
                }
            }

            return;
        }

        $query->where('user_id', $user->id);
    }

    private function applyExportAccessScope($query, ?User $user, Request $request): void
    {
        if (!$user) {
            $query->whereRaw('1 = 0');

            return;
        }

        $managerIds = $this->normalizeSelectedIds($request, 'sales_manager');
        $executiveIds = $this->normalizeSelectedIds($request, 'sales_executive');

        if ($this->isSuperUser($user)) {
            if ($managerIds !== []) {
                $teamIds = [];

                foreach ($managerIds as $managerId) {
                    $teamIds = array_merge($teamIds, $this->getTeamUserIdsForManager($managerId));
                }

                $query->whereIn('user_id', array_values(array_unique($teamIds)));
            }

            return;
        }

        if ($this->isSalesManager($user)) {
            $accessibleUserIds = array_values(array_unique(array_merge(
                [$user->id],
                User::query()->where('manager_id', $user->id)->pluck('id')->all()
            )));

            $query->whereIn('user_id', $accessibleUserIds);

            if ($executiveIds !== []) {
                $query->whereIn('user_id', $executiveIds);
            }

            return;
        }

        $query->where('user_id', $user->id);
    }

    private function normalizeSelectedIds(Request $request, string $key): array
    {
        $rawValue = $request->input($key, []);

        if (is_array($rawValue)) {
            $values = $rawValue;
        } elseif (is_string($rawValue) && trim($rawValue) !== '') {
            $values = preg_split('/[\s,]+/', trim($rawValue), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        } else {
            $values = [];
        }

        return array_values(array_filter(array_map('intval', $values), fn ($value) => $value > 0));
    }

    private function buildRecordPayload(Request $request): array
    {
        $currentUser = Auth::user();
        $search = trim((string) $request->get('search', ''));
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 20;
        $teamFilter = $this->resolveTeamFilterContext($currentUser, $request);

        $query = SiteVisit::query()
            ->with(['user.manager']);

        $this->applyAccessScope($query, $currentUser, $request);

        $query->when($search !== '', function ($subQuery) use ($search) {
            $subQuery->where(function ($innerQuery) use ($search) {
                $innerQuery->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%")
                    ->orWhere('executive_name', 'like', "%{$search}%")
                    ->orWhere('construction_stage', 'like', "%{$search}%")
                    ->orWhere('interest', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        })
            ->orderByDesc('visit_date')
            ->orderByDesc('id');

        $allResults = (clone $query)->get();
        $visits = (clone $query)->paginate($perPage, ['*'], 'page', $page);
        $visitNumberMap = $this->buildVisitNumberMap($allResults);

        $totalVisits = $allResults->count();
        $uniqueCustomers = $allResults->pluck('mobile')->filter()->unique()->count();
        $highPotentialCustomers = $allResults
            ->whereIn('interest', ['Medium', 'High'])
            ->pluck('mobile')
            ->filter()
            ->unique()
            ->count();
        $estimatedProducts = (int) $allResults->sum('qty_total');

        $showManagerColumn = $this->isSuperUser($currentUser);
        $items = [];

        foreach ($visits as $visit) {
            $executiveName = $visit->user->name ?? $visit->executive_name ?? 'Unknown';
            $managerName = $visit->user?->manager?->name ?? '—';
            $location = trim(($visit->district ?? '') . ', ' . ($visit->state ?? ''), ', ');
            $visitDate = $visit->visit_date
                ? Carbon::parse($visit->visit_date)->format('d/m/Y')
                : '—';
            $visitTime = $visit->visit_time
                ? Carbon::parse($visit->visit_time)->format('h:i A')
                : '';
            $interestClass = match (strtolower($visit->interest ?? '')) {
                'high' => 'high',
                'medium' => 'medium',
                default => 'low',
            };

            $products = is_array($visit->products) ? implode(', ', $visit->products) : '';
            $visitNumber = (int) ($visitNumberMap[$visit->id] ?? 1);

            $items[] = [
                'id' => $visit->id,
                'customer_name' => $visit->customer_name,
                'mobile' => $visit->mobile,
                'location' => $location,
                'visit_date' => $visitDate,
                'visit_time' => $visitTime,
                'executive_name' => $executiveName,
                'manager_name' => $managerName,
                'interest' => $visit->interest ?? 'Low',
                'interest_class' => $interestClass,
                'visit_number' => $visitNumber,
                'visit_number_label' => $this->formatVisitNumberLabel($visitNumber),
                'qty_total' => (int) ($visit->qty_total ?? 0),
                'construction_stage' => $visit->construction_stage ?? '—',
                'follow_up' => (bool) $visit->follow_up,
                'follow_update' => $visit->follow_update
                    ? Carbon::parse($visit->follow_update)->format('d/m/Y')
                    : null,
                'products' => $products,
                'remarks' => $visit->remarks ?? '',
            ];
        }

        return [
            'items' => $items,
            'totalVisits' => $totalVisits,
            'uniqueCustomers' => $uniqueCustomers,
            'highPotentialCustomers' => $highPotentialCustomers,
            'estimatedProducts' => $estimatedProducts,
            'search' => $search,
            'teamFilter' => $teamFilter,
            'showManagerColumn' => $showManagerColumn,
            'dashboardTitle' => $this->isSuperUser($currentUser)
                ? 'Super User Dashboard'
                : ($this->isSalesManager($currentUser) ? 'Sales Manager Dashboard' : 'Site Visit Dashboard'),
            'exportManagerOptions' => $this->isSuperUser($currentUser) ? $this->getSalesManagerFilterOptions() : [],
            'exportExecutiveOptions' => $this->isSalesManager($currentUser) ? $this->getSalesExecutiveFilterOptions($currentUser->id) : [],
            'pagination' => [
                'current_page' => $visits->currentPage(),
                'last_page' => $visits->lastPage(),
                'total' => $visits->total(),
                'from' => $visits->firstItem(),
                'to' => $visits->lastItem(),
                'has_more_pages' => $visits->hasMorePages(),
                'prev_page' => $visits->currentPage() > 1 ? $visits->currentPage() - 1 : null,
                'next_page' => $visits->hasMorePages() ? $visits->currentPage() + 1 : null,
            ],
            'itemsHtml' => view('super_admin.sitevisit.partials.record-items', [
                'items' => $items,
                'showManagerColumn' => $showManagerColumn,
            ])->render(),
        ];
    }

    private function buildVisitNumberMap($visits): array
    {
        $customerVisitCounts = [];
        $visitNumberMap = [];

        foreach ($visits->sortBy([['visit_date', 'asc'], ['id', 'asc']]) as $visit) {
            $customerKey = $this->getCustomerVisitKey($visit);
            $sequence = ($customerVisitCounts[$customerKey] ?? 0) + 1;
            $customerVisitCounts[$customerKey] = $sequence;
            $visitNumberMap[$visit->id] = $sequence;
        }

        return $visitNumberMap;
    }

    private function getCustomerVisitKey(SiteVisit $visit): string
    {
        $mobile = preg_replace('/\D+/', '', (string) ($visit->mobile ?? ''));
        if ($mobile !== '') {
            return 'mobile:' . $mobile;
        }

        return 'name:' . strtolower(trim((string) ($visit->customer_name ?? '')));
    }

    private function formatVisitNumberLabel(int $visitNumber): string
    {
        $suffix = match ($visitNumber % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th',
        };

        if ($visitNumber % 100 >= 11 && $visitNumber % 100 <= 13) {
            $suffix = 'th';
        }

        return $visitNumber . $suffix . ' visit';
    }

    public function revisit(string $id)
    {
        $visit = $this->getAuthorizedSiteVisit((int) $id);

        return view('super_admin.sitevisit.create', [
            'revisitData' => [
                'customer_name' => $visit->customer_name,
                'mobile' => $visit->mobile,
                'alt_mobile' => $visit->alt_mobile,
                'customer_email' => $visit->customer_email,
                'state' => $visit->state,
                'district' => $visit->district,
                'pincode' => $visit->pincode,
                'gps' => ($visit->latitude !== null && $visit->longitude !== null)
                    ? $visit->latitude . ', ' . $visit->longitude
                    : null,
                'maps_link' => $visit->maps_link,
                'construction_stage' => $visit->construction_stage,
                'products' => is_array($visit->products) ? $visit->products : [],
                'categories' => is_array($visit->categories) ? $visit->categories : [],
                'qty' => [
                    'doors' => (int) ($visit->qty_doors ?? 0),
                    'windows' => (int) ($visit->qty_windows ?? 0),
                    'frames' => (int) ($visit->qty_frames ?? 0),
                    'others' => (int) ($visit->qty_others ?? 0),
                ],
                'timeline' => $visit->timeline,
                'budget' => $visit->budget,
                'competitor' => $visit->competitor,
                'interest' => $visit->interest,
                'follow_up' => (bool) $visit->follow_up,
                'follow_update' => $visit->follow_update ? Carbon::parse($visit->follow_update)->format('Y-m-d') : null,
                'remarks' => $visit->remarks,
                'visit_date' => $visit->visit_date ? Carbon::parse($visit->visit_date)->format('Y-m-d') : null,
                'visit_time' => $visit->visit_time ? Carbon::parse($visit->visit_time)->format('H:i') : null,
            ],
            'revisitSourceId' => $visit->id,
        ]);
    }

    private function parseGps(?string $gps): array
    {
        if (! $gps || ! str_contains($gps, ',')) {
            return [null, null];
        }

        [$lat, $lng] = array_map('trim', explode(',', $gps, 2));

        return [is_numeric($lat) ? $lat : null, is_numeric($lng) ? $lng : null];
    }

    private function getAuthorizedSiteVisit(int $id): SiteVisit
    {
        $user = Auth::user();
        $this->authorizeSiteVisitDashboard();

        $visit = SiteVisit::with(['user.manager'])->findOrFail($id);

        if ($this->isSuperUser($user)) {
            return $visit;
        }

        if ($this->isSalesManager($user)) {
            $accessibleUserIds = array_values(array_unique(array_merge(
                [$user->id],
                User::query()->where('manager_id', $user->id)->pluck('id')->all()
            )));

            abort_unless(in_array($visit->user_id, $accessibleUserIds, true), 403);

            return $visit;
        }

        abort_unless((int) $visit->user_id === (int) $user->id, 403);

        return $visit;
    }

    public function show(string $id)
    {
        $visit = $this->getAuthorizedSiteVisit((int) $id);
        $currentUser = Auth::user();

        $visitDate = $visit->visit_date
            ? Carbon::parse($visit->visit_date)->format('d M, Y')
            : '—';
        $visitTime = $visit->visit_time
            ? Carbon::parse($visit->visit_time)->format('h:i A')
            : '—';

        $interestClass = match (strtolower($visit->interest ?? '')) {
            'high' => 'high',
            'medium' => 'medium',
            default => 'low',
        };

        $products = is_array($visit->products) ? $visit->products : [];
        $categories = is_array($visit->categories) ? $visit->categories : [];

        return view('super_admin.sitevisit.details', [
            'visit' => $visit,
            'visitDate' => $visitDate,
            'visitTime' => $visitTime,
            'interestClass' => $interestClass,
            'products' => $products,
            'categories' => $categories,
            'executiveName' => $visit->user->name ?? $visit->executive_name ?? 'Unknown',
            'executiveEmail' => $visit->user->email ?? $visit->executive_email ?? '—',
            'managerName' => $visit->user?->manager?->name ?? '—',
            'showManager' => $this->isSuperUser($currentUser),
            'location' => trim(($visit->district ?? '') . ', ' . ($visit->state ?? ''), ', '),
            'gpsCoordinates' => ($visit->latitude && $visit->longitude)
                ? $visit->latitude . ', ' . $visit->longitude
                : null,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
