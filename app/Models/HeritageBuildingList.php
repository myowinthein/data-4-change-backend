<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class HeritageBuildingList extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function buildingCity()
    {
        return $this->belongsTo(HeritageBuildingCity::class, 'id', 'hertigage_building_city_id');
    }
}