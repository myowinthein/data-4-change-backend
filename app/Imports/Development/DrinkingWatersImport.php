<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\DrinkingWaterCity;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DrinkingWatersImport implements OnEachRow, WithChunkReading
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

        DrinkingWaterCity::create([
            'city_id' => $city_id,
            'tap_id' => 'd331c667-69e0-48dc-b500-f1de40fa22bf',
            'tap_value' => $this->zeroIfInvalid($row[6]),
            'borehole_id' => '899d33f6-7174-4866-8aac-32c3949d065f',
            'borehole_value' => $this->zeroIfInvalid($row[7]),
            'well_id' => '5f415c0e-e330-4121-a315-b231e57a8a32',
            'well_value' => $this->zeroIfInvalid($row[8]),
            'pool_id' => '93a18c9e-f86f-4a1e-95d7-8c8282ea607b',
            'pool_value' => $this->zeroIfInvalid($row[10]),
            'river_id' => '451132be-9084-45c9-985d-ec8840ccd376',
            'river_value' => $this->zeroIfInvalid($row[11]),
            'waterfall_id' => '583819af-dd89-48fb-a409-6fe1cfb7a87f',
            'waterfall_value' => $this->zeroIfInvalid($row[12]),
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
