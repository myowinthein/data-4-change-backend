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

class DataController extends Controller
{
    public function getAllForCity(Request $request) {
        // all body data
        $lang = $request->input('lang', 'en');
        $variables = $request->input('variables', []);
        $cities = $request->input('cities', []);
        $year = $request->input('year', '');

        // fake
        $regions = Region::where('id', 'cdeb84c3-82e1-4fe6-bf42-3374e0af209a')->with('cities')->first();
        $cities = $regions->cities()->pluck('id');

        $subCategories = SubCategory::where('id', '8c50ea76-71f4-4598-b663-a5f4c9185392')->with('variables')->first();
        $variables = $subCategories->variables()->pluck('id');

        $year = 2019;

        // category (subcategory filter)
        // $categories = Category::whereHas('subCategories', function ($query) use ($subCategories) {
        //     $query->whereIn('id', $subCategories);
        // })->with('subCategories.variables')->get();

        // category (variable filter)
        $categories = Category::whereHas('subCategories.variables', function ($query) use ($variables) {
            $query->whereIn('id', $variables);
        })->with('subCategories.variables')->get();


        $payload = [];
        $categoriesR = [];
        foreach ($categories as $category) {
            $categoriesR['category'] = [
                'id' => $category->id,
                'name' => $category->{'name_'. $lang}
            ];

            // subcategory
            $subCategoriesR = [];
            foreach ($category->subCategories as $key => $subCategory) {
                $subCategoriesR['subCat'] = [
                    'id' => $subCategory->id,
                    'name' => $subCategory->{'name_'. $lang}
                ];

                // variable
                $variables = $subCategory->variables;
                $variableCityR = [];
                $variableRegionR = [];
                foreach ($variables as $variable) {
                    // eager load
                    $singular = $variable->eagerLoader;
                    $plural = $singular .'s';

                    $variable->loadMissing([$plural => function($query) use ($cities, $year) {
                        $query->whereIn('city_id', $cities)->where('year', $year);
                    }]);

                    $regionPlus = [];
                    foreach ($variable->{$plural} as $final) {
                        // for city
                        $variableCityR[$singular][] = [
                            'id' => $variable->id,
                            'name' => $variable->{'name_'. $lang},
                            'city_name' => $final->city->{'name_'. $lang},
                            'value' => $final->{$singular.'_value'}
                        ];

                        // for region
                        $region_id = $final->city->region->id;
                        $regionPlus[$region_id][] = $final->{$singular.'_value'};
                    }

                    foreach ($regionPlus as $rp) {
                        $variableRegionR[$singular][] = [
                            'id' => $variable->id,
                            'name' => $variable->{'name_'. $lang},
                            'region_name' => $final->city->region->{'name_'. $lang},
                            'value' => array_sum($rp)
                        ];
                    }
                }

                $subCategoriesR['variable_city'] = $variableCityR;
                $subCategoriesR['variable_region'] = $variableRegionR;
            }

            $categoriesR['subCategory'][] = $subCategoriesR;
        }

        $payload = [
            'data' => [$categoriesR]
        ];
        return response()->json($payload, 200);
    }

    public function getListing(Request $request) {

    }

    public function compare(Request $request) {

    }
}