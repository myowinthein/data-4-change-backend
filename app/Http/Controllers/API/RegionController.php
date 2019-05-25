<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Http\Resources\RegionResource;

class RegionController extends Controller
{
    public function getAll(Request $request) {
        $lang = $request->input('lang', 'en');

        $regions = Region::with(['cities' => function($query) use ($lang) {
            $query->orderBy('name_'. $lang, 'asc');
        }])->orderBy('name_'. $lang, 'asc')->get();

        return RegionResource::collection($regions);
    }
}
