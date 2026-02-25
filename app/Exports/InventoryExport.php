<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Select only required columns
        return Inventory::select(
            'type',
            'model',
            'description',
            'design',
            'dimention',
            'colour',
            'orientation',
            'special_feature',
            'hyderabad',
            'ncr',
        )->get();
    }

    // Custom column headings
    public function headings(): array
    {
        return [
            'Product',
            'Model',
            'Description',
            'Designs',
            'Size',
            'Colour',
            'Orientation',
            'Special Feature',
            'Pravesh Warehouse Hyderabad',
            'Pravesh Warehouse NCR',
        ];
    }

    // Map database fields to export columns
    public function map($inventory): array
    {
        return [
            $inventory->type,
            $inventory->model,
            $inventory->description,
            $inventory->design,
            $inventory->dimention,
            $inventory->colour,
            $inventory->orientation,
            $inventory->special_feature,
            $inventory->hyderabad,
            $inventory->ncr,
        ];
    }
}
