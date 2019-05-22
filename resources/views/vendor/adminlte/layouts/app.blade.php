<!DOCTYPE html>

<html lang="en">
    @section('htmlheader')
        @include('adminlte::layouts.partials.htmlheader')
    @show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
    <body class="skin-blue sidebar-mini">
        <div id="app" v-cloak>
            <div class="wrapper">
                @include('adminlte::layouts.partials.mainheader')

                @include('adminlte::layouts.partials.sidebar')

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    @include('adminlte::layouts.partials.contentheader')

                    <!-- Main content -->
                    <section class="content">
                        @yield('main-content')
                    </section>
                </div>
            </div>
        </div>

        @section('scripts')
            @include('adminlte::layouts.partials.scripts')
        @show

    </body>
</html>