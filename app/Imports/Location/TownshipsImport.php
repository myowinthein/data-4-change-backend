<?php

namespace App\Imports\Location;

use App\Models\City;
use App\Models\Township;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TownshipsImport implements ToModel, WithChunkReading
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
        $townshipPCode = $row[6];
        $isExist = Township::where('pcode', $townshipPCode)->exists();

        if (!$isExist) {
            $city_id = City::where('pcode', $row[3])->first()->id;

            return new Township([
                'city_id' => $city_id,
                'pcode' => $townshipPCode,
                'name_en' => $row[7],
                'name_mm' => $row[8],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
