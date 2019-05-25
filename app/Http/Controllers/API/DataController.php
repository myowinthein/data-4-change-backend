<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function getAll(Request $request) {
        $lang = $request->input('lang', 'en');
        $subCategories = $request->input('subCategories', []);
        $cities = $request->input('cities', []);
        $year = $request->input('year', '');
        $subCategoryRsp = [];
        $subCategories = SubCategory::whereIn('id', $subCategories)->with(['variables'])->get();

        foreach ($subCategories as $subCategory) {
            $variablesRsp = [];
            $subCategoryRsp[] = [
                'id' => $subCategory->id,
                'name' => $subCategory->{'name_'. $lang}
            ];
            $variables = $subCategory->variables;

            foreach ($variables as $variable) {
                $table3 = [];
                $variablesRsp[] = [
                    'id' => $variable->id,
                    'name' => $variable->{'name_'. $lang}
                ];
                $singular = $variable->eagerLoader;
                $plural = $singular .'s';

                $variable->loadMissing([$plural.'.city.region']);
                $vd = $variable->{$plural}->whereIn('city_id', $cities);
                dd($vd->toArray());

                $table3[] = [
                ];


                // dd($variable->toArray());
            }
        }
        // return DataResource::collection($regions);

        //link with city & region
    }

    public function getListing(Request $request) {
    }
}

// {
//     SubCategory [
//         {
//             id
//             name
//             Variable {
//                 id
//                 name
//                 table1 [
//                     {
//                         min
//                         max
//                     }
//                 ]
//                 // table2 [
//                 //     {
//                 //         id
//                 //         name
//                 //         value
//                 //     },
//                 // ],
//                 table3 [
//                     {
//                         region {
//                             id
//                             name
//                         }
//                         value
//                     }
//                 ]
//             }
//         }
//     }
// }