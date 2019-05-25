<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getAll(Request $request) {
        $lang = $request->input('lang', 'en');
        $categories = Category::with('subCategories')->orderBy('name_'. $lang, 'asc')->get();
        return CategoryResource::collection($categories);
    }
}