<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class City extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function townships()
    {
        return $this->hasMany(Township::class);
    }

    public function hospitalCities()
    {
        return $this->hasMany(HospitalCity::class);
    }

    public function drinkingWaterCities()
    {
        return $this->hasMany(DrinkingWaterCity::class);
    }

    public function religionCities()
    {
        return $this->hasMany(ReligionCity::class);
    }

    public function liveStocks()
    {
        return $this->hasMany(LiveStockCity::class);
    }

    public function diasters()
    {
        return $this->hasMany(DiasterCity::class);
    }

    public function heritageBuildingCities()
    {
        return $this->hasMany(HeritageBuildingCity::class);
    }
}
