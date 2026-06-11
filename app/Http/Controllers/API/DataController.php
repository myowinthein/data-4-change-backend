<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\DiasterCity;
use App\Models\DrinkingWaterCity;
use App\Models\HeritageBuildingCity;
use App\Models\HospitalCity;
use App\Models\LiveStockCity;
use App\Models\ReligionCity;
use App\Http\Resources\DataResource;
use DB;

class DataController extends Controller
{
    public function getYears() {
        $years = DB::table('live_stock_cities_tables')
            ->select('year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year');
        return response()->json(['data' => $years]);
    }

    public function getAllForOverall(Request $request) {
        $lang = $request->input('lang', 'en');
        $selectedVariables = $request->input('variables', []);
        $cities = $request->input('cities', []);
        $year = $request->input('year', '');

        $categories = Category::with(['subCategories.variables' => function ($query) use ($selectedVariables) {
            $query->whereIn('id', $selectedVariables);
        }])->get();

        // Collect each matching category separately so multiple selected categories
        // all appear in the response (original code reused $categoriesR across iterations,
        // causing only the last processed category to be returned).
        $allCategoriesR = [];

        foreach ($categories as $category) {
            $matchingSubcats = [];

            foreach ($category->subCategories as $subCategory) {
                $variableCityR = [];

                foreach ($subCategory->variables as $variable) {
                    $singular = $variable->eagerLoader;
                    $plural = $singular . 's';

                    $variable->loadMissing([$plural => function ($query) use ($cities, $year) {
                        $query->whereIn('city_id', $cities)->where('year', $year);
                    }]);

                    foreach ($variable->{$plural} as $final) {
                        $variableCityR[$singular][] = [
                            'id'        => $variable->id,
                            'name'      => $variable->{'name_' . $lang},
                            'city_name' => $final->city->{'name_' . $lang},
                            'value'     => $final->{$singular . '_value'},
                        ];
                    }
                }

                if ($variableCityR) {
                    $matchingSubcats[] = [
                        'subCat'        => [
                            'id'   => $subCategory->id,
                            'name' => $subCategory->{'name_' . $lang},
                        ],
                        'variable_city' => $variableCityR,
                    ];
                }
            }

            if (!empty($matchingSubcats)) {
                $allCategoriesR[] = [
                    'category'    => [
                        'id'   => $category->id,
                        'name' => $category->{'name_' . $lang},
                    ],
                    'subCategory' => $matchingSubcats,
                ];
            }
        }

        return response()->json(['data' => $allCategoriesR], 200);
    }

    public function getAllForCompare(Request $request) {
        $lang             = $request->input('lang', 'en');
        $selectedVarIds   = $request->input('variables', []);
        $cities           = $request->input('cities', []);
        $year             = $request->input('year', '');

        if (empty($cities)) {
            return response()->json([]);
        }

        // Load only leaf variable records that match the selection and have an eagerLoader.
        $variables = \App\Models\Variable::whereIn('id', $selectedVarIds)
            ->whereNotNull('eagerLoader')
            ->get();

        if ($variables->isEmpty()) {
            return response()->json([]);
        }

        // Build city → region lookup to avoid N+1 queries.
        $cityMap = \App\Models\City::with('region')
            ->whereIn('id', $cities)
            ->get()
            ->keyBy('id');

        // city_id => row (region + city_name + variable values)
        $cityData = [];

        foreach ($variables as $variable) {
            $singular = $variable->eagerLoader;
            $plural   = $singular . 's';

            $variable->loadMissing([$plural => function ($q) use ($cities, $year) {
                $q->whereIn('city_id', $cities)->where('year', $year);
            }]);

            $varName = $variable->{'name_' . $lang};

            foreach ($variable->{$plural} as $final) {
                $cityId = $final->city_id;
                $city   = $cityMap->get($cityId);
                if (!$city) continue;

                if (!isset($cityData[$cityId])) {
                    $region = $city->region;
                    $cityData[$cityId] = [
                        'region'     => ['id' => $region->id, 'name' => $region->{'name_' . $lang}],
                        'city_name'  => $city->{'name_' . $lang},
                        '_region_id' => $region->id,
                    ];
                }
                $cityData[$cityId][$varName] = (float)$final->{$singular . '_value'};
            }
        }

        // Group rows by region and strip the internal _region_id key.
        $grouped = [];
        foreach ($cityData as $row) {
            $rid = $row['_region_id'];
            unset($row['_region_id']);
            $grouped[$rid][] = $row;
        }

        return response()->json(array_values($grouped));
    }
}