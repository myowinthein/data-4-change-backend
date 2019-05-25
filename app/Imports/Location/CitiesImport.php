<?php

namespace App\Imports\Location;

use App\Models\Region;
use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CitiesImport implements ToModel, WithChunkReading
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

        // check existing pcode or not
        $cityPCode = $row[3];
        $isExist = City::where('pcode', $cityPCode)->exists();

        if (!$isExist) {
            $region_id = Region::where('pcode', $row[0])->first()->id;

            return new City([
                'region_id' => $region_id,
                'pcode' => $cityPCode,
                'name_en' => $row[4],
                'name_mm' => $row[5],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
