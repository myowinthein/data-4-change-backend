<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Region;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Variable;

use App\Imports\Location\RegionsImport;
use App\Imports\Location\CitiesImport;
use App\Imports\Location\TownshipsImport;

use App\Imports\Development\HospitalsImport;
use App\Imports\Development\DrinkingWatersImport;
use App\Imports\Development\ReligionsImport;
use App\Imports\Development\LiveStocksImport;
use App\Imports\Development\DiastersImport;
use App\Imports\Development\HeritageBuildingsImport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function __construct() {
        $this->root = 'excels';
        $this->extension = '.csv';
    }

    public function index () {
        return view('admin.import.index');
    }

    protected function createCategory($payload) {
        return Category::create($payload);
    }

    protected function createSubCategory($payload) {
        return SubCategory::create($payload);
    }

    protected function createVariables($payload) {
        foreach ($payload as $p) {
            Variable::create($p);
        }
    }

    public function region () {
        $path = $this->root .'/luminosity/townships'. $this->extension;
        Excel::import(new RegionsImport, $path);
        return redirect()->route('admin.import.index')->with('status', 'Region Import Success!');
    }

    public function city () {
        $path = $this->root .'/luminosity/townships'. $this->extension;
        Excel::import(new CitiesImport, $path);
        return redirect()->route('admin.import.index')->with('status', 'City Import Success!');
    }

    public function township () {
        $path = $this->root .'/luminosity/townships'. $this->extension;
        Excel::import(new TownshipsImport, $path);
        return redirect()->route('admin.import.index')->with('status', 'Township Import Success!');
    }

    public function hospital () {
        // $category = [
        //     'name_en' => 'Health',
        //     'name_mm' => 'ကျန်းမာရေး',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Number of Hospitals',
        //     'name_mm' => 'ဆေးရုံအရေအတွက်',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Hospitals',
        //         'name_mm' => 'ဆေးရုံအရေ အတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Government Hospitals',
        //         'name_mm' => 'အစိုးရဆေးရုံ အရေအတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Private Hospitals',
        //         'name_mm' => 'ပုဂလိက ဆေးရုံအရေအတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Traditional Hospitals',
        //         'name_mm' => 'တိုင်းရင်းဆေးရုံ အရေအတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Obstetrics and Gynecology Hospitals',
        //         'name_mm' => 'သားဖွားမီးယပ် ဆေးရုံအရေအတွက် ကလေးဆေးရုံ အရေအတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Sangha Hospitals',
        //         'name_mm' => 'သံဃာ့ဆေးရုံ အရေအတွက်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Mental Hospitals',
        //         'name_mm' => 'စိတ်ကျန်းမာရေးဆေးရုံ အရေအတွက်',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit()

        $path = $this->root .'/health/GAD1617_M7A_Hospitals_20190514'. $this->extension;
        Excel::import(new HospitalsImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Hospital Import Success!');
    }

    public function drinking_water () {
        // $category = [
        //     'name_en' => 'Standard of Living',
        //     'name_mm' => 'လူနေမှုအဆင့်အတန်း',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Total Households on Drinking Water',
        //     'name_mm' => 'သောက်သုံးရေရရှိသော အိမ်ထောင်စု အရေအတွက်',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Tap water/Piped',
        //         'name_mm' => 'ရေပိုက်လိုင်း',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Tube well, borehole',
        //         'name_mm' => 'အဝီစိတွင်း',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Protected well/Spring',
        //         'name_mm' => 'ရေတွင်း(အုတ်စီ)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Pool/Pond/Lake',
        //         'name_mm' => 'ရေကန်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'River/Stream/Canal',
        //         'name_mm' => 'မြစ်/ချောင်း/တူးမြောင်း',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Waterfall/Rain water',
        //         'name_mm' => 'တောင်ကျရေ/မိုးရေ',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit();

        $path = $this->root .'/living_standard/CS14_DrinkingWater_20190510'. $this->extension;
        Excel::import(new DrinkingWatersImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Drinking Water Import Success!');
    }

    public function religion () {
        // $category = [
        //     'name_en' => 'Demographic',
        //     'name_mm' => 'လူထုအချက်အလက်',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Religion',
        //     'name_mm' => 'ဘာသာရေး',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Buddhist',
        //         'name_mm' => 'ဗုဒ္ဓဘာသာ',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Christian',
        //         'name_mm' => 'ခရစ်ယာန်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Hindu',
        //         'name_mm' => 'ဟိန္ဒူ',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Muslim',
        //         'name_mm' => 'အစ္စလာမ်',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Animist',
        //         'name_mm' => 'နတ်ကိုးကွယ်',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit();

        $path = $this->root .'/demographics/religion'. $this->extension;
        Excel::import(new ReligionsImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Religion Import Success!');
    }

    public function live_stock () {
        // $category = [
        //     'name_en' => 'Agriculture',
        //     'name_mm' => 'စိုက်ပျိုးရေးနှင့် မွေးမြူရေး',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Live Stock',
        //     'name_mm' => 'မွေးမြူရေးထွက်ကုန်',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Beef Production (ton)',
        //         'name_mm' => 'အမဲသားထုတ်လုပ်မှု့ပမာဏ (တန်)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Pork Production (ton)',
        //         'name_mm' => 'ဝက်သားထုတ်လုပ်မှု့ပမာဏ (တန်)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Chicken Production (ton)',
        //         'name_mm' => 'ကြက်သားထုတ်လုပ်မှု့ပမာဏ (တန်)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Milk Production (ton)',
        //         'name_mm' => 'နို့ထွက်ပမာဏ (တန်)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Fish Production (ton)',
        //         'name_mm' => 'ငါးထုတ်လုပ်မှု့ပမာဏ (တန်)',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit();

        $path = $this->root .'/agriculture/live_stock'. $this->extension;
        Excel::import(new LiveStocksImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Live Stock Success!');
    }

    public function diaster () {
        // $category = [
        //     'name_en' => 'Natural Disasters and Hazards',
        //     'name_mm' => 'ဘဘာဝဘေးအန္တရယ်များ',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Risk Percentage by Township Area',
        //     'name_mm' => 'မြို့နယ်ဧရိယာအလိုက် အန္တရာယ်ရှိမှု ရာခိုင်နှုန်း',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Storm Surge Risk (%)',
        //         'name_mm' => 'မုန်တိုင်း အန္တရာယ် (ရာခိုင်နှူန်း)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Flooding Risk (%)',
        //         'name_mm' => 'ရေကြီးမှု အန္တရာယ် (ရာခိုင်နှူန်း)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Earthquake Risk (%)',
        //         'name_mm' => 'ငလျင် အန္တရာယ် (ရာခိုင်နှူန်း)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Landslide Risk (%)',
        //         'name_mm' => 'မြေပြိုခြင်း အန္တရာယ် (ရာခိုင်နှူန်း)',
        //     ],
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Drought Exposure (%)',
        //         'name_mm' => 'မိုးခေါင်နိုင်ခြင်း (တန်)',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit();

        $path = $this->root .'/natural_disasters/DisasterRiskClimate_20190514'. $this->extension;
        Excel::import(new DiastersImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Diaster Import Success!');
    }

    public function heritage () {
        // $category = [
        //     'name_en' => 'Religious and Historical Sites',
        //     'name_mm' => 'ဘာသာရေးနှင့် သမိုင်းဝင်အဆောင်အအုံများ',
        // ];
        // $category = $this->createCategory($category);

        // // fill sub category
        // $category_id = $category->id;
        // $subCategory = [
        //     'category_id' => $category_id,
        //     'name_en' => 'Heritage Buildings',
        //     'name_mm' => 'အမွေအနှစ်အဆောက်အအုံများ',
        // ];
        // $subCategory = $this->createSubCategory($subCategory);

        // // fill variables
        // $sub_category_id = $subCategory->id;
        // $variables = [
        //     [
        //         'sub_category_id' => $sub_category_id,
        //         'name_en' => 'Number of Building',
        //         'name_mm' => 'အဆောက်အအုံ အရေအတွက်',
        //     ],
        // ];
        // $variables = $this->createVariables($variables);exit();

        $path = $this->root .'/heritage_buildings/GAD1617_M8D_HeritageBuildings_20190513'. $this->extension;
        Excel::import(new HeritageBuildingsImport, $path);

        return redirect()->route('admin.import.index')->with('status', 'Heritage Buildings Import Success!');
    }
}
