<?php

namespace App\Imports\Location;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RegionsImport implements ToModel, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // disable max execution
        set_time_limit(0);

        // skip header & blank columns
        if ($row[0] == 'SR_PCODE' || !$row[0]) {
            return null;
        }

        // global variables
        $oldRegionPCode = session('oldRegionPCode');
        $newRegionPCode = $row[0];

        // save new pcode to old
        session(['oldRegionPCode' => $newRegionPCode]);

        // import if new
        if (!$oldRegionPCode || ($oldRegionPCode && $oldRegionPCode != $newRegionPCode)) {
            return new Region([
                'pcode' => $newRegionPCode,
                'name_en' => $row[1],
                'name_mm' => $row[2],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}