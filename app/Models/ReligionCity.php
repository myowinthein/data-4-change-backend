<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class ReligionCity extends Model
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

    public function buddhist()
    {
        return $this->belongsTo(Variable::class, 'id', 'buddhist_id');
    }

    public function christian()
    {
        return $this->belongsTo(Variable::class, 'id', 'christian_id');
    }

    public function hindu()
    {
        return $this->belongsTo(Variable::class, 'id', 'hindu_id');
    }

    public function muslim()
    {
        return $this->belongsTo(Variable::class, 'id', 'muslim_id');
    }

    public function animist()
    {
        return $this->belongsTo(Variable::class, 'id', 'animist_id');
    }
}