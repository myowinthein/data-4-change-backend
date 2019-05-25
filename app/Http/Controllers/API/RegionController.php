<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Http\Resources\RegionResource;
use App\Http\Resources\RegionResource1;

class RegionController extends Controller
{
    public function getAll(Request $request) {
        $lang = $request->input('lang', 'en');
        $isDivisonOnly = $request->input('isDivisonOnly', false);

        $regions = Region::with(['cities' => function($query) use ($lang) {
            $query->orderBy('name_'. $lang, 'asc');
        }])->orderBy('name_'. $lang, 'asc')->get();

        if ($isDivisonOnly == 'true') {
            return RegionResource1::collection($regions);
        } else {
            return RegionResource::collection($regions);
        }
    }
}
