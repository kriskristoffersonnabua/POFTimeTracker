<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title">
                <span>{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('logo.png') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <br/>
                <h2>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                <span></span>
                {{ auth()->user()->hasRole('administrator') ? "ADMINISTRATOR" : "EMPLOYEE" }}
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.dashboard') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('projects') }}">
                            <i class="fa fa-book" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.projects') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('subprojects') }}">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.sub_projects') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('activities') }}">
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.activities') }}
                        </a>
                    </li>
                    
                    @if(auth()->user()->hasRole('administrator'))
                    <li>
                        <a href="{{ route('employees') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.employees') }}
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('reports') }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.report') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
