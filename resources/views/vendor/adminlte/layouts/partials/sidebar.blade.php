<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Single Level -->
            <li class="active">
                <a href="{{ url('home') }}">
                    <i class='fa fa-link'></i> <span>Home</span>
                </a>
            </li>

            <!-- Multiple Level -->
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Export</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>