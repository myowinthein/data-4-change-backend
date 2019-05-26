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
    public function getAllForOverall(Request $request) {
        // all body data
        $lang = $request->input('lang', 'en');
        $variables = $request->input('variables', []);
        $cities = $request->input('cities', []);
        $year = $request->input('year', '');

        // category
        $categories = Category::with(['subCategories.variables' => function ($query) use ($variables) {
            $query->whereIn('id', $variables);
        }])->get();

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
                    }
                }

                if ($variableCityR) {
                    $subCategoriesR['variable_city'] = $variableCityR;
                }
            }

            if (isset($subCategoriesR['variable_city'])) {
                $categoriesR['subCategory'][] = $subCategoriesR;
            }
        }

        $payload = [
            'data' => [$categoriesR]
        ];
        return response()->json($payload, 200);
    }

    public function getAllForCompare(Request $request) {
        // all body data
        $lang = $request->input('lang', 'en');
        $variables = $request->input('variables', []);
        $cities = $request->input('cities', []);
        $cityStr = implode(", ", $cities);
        $year = $request->input('year', '');

        $religion_data = DB::select("
            SELECT
                r.id as region_id, r.name_$lang as region_name,
                c.id as city_id, c.name_$lang as city_name,
                v1.name_$lang as animist_name, rc.animist_id, rc.animist_value,
                v2.name_$lang as buddhist_name, rc.buddhist_id, rc.buddhist_value,
                v3.name_$lang as christian_name, rc.christian_id, rc.christian_value,
                v4.name_$lang as hindu_name, rc.hindu_id, rc.hindu_value,
                v5.name_$lang as muslim_name, rc.muslim_id, rc.muslim_value
            FROM regions r
            INNER JOIN cities c ON r.id = c.region_id
            INNER JOIN religion_cities rc ON c.id = rc.city_id
            INNER JOIN variables v1 ON v1.id = rc.animist_id
            INNER JOIN variables v2 ON v2.id = rc.buddhist_id
            INNER JOIN variables v3 ON v3.id = rc.christian_id
            INNER JOIN variables v4 ON v4.id = rc.hindu_id
            INNER JOIN variables v5 ON v5.id = rc.muslim_id"
            // WHERE rc.year = ? AND c.id IN (?)", [$year, $cityStr]
        );

        $data1 = [];
        foreach ($religion_data as $rd) {
            $data1[$rd->region_id][] = [
                'region' => [
                    'id' => $rd->region_id,
                    'name' => $rd->region_name,
                ],
                'city_name' => $rd->city_name,
                $rd->animist_name => (int)$rd->animist_value,
                $rd->buddhist_name => (int)$rd->buddhist_value,
                $rd->christian_name => (int)$rd->christian_value,
                $rd->hindu_name => (int)$rd->hindu_value,
                $rd->muslim_name => (int)$rd->muslim_value,
            ];
        }

        $diaster_data = DB::select("
            SELECT
                r.id as region_id, r.name_$lang as region_name,
                c.id as city_id, c.name_$lang as city_name,
                v1.name_$lang as earthquake_name, rc.earthquake_id, rc.earthquake_value,
                v2.name_$lang as landslide_name, rc.landslide_id, rc.landslide_value
            FROM regions r
            INNER JOIN cities c ON r.id = c.region_id
            INNER JOIN diaster_cities rc ON c.id = rc.city_id
            INNER JOIN variables v1 ON v1.id = rc.earthquake_id
            INNER JOIN variables v2 ON v2.id = rc.landslide_id"
        );

        // $data2 = [];
        // foreach ($diaster_data as $rd) {
        //     $data2[$rd->region_id][] = [
        //         'region' => [
        //             'id' => $rd->region_id,
        //             'name' => $rd->region_name,
        //         ],
        //         'city_name' => $rd->city_name,
        //         $rd->earthquake_name => (int)$rd->earthquake_value,
        //         $rd->landslide_name => (int)$rd->landslide_value,
        //     ];
        // }

        return $data1;
    }
}