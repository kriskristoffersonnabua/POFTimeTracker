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
                                <a class="btn btn-dark exportButton" type="button" href="{{url()->action('Admin\ReportsController@export', ['project_id' => $project_id, 'subproject_id' => $subproject_id, 'user_id' => $user_id, 'date_from' => $date_from, 'date_to' => $date_to])}}">Export</a>
                            </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-md-22 col-sm-22 col-xs-22">
                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Projects </label>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control projectSelect">
                            <option value="" {{ ($project_id == '') ? 'selected' : '' }}>All projects</option>
                            @foreach($projects as $project)
                                <option value="{{$project['id']}}"  {{ ($project['id'] == $project_id) ? 'selected' : '' }}>{{$project['project_no']}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Sub Projects </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control subprojectSelect">
                            <option value="" {{ ($subproject_id == '') ? 'selected' : '' }}>All subprojects</option>
                            @foreach($subprojects as $subproject)
                                <option value="{{$subproject['id']}}" {{ ($subproject['id'] == $subproject_id) ? 'selected' : '' }}>{{$subproject['subproject_no']}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-1" style="padding-top: 10px; padding-left: 20px">
                            <label> Employees </label>
                        </div>
                                    
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control employeeSelect">
                            <option value="" {{ ($user_id == '') ? 'selected' : '' }}>All employees</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee['id']}}" {{ ($employee['id'] == $user_id) ? 'selected' : '' }}>{{$employee['first_name'].' '.$employee['last_name']}}</option>
                            @endforeach
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
                                            <input type="date" name="date_from" value="{{$date_from}}" class="form-control has-feedback-left" id="single_cal4" placeholder="Date From" aria-describedby="inputSuccess2Status4">
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
                                            <input type="date"name="date_to" value="{{$date_to}}" class="form-control has-feedback-left" id="single_cal3" placeholder="Date From" aria-describedby="inputSuccess2Status4">
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
                                @foreach($reports as $report)
                                <tr>
                                    <td style="width: 7%">{{$report['date']}}</td>
                                    <td>{{$report['name']}}</td>
                                    <td>{{$report['employee']['first_name'].' '.$report['employee']['last_name']}}</td>
                                    <td>{{$report['activity']['title']}}</td>
                                    <td>{{$report['time_start']}}</td>
                                    <td>{{$report['time_end']}}</td>
                                    <td>{{$report['time_consumed']}}hrs</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm viewScreenshot" data-href="{{url()->action('Admin\ReportsController@getScreenshots', ['id' => $report['id']])}}" data-reportId="{{$report['id']}}" data-toggle="modal" data-target=".screenshot-modal">
                                            <i class="fa fa-check"></i> View Screenshot 
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($count === 0)
                            <div>No results found</div>
                        @endif 
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


@push('scripts')
    <script type="text/javascript">

        $(document).ready(function(){

            var updateQueryStringParam = function (key, value) {
                var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
                    urlQueryString = document.location.search,
                    newParam = key + '=' + value,
                    params = '?' + newParam;

                // If the "search" string exists, then build params from it
                if (urlQueryString) {
                    keyRegex = new RegExp('([\?&])' + key + '[^&]*');

                    // If param exists already, update it
                    if (urlQueryString.match(keyRegex) !== null) {
                        params = urlQueryString.replace(keyRegex, "$1" + newParam);
                    } else { // Otherwise, add it to end of query string
                        params = urlQueryString + '&' + newParam;
                    }
                }
                window.history.replaceState({}, "", baseUrl + params);
                window.history.go();
            };
            $(document).on('click','.viewScreenshot',function(event){
                event.preventDefault();
                let selected = $(this);

                $.ajax({
                    method: "GET",
                    url: selected.attr('data-href'),
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data, status, xhr) {
                        if(data){
                            $('#reportDate').text(data.time_history.date);
                            $('#employeeName').text(data.time_history.employee.first_name+' '+data.time_history.employee.last_name);
                            $('#projectName').text(data.time_history.name);
                            $('#activityTitle').text(data.time_history.activity.title);
                            $('#timeStart').text(data.time_history.time_start);
                            $('#timeEnd').text(data.time_history.time_end);
                            $('#timeConsumed').text(data.time_history.time_consumed);
                            for(let i = 0; i < data.screenshots.length; i++) {
                                $('#datatable > tbody').append("<tr><td>"+data.screenshots[i]['screenshot_filename']+"</td></tr>");
                            }
                            function clickHandler(e) {
                                let screenshot = e.target.closest("td").innerHTML;
                                $('.screenshot').text(screenshot);
                            }
                            document.querySelectorAll('#datatable td')
                            .forEach(e => e.addEventListener("click", clickHandler));
                        }
                    },
                    error: function(){
                        alert("Something went wrong.");
                    }
                });
            });
            $(document).on('change','input[name=date_from]',function(event){
                event.preventDefault();
                let date_from = $(this).val();
                updateQueryStringParam('date_from', date_from);
            });
            $(document).on('change','input[name=date_to]',function(event){
                event.preventDefault();
                let date_to = $(this).val();
                updateQueryStringParam('date_to', date_to);
            });
            $(document).on('change','.projectSelect',function(event){
                event.preventDefault();
                let projectID = $(this).val();
                updateQueryStringParam('project_id', projectID);
            });
            $(document).on('change','.subprojectSelect',function(event){
                event.preventDefault();
                let subprojectID = $(this).val();
                updateQueryStringParam('subproject_id', subprojectID);
            });
            $(document).on('change','.employeeSelect',function(event){
                event.preventDefault();
                let employeeID = $(this).val();
                updateQueryStringParam('user_id', employeeID);
            });
        });

    </script>
@endpush