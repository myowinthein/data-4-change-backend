<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Variable extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    // Hospital
    public function nohs()
    {
        return $this->hasMany(HospitalCity::class, 'noh_id', 'id');
    }

    public function noghs()
    {
        return $this->hasMany(HospitalCity::class, 'nogh_id', 'id');
    }

    public function nophs()
    {
        return $this->hasMany(HospitalCity::class, 'noph_id', 'id');
    }

    public function noths()
    {
        return $this->hasMany(HospitalCity::class, 'noth_id', 'id');
    }

    public function nooghs()
    {
        return $this->hasMany(HospitalCity::class, 'noogh_id', 'id');
    }

    public function noshs()
    {
        return $this->hasMany(HospitalCity::class, 'nosh_id', 'id');
    }

    public function nomhs()
    {
        return $this->hasMany(HospitalCity::class, 'nomh_id', 'id');
    }


    // Drinking Water
    public function taps()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'tap_id', 'id');
    }

    public function boreholes()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'borehole_id', 'id');
    }

    public function wells()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'well_id', 'id');
    }

    public function pools()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'pool_id', 'id');
    }

    public function rivers()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'river_id', 'id');
    }

    public function waterfalls()
    {
        return $this->hasMany(DrinkingWaterCity::class, 'waterfall_id', 'id');
    }


    // Religion
    public function buddhists()
    {
        return $this->hasMany(ReligionCity::class ,'buddhist_id', 'id');
    }

    public function christians()
    {
        return $this->hasMany(ReligionCity::class ,'christian_id', 'id');
    }

    public function hindus()
    {
        return $this->hasMany(ReligionCity::class ,'hindu_id', 'id');
    }

    public function muslims()
    {
        return $this->hasMany(ReligionCity::class ,'muslim_id', 'id');
    }

    public function animists()
    {
        return $this->hasMany(ReligionCity::class ,'animist_id', 'id');
    }

    // Meat
    public function beefs()
    {
        return $this->hasMany(LiveStockCity::class ,'beef_id', 'id');
    }

    public function porks()
    {
        return $this->hasMany(LiveStockCity::class ,'pork_id', 'id');
    }

    public function chickens()
    {
        return $this->hasMany(LiveStockCity::class ,'chicken_id', 'id');
    }

    public function milks()
    {
        return $this->hasMany(LiveStockCity::class ,'milk_id', 'id');
    }

    public function fishs()
    {
        return $this->hasMany(LiveStockCity::class ,'fish_id', 'id');
    }

    // Diaster
    public function storms()
    {
        return $this->hasMany(DiasterCity::class ,'storm_id', 'id');
    }

    public function floods()
    {
        return $this->hasMany(DiasterCity::class ,'flood_id', 'id');
    }

    public function earthquakes()
    {
        return $this->hasMany(DiasterCity::class ,'earthquake_id', 'id');
    }

    public function landslides()
    {
        return $this->hasMany(DiasterCity::class ,'landslide_id', 'id');
    }

    public function droughts()
    {
        return $this->hasMany(DiasterCity::class ,'drought_id', 'id');
    }

    public function nobs()
    {
        return $this->hasMany(HeritageBuildingCity::class ,'nob_id', 'id');
    }
}
