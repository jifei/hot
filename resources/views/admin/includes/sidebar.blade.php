<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/assets/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
        </div>
        <div class="pull-left info">
            <p>{{$login_admin_user['name']}}</p>

            {{--<a href="#"><i class="fa fa-circle text-success"></i>在线</a>--}}
        </div>
    </div>
    <!-- search form -->
    {{--<form action="#" method="get" class="sidebar-form">--}}
        {{--<div class="input-group">--}}
            {{--<input type="text" name="q" class="form-control" placeholder="Search..."/>--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
        {{--</div>--}}
    {{--</form>--}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">主菜单</li>
        {{--<li class="active treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li class="active"><a href="index.html"><i class="fa fa-angle-double-right"></i> Dashboard v1</a></li>--}}
        {{--<li><a href="index2.html"><i class="fa fa-angle-double-right"></i> Dashboard v2</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="pages/widgets.html">--}}
        {{--<i class="fa fa-th"></i> <span>Widgets</span>--}}
        {{--<small class="label pull-right bg-green">new</small>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-bar-chart-o"></i>--}}
        {{--<span>Charts</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>--}}
        {{--<li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>--}}
        {{--<li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-laptop"></i>--}}
        {{--<span>UI Elements</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>--}}
        {{--<li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>--}}
        {{--<li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>--}}
        {{--<li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>--}}
        {{--<li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>--}}
        {{--<li><a href="pages/UI/modals.html"><i class="fa fa-angle-double-right"></i> Modals</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-edit"></i> <span>Forms</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a>--}}
        {{--</li>--}}
        {{--<li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a>--}}
        {{--</li>--}}
        {{--<li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-table"></i> <span>Tables</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>--}}
        {{--<li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="pages/calendar.html">--}}
        {{--<i class="fa fa-calendar"></i> <span>Calendar</span>--}}
        {{--<small class="label pull-right bg-red">3</small>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="pages/mailbox.html">--}}
        {{--<i class="fa fa-envelope"></i> <span>Mailbox</span>--}}
        {{--<small class="label pull-right bg-yellow">12</small>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-folder"></i> <span>Examples</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>--}}
        {{--<li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>--}}
        {{--<li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>--}}
        {{--<li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a>--}}
        {{--</li>--}}
        {{--<li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>--}}
        {{--<li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>--}}
        {{--<li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#">--}}
        {{--<i class="fa fa-share"></i> <span>Multilevel</span>--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="#"><i class="fa fa-angle-double-right"></i> Level One</a></li>--}}
        {{--<li>--}}
        {{--<a href="#"><i class="fa fa-angle-double-right"></i> Level One <i--}}
        {{--class="fa fa-angle-left pull-right"></i></a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="#"><i class="fa fa-angle-double-right"></i> Level Two</a></li>--}}
        {{--<li>--}}
        {{--<a href="#"><i class="fa fa-angle-double-right"></i> Level Two <i--}}
        {{--class="fa fa-angle-left pull-right"></i></a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="#"><i class="fa fa-angle-double-right"></i> Level Three</a></li>--}}
        {{--<li><a href="#"><i class="fa fa-angle-double-right"></i> Level Three</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li><a href="#"><i class="fa fa-angle-double-right"></i> Level One</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li><a href="documentation/index.html"><i class="fa fa-book"></i> Documentation</a></li>--}}
        {{--<li class="header">LABELS</li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-danger"></i> Important</a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-warning"></i> Warning</a></li>--}}
        {{$menu_tree->printAllowedTree($menu_tree->buildTree(), 1)}}
    </ul>
</section>