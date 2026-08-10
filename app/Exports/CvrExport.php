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
                // export all CVR records for the super admin
            } elseif ($isSalesManager && $tab === 'all') {
                $query->where(function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id)
                        ->orWhereHas('user', function ($userQuery) use ($user) {
                            $userQuery->where('manager_id', $user->id);
                        });
                });
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

            $actions = '';
            foreach ($item->actionPoints as $a) {
                $statusUpdatedBy = '';
                if (!empty($a->status_change_by)) {
                    $statusUpdatedBy = ' | Updated By: ' . ($a->status_change_by ? User::find($a->status_change_by)->name : 'Admin');
                }

                $actions .= ($a->task ?? 'Untitled')
                    . ' | Owner: ' . ($a->owner ?? 'Unassigned')
                    . ' | Deadline: ' . ($a->deadline ?? '—')
                    . ' | Priority: ' . ($a->priority ?? 'Medium')
                    . ' | Status: ' . ($a->status ?? 'Pending')
                    . $statusUpdatedBy
                    . "\n";
            }

            if ($actions === '') {
                $actions = $data['actionPoints'] ?? '';
            }

            if ($complaints === '') {
                $complaints = collect($data['complaints'] ?? [])->map(function ($c) {
                    return ($c['category'] ?? 'Issue') . ' - ' . ($c['description'] ?? '') . ' (' . ($c['severity'] ?? 'Minor') . ')';
                })->implode("\n");
            }

            return [
                'Visit Date' => $date . ' ' . $time,
                'Visitor Name' => $data['visitorName'] ?? $item->visitor ?? '',
                'Customer Name' => $data['dealer']['customerName'] ?? $item->visitor ?? '',
                'Phone' => $data['dealer']['customerPhone'] ?? $item->contact_no ?? '',
                'Dealer' => $data['dealer']['name'] ?? $item->host ?? '',
                'Distributor' => $data['dealer']['distributorName'] ?? $item->distributor ?? '',
                'Location' => $data['dealer']['locationName'] ?? $item->location ?? '',
                'Uploaded By' => $item->user->name ?? 'Unknown User',
                'Summary' => $data['summary'] ?? '',
                'Sentiment' => $data['sentiment'] ?? '',
                'Complaints' => $complaints,
                'Action Points' => $actions,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Visit Date',
            'Visitor Name',
            'Customer Name',
            'Phone',
            'Dealer',
            'Distributor',
            'Location',
            'Uploaded By',
            'Summary',
            'Sentiment',
            'Complaints',
            'Action Points',
        ];
    }
}
