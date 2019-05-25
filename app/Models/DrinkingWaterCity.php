<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class DrinkingWaterCity extends Model
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

    public function tap()
    {
        return $this->belongsTo(Variable::class, 'id', 'tap_id');
    }

    public function borehole()
    {
        return $this->belongsTo(Variable::class, 'id', 'borehole_id');
    }

    public function well()
    {
        return $this->belongsTo(Variable::class, 'id', 'well_id');
    }

    public function pool()
    {
        return $this->belongsTo(Variable::class, 'id', 'pool_id');
    }

    public function river()
    {
        return $this->belongsTo(Variable::class, 'id', 'river_id');
    }

    public function waterfall()
    {
        return $this->belongsTo(Variable::class, 'id', 'waterfall_id');
    }
}