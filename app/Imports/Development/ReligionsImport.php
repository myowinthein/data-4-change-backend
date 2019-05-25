<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\ReligionCity;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ReligionsImport implements OnEachRow, WithChunkReading
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

        ReligionCity::create([
            'city_id' => $city_id,
            'buddhist_id' => '4d4b36b6-d3b2-4816-89c3-0021c68a3d97',
            'buddhist_value' => $this->zeroIfInvalid($row[6]),
            'christian_id' => '71f71905-c891-424f-bf1e-4f45ddf6331c',
            'christian_value' => $this->zeroIfInvalid($row[7]),
            'hindu_id' => 'e8b32f68-4e35-4fe7-a328-65ef8e16acf4',
            'hindu_value' => $this->zeroIfInvalid($row[8]),
            'muslim_id' => '1d90dd69-2038-4e45-95b0-b810c98ac720',
            'muslim_value' => $this->zeroIfInvalid($row[9]),
            'animist_id' => '5f7c4023-36e2-406a-8f0f-3a4eef41ca28',
            'animist_value' => $this->zeroIfInvalid($row[10]),
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
