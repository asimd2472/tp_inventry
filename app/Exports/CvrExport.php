<?php

namespace App\Exports;

use App\Models\CvrDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CvrExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = CvrDetails::with(['actionPoints', 'complaints', 'user']);

        $tab = in_array($this->request->get('tab'), ['all', 'my'], true) ? $this->request->get('tab') : 'my';
        $user = auth()->user();

        if ($user) {
            $isSuperUser = (int) $user->super_admin === 1 || $user->hasRole('Super User');
            $isSalesManager = $user->hasRole('Sales Manager');

            if ($isSuperUser && $tab === 'all') {
                $salesManagerId = (int) $this->request->get('sales_manager', 0);
                if ($salesManagerId > 0) {
                    $manager = User::role('Sales Manager')->where('id', $salesManagerId)->first();
                    if ($manager) {
                        $employeeIds = User::query()
                            ->where('manager_id', $salesManagerId)
                            ->pluck('id')
                            ->all();
                        $teamUserIds = array_values(array_unique(array_merge([$salesManagerId], $employeeIds)));
                        $query->whereIn('user_id', $teamUserIds);
                    }
                }
            } elseif ($isSalesManager && $tab === 'all') {
                $salesExecutiveId = (int) $this->request->get('sales_executive', 0);
                if ($salesExecutiveId > 0) {
                    $executive = User::query()
                        ->where('id', $salesExecutiveId)
                        ->where('manager_id', $user->id)
                        ->first();

                    if ($executive) {
                        $query->where('user_id', $salesExecutiveId);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                } else {
                    $query->where(function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id)
                            ->orWhereHas('user', function ($userQuery) use ($user) {
                                $userQuery->where('manager_id', $user->id);
                            });
                    });
                }
            } else {
                $query->where('user_id', $user->id);
            }
        }

        $search = trim((string) $this->request->get('search', ''));
        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('host', 'like', "%{$search}%")
                    ->orWhere('distributor', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('visitor', 'like', "%{$search}%")
                    ->orWhere('visitor_name', 'like', "%{$search}%")
                    ->orWhere('contact_no', 'like', "%{$search}%")
                    ->orWhere('cvr_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if (!empty($this->request->visitor_name)) {
            $query->where('visitor_name', 'LIKE', '%' . $this->request->visitor_name . '%');
        }

        if (!empty($this->request->from_date)) {
            $query->whereDate('visitor_date', '>=', $this->request->from_date);
        }

        if (!empty($this->request->to_date)) {
            $query->whereDate('visitor_date', '<=', $this->request->to_date);
        }

        return $query->orderBy('id', 'DESC')->get()->map(function ($item) {
            $data = $item->cvr_data ?? [];

            $date = '';
            $time = '';

            if (!empty($data['date'])) {
                $dt = Carbon::parse($data['date'])->setTimezone('Asia/Kolkata');
                $date = $dt->format('d-m-Y');
                $time = $dt->format('h:i A');
            } elseif ($item->visitor_date) {
                $dt = Carbon::parse($item->visitor_date)->setTimezone('Asia/Kolkata');
                $date = $dt->format('d-m-Y');
                $time = $item->visitor_time ?: $dt->format('h:i A');
            }

            $complaints = '';
            foreach ($item->complaints as $c) {
                $complaints .= ($c->category ?? 'Issue') . ' - ' . ($c->description ?? '') . ' (' . ($c->severity ?? 'Minor') . ")\n";
            }

            $openCount = 0;
            $closedCount = 0;

            foreach ($item->actionPoints as $a) {
                $status = strtolower(trim($a->status ?? 'open'));

                if (in_array($status, ['completed', 'done', 'closed'])) {
                    $closedCount++;
                } else {
                    $openCount++;
                }
            }

            if ($item->actionPoints->isEmpty() && !empty($data['actionPoints'])) {
                foreach ($data['actionPoints'] as $a) {
                    $status = strtolower(trim($a['status'] ?? 'open'));

                    if (in_array($status, ['completed', 'done', 'closed'])) {
                        $closedCount++;
                    } else {
                        $openCount++;
                    }
                }
            }

            $actions = 'Open: ' . $openCount . ', Closed: ' . $closedCount;

            if ($complaints === '') {
                $complaints = collect($data['complaints'] ?? [])->map(function ($c) {
                    return ($c['category'] ?? 'Issue') . ' - ' . ($c['description'] ?? '') . ' (' . ($c['severity'] ?? 'Minor') . ')';
                })->implode("\n");
            }

            return [
                'Visit Date' => $date,
                'Visitor Name' => $data['visitorName'] ?? $item->visitor ?? '',
                'Customer Name' => $data['dealer']['customerName'] ?? $item->visitor ?? '',
                'Phone' => $data['dealer']['customerPhone'] ?? $item->contact_no ?? '',
                'Dealer' => $data['dealer']['name'] ?? $item->host ?? '',
                'Distributor' => $data['dealer']['distributorName'] ?? $item->distributor ?? '',
                'Location' => $data['dealer']['locationName'] ?? $item->location ?? '',
                'Uploaded By' => $item->user->name ?? 'Unknown User',
                'Action Points' => $actions,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Visit Date',
            'SE Name',
            'Customer Name',
            'Phone',
            'Dealer',
            'Distributor',
            'Location',
            'Uploaded By',
            'Action Points',
        ];
    }
}
