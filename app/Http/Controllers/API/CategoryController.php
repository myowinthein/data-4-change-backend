<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Resources\SubCategoryResource;

class CategoryController extends Controller
{
    public function getAll(Request $request) {
        $lang = $request->input('lang', 'en');
        $categories = Category::with('subCategories')->orderBy('name_'. $lang, 'asc')->get();
        return CategoryResource::collection($categories);
    }

    public function getAllSub(Request $request) {
        $lang = $request->input('lang', 'en');
        $subcategories = SubCategory::with('variables')->orderBy('name_'. $lang, 'asc')->get();
        return SubCategoryResource::collection($subcategories);
    }
}