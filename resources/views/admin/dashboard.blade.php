@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <!-- top tiles -->
<style>
    .my-custom-scrollbar {
        position: relative;
        height: 380px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }
    td {
        text-align: left;
    }
</style>

    <div class="x_content">
        @if(auth()->user()->hasRole('administrator'))
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-book"></i></div>
                    <div class="count">179</div>
                    <h3>Top Projects</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count">179</div>
                    <h3>Top Employees</h3>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        @endif
        
        <div class="row">
            @if(auth()->user()->hasRole('administrator'))
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Daily Time Consumed of Employees</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Daily Time Consumed of Team Members</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Daily Time Consumed of Project</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="mybarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>   

        
            @if(!auth()->user()->hasRole('administrator'))

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Monthly Time Consumed per Project</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12" style="display: inline-block">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Daily Task History for the Day</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table id="datatable" class="table table-striped projects">
                                <thead>
                                    <tr>
                                    <th class="th-sm" style="width: 10%">Date</th>
                                    <th class="th-sm" >Project Name</th>
                                    <th class="th-sm" >Employee Name</th>
                                    <th class="th-sm" style="width: 50%">Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0; $i < 20; $i++)
                                    <tr>
                                        <td style="width: 7%">01/01/2001</td>
                                        <td> Pesamakini Backend UI </td>
                                        <td> Lee Dong Wook </td>
                                        <td> Activity details here </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        <div class="clearfix"></div>
    </div>
    
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
