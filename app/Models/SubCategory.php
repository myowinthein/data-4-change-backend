<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class SubCategory extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variables()
    {
        return $this->hasMany(Variable::class);
    }
}
