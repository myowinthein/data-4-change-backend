<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Category extends Model
{
    use UUID;

    public $incrementing = false;

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
