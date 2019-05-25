<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class HospitalCity extends Model
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

    public function noh()
    {
        return $this->belongsTo(Variable::class, 'id', 'noh_id');
    }

    public function nogh()
    {
        return $this->belongsTo(Variable::class, 'id', 'nogh_id');
    }

    public function noph()
    {
        return $this->belongsTo(Variable::class, 'id', 'noph_id');
    }

    public function noth()
    {
        return $this->belongsTo(Variable::class, 'id', 'noth_id');
    }

    public function noogh()
    {
        return $this->belongsTo(Variable::class, 'id', 'noogh_id');
    }

    public function nosh()
    {
        return $this->belongsTo(Variable::class, 'id', 'nosh_id');
    }

    public function nomh()
    {
        return $this->belongsTo(Variable::class, 'id', 'nomh_id');
    }
}
