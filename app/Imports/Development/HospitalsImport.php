<?php

namespace App\Imports\Development;

use App\Models\City;
use App\Models\HospitalCity;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HospitalsImport implements OnEachRow, WithChunkReading
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

        HospitalCity::create([
            'city_id' => $city_id,
            'noh_id' => 'd331c667-69e0-48dc-b500-f1de40fa22bf',
            'noh_value' => $this->zeroIfInvalid($row[6]),
            'nogh_id' => '899d33f6-7174-4866-8aac-32c3949d065f',
            'nogh_value' => $this->zeroIfInvalid($row[8]),
            'noph_id' => '5f415c0e-e330-4121-a315-b231e57a8a32',
            'noph_value' => $this->zeroIfInvalid($row[10]),
            'noth_id' => '93a18c9e-f86f-4a1e-95d7-8c8282ea607b',
            'noth_value' => $this->zeroIfInvalid($row[13]),
            'noogh_id' => '451132be-9084-45c9-985d-ec8840ccd376',
            'noogh_value' => $this->zeroIfInvalid($row[15]),
            'nosh_id' => '583819af-dd89-48fb-a409-6fe1cfb7a87f',
            'nosh_value' => $this->zeroIfInvalid($row[28]),
            'nomh_id' => '52f69a2e-6827-40a0-a716-41ba04a53180',
            'nomh_value' => $this->zeroIfInvalid($row[31]),
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
