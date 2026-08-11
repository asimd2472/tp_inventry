<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiteVisitExport implements FromArray, WithHeadings
{
    protected array $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
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
    }
}
