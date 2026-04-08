<?php

namespace App\Exports;

use App\Models\CvrDetails;
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
        $query = CvrDetails::query();

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

            $data = $item->cvr_data;

            // Date + Time (same like Blade)
            $date = '';
            $time = '';

            if (!empty($data['date'])) {
                $dt = Carbon::parse($data['date'])->setTimezone('Asia/Kolkata');
                $date = $dt->format('d-m-Y');
                $time = $dt->format('h:i A');
            }

            // Complaints (convert array → string)
            $complaints = '';
            if (!empty($data['complaints'])) {
                foreach ($data['complaints'] as $c) {
                    $complaints .= $c['category'] . ' - ' . $c['description'] . ' (' . $c['severity'] . ")\n";
                }
            }

            // Action Points
            $actions = '';
            if (!empty($data['actionPoints'])) {
                foreach ($data['actionPoints'] as $a) {
                    $actions .= $a['task'] . ' | ' . $a['priority'] . ' | ' . $a['status'] . "\n";
                }
            }

            return [
                'Visit Date' => $date . ' ' . $time,
                'Visitor Name' => $data['visitorName'] ?? '',
                'Customer Name' => $data['dealer']['customerName'] ?? '',
                'Phone' => $data['dealer']['customerPhone'] ?? '',
                'Dealer' => $data['dealer']['name'] ?? '',
                'Distributor' => $data['dealer']['distributorName'] ?? '',
                'Location' => $data['dealer']['locationName'] ?? '',
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
            'Summary',
            'Sentiment',
            'Complaints',
            'Action Points',
        ];
    }
}
