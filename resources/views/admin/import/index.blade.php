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
    <div class="box">
        <div class="box-body">
            <!-- Location Start -->
            <h2>Location</h2><hr/>

            <form id="region" method="POST" action="{{ route('admin.import.region') }}">@csrf</form>
            <form id="city" method="POST" action="{{ route('admin.import.city') }}">@csrf</form>
            <form id="township" method="POST" action="{{ route('admin.import.township') }}">@csrf</form>

            <div class="btn-group" role="group" aria-label="...">
                <button type="submit" form="region" class="btn btn-default">Region</button>
                <button type="submit" form="city" class="btn btn-default">City</button>
                <button type="submit" form="township" class="btn btn-default">Township</button>
            </div>
            <!-- Location end -->

            <hr/>

            <!-- Development Start -->
            <h2>Development</h2><hr/>

            <form id="hospital" method="POST" action="{{ route('admin.import.hospital') }}">@csrf</form>
            <form id="drinking_water" method="POST" action="{{ route('admin.import.drinking_water') }}">@csrf</form>
            <form id="religion" method="POST" action="{{ route('admin.import.religion') }}">@csrf</form>
            <form id="live_stock" method="POST" action="{{ route('admin.import.live_stock') }}">@csrf</form>
            <form id="diaster" method="POST" action="{{ route('admin.import.diaster') }}">@csrf</form>
            <form id="heritage" method="POST" action="{{ route('admin.import.heritage') }}">@csrf</form>

            <div class="btn-group" role="group" aria-label="...">
                <button type="submit" form="hospital" class="btn btn-default">Hospital</button>
                <button type="submit" form="drinking_water" class="btn btn-default">Drinking Water</button>
                <button type="submit" form="religion" class="btn btn-default">Religion</button>
                <button type="submit" form="live_stock" class="btn btn-default">Live Stock</button>
                <button type="submit" form="diaster" class="btn btn-default">Diaster</button>
                <button type="submit" form="heritage" class="btn btn-default">Heritage</button>
            </div>
            <!-- Development end -->
        </div>
    </div>
@endsection