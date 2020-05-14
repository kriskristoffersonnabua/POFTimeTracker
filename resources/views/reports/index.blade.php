@extends('admin.layouts.admin')

@section('content')

<style>
    .my-custom-scrollbar {
        position: relative;
        height: 600px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
    bottom: .5em;
    }
    td {
        text-align: left;
    }
</style>

<div class="x_content">
    <div class="" role="main">
        <div class="">
            <div class="row">
              <div class="col-md-12" style="text-align: center">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Reports</h2>
                        
                        <div class="title_right">
                            <div class="col-md-1 col-sm-1 col-xs-1 form-group pull-right">
                                <button class="btn btn-dark" type="button">Export</button>
                            </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-22 col-sm-22 col-xs-22">
                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Projects </label>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control">
                            @for ($i = 1; $i < 10 ; $i++)
                                <option> Project 0000{{ $i }}</option>
                            @endfor
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Sub Projects </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control">
                            @for ($i = 1; $i < 10 ; $i++)
                                <option> Project 0000{{ $i }}</option>
                            @endfor
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Employees </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control">
                            @for ($i = 1; $i < 10 ; $i++)
                                <option> Project 0000{{ $i }}</option>
                            @endfor
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Date From </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <fieldset>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                            <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Date From" aria-describedby="inputSuccess2Status4">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-10 col-sm-10 col-xs-10" style="padding-top: 10px; padding-left: 20px">
                            <label style="padding-left: 91%"> Date To </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2 pull-right">
                            <fieldset>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                            <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="Date From" aria-describedby="inputSuccess2Status4">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="x_content">
                        <!-- start project list -->
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                <th class="th-sm" style="width: 10%">Date</th>
                                <th class="th-sm" >Project Name</th>
                                <th class="th-sm" >Employee Name</th>
                                <th class="th-sm" style="width: 25%">Activity</th>
                                <th class="th-sm" style="width: 8%">Time Start</th>
                                <th class="th-sm" style="width: 8%">Time End</th>
                                <th class="th-sm" style="width: 8%">Time Consumed</th>
                                <th class="th-sm" style="width: 10%">Links</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=0; $i < 20; $i++)
                                <tr>
                                    <td style="width: 7%">01/01/2001</td>
                                    <td> Pesamakini Backend UI </td>
                                    <td> Lee Dong Wook </td>
                                    <td> Activity details here </td>
                                    <td> 11:00 am </td>
                                    <td> 11:00 pm </td>
                                    <td> 12 hrs </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".screenshot-modal">
                                            <i class="fa fa-check"></i> View Screenshot 
                                        </a>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        </div>

                        <div class="pull-right" style="padding: 5px 10px 5px 10px">
                            <label> Total Number of Items </label>
                            <p> 20 </p>
                        </div>

                        <div class="pull-right" style="padding: 5px 10px 5px 10px">
                            <label> Total Consumed Hours </label>
                            <p> 50 </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!---- Modals ---->
        <div class="modal fade screenshot-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.screenshot-modal')
        </div>

        <!---- End of Modals ---->
        </div>
    </div>
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