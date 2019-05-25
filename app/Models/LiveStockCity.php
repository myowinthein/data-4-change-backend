<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class LiveStockCity extends Model
{
    use UUID;

    public $incrementing = false;

    protected $table = 'live_stock_cities_tables';

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function beef()
    {
        return $this->belongsTo(Variable::class, 'id', 'beef_id');
    }

    public function pork()
    {
        return $this->belongsTo(Variable::class, 'id', 'pork_id');
    }

    public function chicken()
    {
        return $this->belongsTo(Variable::class, 'id', 'chicken_id');
    }

    public function milk()
    {
        return $this->belongsTo(Variable::class, 'id', 'milk_id');
    }

    public function fish()
    {
        return $this->belongsTo(Variable::class, 'id', 'fish_id');
    }
}