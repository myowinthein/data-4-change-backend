<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\DiasterCity;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DiastersImport implements OnEachRow, WithChunkReading
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        // disable max execution
        set_time_limit(0);

        // skip header & blank columns
        if ($row[0] == 'SR_PCODE' || !$row[0]) {
            return null;
        }

        // get city id
        $city_id = City::where('pcode', $row[3])->first()->id;

        DiasterCity::create([
            'city_id' => $city_id,
            'storm_id' => 'cb277ee0-058f-409a-adc9-db44dbbd8003',
            'storm_value' => $this->zeroIfInvalid($row[7]),
            'flood_id' => 'cfa5864a-6b7f-402b-90d0-fd7914c3aed0',
            'flood_value' => $this->zeroIfInvalid($row[9]),
            'earthquake_id' => 'e52c418c-8166-4b9b-a1e3-be404a28a17b',
            'earthquake_value' => $this->zeroIfInvalid($row[10]),
            'landslide_id' => 'e26a7999-de5d-47aa-84db-f54fe9b9eb0b',
            'landslide_value' => $this->zeroIfInvalid($row[11]),
            'drought_id' => '8b4e3a75-1a63-4d7d-a83e-6b783587aecc',
            'drought_value' => $this->zeroIfInvalid($row[13]),
        ]);
    }

    protected function zeroIfInvalid($value) {
        return (strtolower($value) == 'unknown' || is_null($value)) ? 0 : $value;
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
