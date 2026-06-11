@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Import
@endsection

@section('contentheader_title')
    Import
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('import') }}
@endsection

@section('main-content')

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">
            <strong>CSV file not available.</strong><br>
            {{ session('error') }}
        </div>
    @endif

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Status</h3>
        </div>
        <div class="box-body">
            <div class="callout callout-info">
                <p>
                    The original CSV source files were <strong>never committed to the repository</strong>
                    (excluded by <code>storage/app/.gitignore</code>). All data shown below was imported
                    during the May 2019 hackathon and is preserved in
                    <code>storage/backup/data4change_2019-05-25.sql</code>.
                    Import buttons will report a missing-file error unless the original CSVs are
                    manually placed at <code>storage/app/excels/…</code>.
                </p>
            </div>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Data type</th>
                        <th>Expected CSV path</th>
                        <th>Rows in DB</th>
                        <th>File present</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        use Illuminate\Support\Facades\Storage;
                        $root = 'excels';
                        $ext  = '.csv';
                        $checks = [
                            ['label' => 'Regions',            'path' => "$root/luminosity/townships$ext",                                          'table' => 'regions'],
                            ['label' => 'Cities',             'path' => "$root/luminosity/townships$ext",                                          'table' => 'cities'],
                            ['label' => 'Townships',          'path' => "$root/luminosity/townships$ext",                                          'table' => 'townships'],
                            ['label' => 'Hospitals',          'path' => "$root/health/GAD1617_M7A_Hospitals_20190514$ext",                         'table' => 'hospital_cities'],
                            ['label' => 'Drinking Water',     'path' => "$root/living_standard/CS14_DrinkingWater_20190510$ext",                   'table' => 'drinking_water_cities'],
                            ['label' => 'Religion',           'path' => "$root/demographics/religion$ext",                                         'table' => 'religion_cities'],
                            ['label' => 'Live Stock',         'path' => "$root/agriculture/live_stock$ext",                                        'table' => 'live_stock_cities_tables'],
                            ['label' => 'Disasters',          'path' => "$root/natural_disasters/DisasterRiskClimate_20190514$ext",                 'table' => 'diaster_cities'],
                            ['label' => 'Heritage Buildings', 'path' => "$root/heritage_buildings/GAD1617_M8D_HeritageBuildings_20190513$ext",     'table' => 'heritage_building_cities'],
                        ];
                    @endphp
                    @foreach ($checks as $check)
                        @php
                            $exists = Storage::disk('local')->exists($check['path']);
                            $count  = DB::table($check['table'])->count();
                        @endphp
                        <tr>
                            <td>{{ $check['label'] }}</td>
                            <td><small><code>storage/app/{{ $check['path'] }}</code></small></td>
                            <td>{{ number_format($count) }}</td>
                            <td>
                                @if ($exists)
                                    <span class="label label-success">Found</span>
                                @else
                                    <span class="label label-danger">Missing</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Location</h3>
        </div>
        <div class="box-body">
            <form id="region"   method="POST" action="{{ route('admin.import.region') }}">@csrf</form>
            <form id="city"     method="POST" action="{{ route('admin.import.city') }}">@csrf</form>
            <form id="township" method="POST" action="{{ route('admin.import.township') }}">@csrf</form>

            <div class="btn-group" role="group">
                <button type="submit" form="region"   class="btn btn-default">Region</button>
                <button type="submit" form="city"     class="btn btn-default">City</button>
                <button type="submit" form="township" class="btn btn-default">Township</button>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Development Data</h3>
        </div>
        <div class="box-body">
            <form id="hospital"       method="POST" action="{{ route('admin.import.hospital') }}">@csrf</form>
            <form id="drinking_water" method="POST" action="{{ route('admin.import.drinking_water') }}">@csrf</form>
            <form id="religion"       method="POST" action="{{ route('admin.import.religion') }}">@csrf</form>
            <form id="live_stock"     method="POST" action="{{ route('admin.import.live_stock') }}">@csrf</form>
            <form id="diaster"        method="POST" action="{{ route('admin.import.diaster') }}">@csrf</form>
            <form id="heritage"       method="POST" action="{{ route('admin.import.heritage') }}">@csrf</form>

            <div class="btn-group" role="group">
                <button type="submit" form="hospital"       class="btn btn-default">Hospital</button>
                <button type="submit" form="drinking_water" class="btn btn-default">Drinking Water</button>
                <button type="submit" form="religion"       class="btn btn-default">Religion</button>
                <button type="submit" form="live_stock"     class="btn btn-default">Live Stock</button>
                <button type="submit" form="diaster"        class="btn btn-default">Diaster</button>
                <button type="submit" form="heritage"       class="btn btn-default">Heritage</button>
            </div>
        </div>
    </div>

@endsection
