<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class HeritageBuildingCity extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function nob()
    {
        return $this->belongsTo(Variable::class, 'id', 'nob_id');
    }

    public function buildingList()
    {
        return $this->hasMany(HeritageBuildingList::class, 'id', 'hertigage_building_city_id');
    }
}