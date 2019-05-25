<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\HeritageBuildingCity;
use App\Models\HeritageBuildingList;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HeritageBuildingsImport implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        // disable max execution
        set_time_limit(0);

        // patch rows
        $rows = $rows->where(0, '<>', 'SR_PCODE')->groupBy(3);

        foreach ($rows as $key => $row)
        {
            // skip header & blank columns
            if ($row[0] == 'SR_PCODE' || !$row[0]) {
                return null;
            }

            // get city id
            $city_id = City::where('pcode', $key)->first()->id;

            // add in city
            $hbc = HeritageBuildingCity::create([
                'city_id' => $city_id,
                'nob_id' => 'f6215b0e-3b3a-4132-951e-4b02a974b401',
                'nob_value' => $row->count(),
                'year' => '2019',
            ]);

            // add in list
            foreach ($row as $key2 => $r) {
                // skip header & blank columns
                if (!$r[10] || $r[10] == 'Unknown') {
                    continue;
                }

                HeritageBuildingList::create([
                    'hertigage_building_city_id' => $hbc->id,
                    'name_en' => $r[10],
                    'name_mm' => $r[11],
                    'location_en' => $r[12],
                    'location_mm' => $r[13],
                    'zone_en' => $r[14],
                    'zone_mm' => $r[15],
                ]);
            }
        }
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
