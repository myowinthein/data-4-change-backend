<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class DiasterCity extends Model
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

    public function storm()
    {
        return $this->belongsTo(Variable::class, 'id', 'storm_id');
    }

    public function flood()
    {
        return $this->belongsTo(Variable::class, 'id', 'flood_id');
    }

    public function earthquake()
    {
        return $this->belongsTo(Variable::class, 'id', 'earthquake_id');
    }

    public function landslide()
    {
        return $this->belongsTo(Variable::class, 'id', 'landslide_id');
    }

    public function drought()
    {
        return $this->belongsTo(Variable::class, 'id', 'drought_id');
    }
}