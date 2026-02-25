<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InventoryImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    // public function headingRow(): int
    // {
    //     return 2; // IMPORTANT ✅
    // }

    

    public function model(array $row)
    {

    // dd($row);

        // print_r($row);
        // return new Inventory([
        //     'type'       => trim($row[0] ?? ''),
        //     'model'      => trim($row[1] ?? ''),
        //     'finish'     => trim($row[2] ?? ''),
        //     'design'     => trim($row[3] ?? ''),
        //     'shade'      => trim($row[4] ?? ''),
        //     'width'      => (int) ($row[5] ?? 0),
        //     'height'     => (int) ($row[6] ?? 0),
        //     'tspl'       => (int) ($row[7] ?? 0),
        //     'all_stock'  => (int) ($row[8] ?? 0),
        //     'ultimate'   => (int) ($row[9] ?? 0),
        // ]);

        // return Inventory::updateOrCreate(

        //     [
        //         'type'  => trim($row[0]),
        //         'model' => trim($row[1]),
        //         'dimention'      => trim($row[4] ?? ''),
        //     ],

        //     [
        //         'description'     => trim($row[2] ?? ''),
        //         'design'     => trim($row[3] ?? ''),
        //         'colour'      => trim($row[5] ?? ''),
        //         'orientation'      => trim($row[6] ?? ''),
        //         'special_feature'      => trim($row[7] ?? ''),
        //         'hyderabad'      => trim($row[8] ?? ''),
        //         'ncr'      => trim($row[9] ?? ''),






        //         'finish'      => 0,
        //         'shade'      => 0,
        //         'width'      => 0,
        //         'height'      => 0,
        //     ]
        // );

        return Inventory::create([
            'type' => trim($row[0]),
            'model' => trim($row[1]),
            'description' => trim($row[2] ?? ''),
            'design' => trim($row[3] ?? ''),
            'dimention' => trim($row[4] ?? ''),
            'colour' => trim($row[5] ?? ''),
            'orientation' => trim($row[6] ?? ''),
            'special_feature' => trim($row[7] ?? ''),
            'hyderabad' => trim($row[8] ?? ''),
            'ncr' => trim($row[9] ?? ''),
            'finish' => 0,
            'shade' => 0,
            'width' => 0,
            'height' => 0,
        ]);

    }

    public function startRow(): int
    {
        return 3; 
    }
}
