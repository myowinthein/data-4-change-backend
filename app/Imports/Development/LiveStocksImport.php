<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\LiveStockCity;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LiveStocksImport implements OnEachRow, WithChunkReading
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

        LiveStockCity::create([
            'city_id' => $city_id,
            'beef_id' => 'ad9aa3f5-1b36-4d62-ae95-0f983efdaea9',
            'beef_value' => $this->zeroIfInvalid($row[24]),
            'pork_id' => '15d2e6e3-f7b8-4a68-936a-bb45acf5b1da',
            'pork_value' => $this->zeroIfInvalid($row[25]),
            'chicken_id' => '3f892b5d-fb35-4db4-9383-1862e56245f7',
            'chicken_value' => $this->zeroIfInvalid($row[27]),
            'milk_id' => '3fdf59d8-fcfb-49b1-b394-0eec297c7028',
            'milk_value' => $this->zeroIfInvalid($row[35]),
            'fish_id' => 'eb34b7e6-3c7b-435a-a5ed-769280f1fd2b',
            'fish_value' => $this->zeroIfInvalid($row[38]),
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
