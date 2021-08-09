<?php

namespace App\Imports;

use App\Models\Locations;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Locations([
            'lga' => $row['lga'],
            'state' => $row['state']
        ]);
    }
}
