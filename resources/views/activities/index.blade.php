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

    .filter-fields select{
        width: 150px;
        display: inline;
        margin-left: 10px;
        font-size: 11px;
        padding: 6px !important;
    }

    .filter-fields, .filter-fields button{
        margin-top: -5px
    }
</style>

<div class="page-title">
    <div class="title_left">
        <h3>Activities</h3>
    </div>
    <div class="title_right">
        <div class="col-md-12 col-sm-12 filter-fields form-group row pull-right text-right">
            <label> Projects </label>
            <select class="form-control" id="select-project">
                @foreach ($projects as $project)
                    <option {{ app('request')->input('project_id') == $project->id ? 'selected' : '' }} 
                        value="{{$project->id}}">
                        {{$project->project_no}} - {{$project->name}}
                    </option>
                @endforeach
            </select>
            <label> SubProjects </label>
            <select class="form-control" id="select-subproject">
                @foreach ($subprojects as $project)
                    @php $show = true @endphp
                    @if(app('request')->input('project_id') != "" && app('request')->input('project_id') != $project->project_id)
                        @php $show = false @endphp
                    @endif

                    @if($show) 
                        <option {{ app('request')->input('subproject_id') == $project->id ? 'selected' : '' }} 
                            value="{{$project->id}}" data-project_id="{{$project->project_id}}">
                            {{$project->subproject_no}} - {{$project->subproject_name}}
                        </option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-success btn-sm addActivity" type="button" data-toggle="modal" 
                data-target=".activity-form-modal"
                data-href="{{url()->action('Admin\ActivitiesController@create')}}" 
                data-method="POST" >
                    <span class="fa fa-plus"></span>
                    Add Activity
            </button>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="" role="main">
        <div class="">
            <div class="row">
              <div class="col-md-12" style="text-align: center">
                <div class="x_panel">

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group pull-right top_search" style="height: 30px">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>

                    <div class="x_content">
                        <!-- start project list -->
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th class="th-sm" style="width: 5%">Activity No.</th>
                                    <th class="th-sm">Title</th>
                                    <th class="th-sm">SubProject</th>
                                    <th class="th-sm">Status</th>
                                    <th class="th-sm">Date Added</th>
                                    <th class="th-sm"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>{{$activity->activity_no}}</td>
                                    <td>
                                        <a>{{$activity->title}}</a>
                                    </td>
                                    <td>
                                        {{$activity->subprojects->subproject_name}}
                                    </td>
                                    <td>
                                        {{ucfirst(str_replace('_', ' ', $activity->status))}}
                                    </td>
                                    <td>
                                        {{date('m/d/Y', strtotime($activity->created_at))}}
                                    </td>
                                    <td>

                                        <a href="#" class="btn btn-primary btn-xs viewActivity" data-view="{{url()->action('Admin\ActivitiesController@show', ['id' => $activity->id])}}" data-toggle="modal" data-target=".view-modal">
                                            <i class="fa fa-folder"></i> View 
                                        </a>
                                        {{-- @if(!auth()->user()->hasRole('administrator')) --}}
                                        <a href="{{url()->action('Admin\ActivitiesController@update', ['id' => $activity->id])}}" 
                                            class="btn btn-info btn-xs updateActivity" data-toggle="modal" data-target=".activity-form-modal"
                                            data-view="{{url()->action('Admin\ActivitiesController@show', ['id' => $activity->id])}}" 
                                            data-id="{{$activity->id}}"
                                        >
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a class="btn btn-dark btn-xs assignActivity" data-toggle="modal" 
                                            data-target=".assign-activity-modal"
                                            data-activity_no="{{$activity->activity_no}}"
                                            data-activity_title="{{$activity->title}}"
                                            data-employee_user_id="{{$activity->employee_user_id}}"
                                            data-estimated_hours="{{$activity->estimated_hours}}"
                                            href="{{url()->action('Admin\ActivitiesController@assign', ['id' => $activity->id])}}" 
                                        >
                                            <i class="fa fa-check"></i> Assign 
                                        </a>
                                        @if($activity->status == "done")
                                        <a href="{{url()->action('Admin\ActivitiesController@done', ['id' => $activity->id])}}" 
                                            class="btn btn-success btn-xs doneActivity"
                                            data-subproject_id="{{$activity->subprojects->id}}"
                                            data-project_id="{{$activity->subprojects->project_id}}"
                                        >
                                            <i class="fa fa-thumbs-up"></i> For Testing 
                                        </a>
                                        @endif
                                        <a href="{{url()->action('Admin\ActivitiesController@destroy', ['id' => $activity->id])}}" data-id="{{$activity->id}}"  
                                            class="btn btn-danger btn-xs deleteActivity" data-toggle="modal" data-target=".delete-modal">
                                            <i class="fa fa-trash-o"></i> Delete 
                                        </a>
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <!-- end project list -->

                    </div>
                </div>
            </div>
        </div>

        <!---- Modals ---->
        <div class="modal fade view-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.view-modal')
        </div>

        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.delete-modal')
        </div>
        <div class="modal fade activity-form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.activity-form-modal', ['subprojects' => $subprojects])
        </div>

        <div class="modal fade assign-activity-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.assign-activity-modal', ['users' => $users])
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


@push('scripts')
    <script type="text/javascript" >
        var subproject_id , updated_activity_no, user_id;
        $(document).ready(function(){
            $("#select-project").change(function(){
                window.location = "?project_id=" + $(this).val();
            });

            $("#select-subproject").change(function(){
                window.location = "?project_id=" + $(this).find('option:selected').data('project_id') + "&subproject_id=" + $(this).val();
            });

           $('#subproject').on('change',function(e){
                getActivityNo();
            });

            $(document).on('click','.addActivity',function(event){
                event.preventDefault();
                selected = $(this);
                
                $('#activityForm').attr('action', selected.attr('data-href'));
                $('#activityForm').attr('method', selected.attr('data-method'));

                $('#activityForm').find('input[type="text"]').val('');
                $('#activityForm').find('input[type="file"]').val('');
                $('#activityForm').find('textarea').text('');
                $('#activityForm').find('input[name=_method]').remove();

                getActivityNo();

            });

            $(document).on('click','.updateActivity',function(event){
                event.preventDefault();
                selected = $(this);

                getActivityDetails(selected.data('view'));
                
                $('#activityForm').attr('action', selected.attr('href'));
                $('#activityForm').attr('method', "POST");

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value:"PATCH"
                }).appendTo('#activityForm');
            });

            $(document).on('click', '.viewActivity', function(event){
                event.preventDefault();
                selected = $(this);
    
                getActivityDetails(selected.data('view'), true);
            })

            $(document).on('click','.assignActivity',function(event){

                project_id =  $('#subproject').find('option:selected').data('project_id');

                event.preventDefault();
                selected = $(this);

                
                $('#assignActivityForm').attr('action', selected.attr('href'));
                $('#assignActivityForm').attr('method', "POST");
                $('#assignActivityForm').find('.activity_no').text(selected.data('activity_no'));
                $('#assignActivityForm').find('.activity_title').text(selected.data('activity_title'));
                $('#assignActivityForm').find('input[name="employee_user_id"]').val(selected.data('employee_user_id'));
                $('#assignActivityForm').find('input[name="estimated_hours"]').val(selected.data('estimated_hours'));
                $('#assignActivityForm').find('input[name="project_id"]').val(project_id);
                $('#assignActivityForm').find('input[name="subproject_id"]').val($('#subproject').val());
            });

            $(document).on('click','.doneActivity',function(){
                event.preventDefault();
                selected = $(this);
                let do_refresh = false;
                $.ajax({
                    method: "PATCH",
                    url: selected.attr('href'),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":selected.attr('data-id')
                    },
                    success: function (data, status, xhr) {
                        // if(data.success)
                            location.reload();
                    },
                    error: function(){
                        alert("Something went wrong.");
                    }
                });
            });

            $(document).on('click','.deleteActivity',function(event){
                event.preventDefault();
                selected = $(this);
            });

            $(document).on('click','.addComment', function(event){
                event.preventDefault();
                selected = $(this);
                comments = $('#textComment').val();
                activity_no = $('#activity_no').text();
                
                $.ajax({
                    method: "POST",
                    url: 'admin/comments',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'comment': comments,
                        'user_id':  user_id,
                        'activity_no': parseInt(activity_no)
                    },
                    success: function (data, status, xhr) {
                        if(data.success) {
                            $('#textComment').val('');
                            $("#comment").prepend('<tr><td style="width: 170px">' + data.data.date_added +'</td><td>' + data.data.comment +'</td></tr>');
                        }       
                    },
                    error: function(){
                        alert("Something went wrong.");
                    }
                });
            });

            $(document).on('click','#confirmDelete',function(){
                event.preventDefault();
                let do_refresh = false;
                $.ajax({
                    method: "DELETE",
                    url: selected.attr('href'),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":selected.attr('data-id')
                    },
                    success: function (data, status, xhr) {
                        if(data.success)
                            location.reload();
                    },
                    error: function(){
                        alert("Something went wrong.");
                    }
                });
            });
        });

        function getActivityNo() {
            subproject_id = $('#subproject').val();
            project_id =  $('#subproject').find('option:selected').data('project_id');
            
            $.ajax({
                type:'GET',
                url: "{{url()->action('Admin\ActivitiesController@getNextActivityNo')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subproject_id":subproject_id
                },
                success: function (data, status, xhr) {
                    $("#activity_no").val(data);
                    $("#activityForm").find('input[name="project_id"]').val(project_id);
                }
            });
        }

        function getActivityDetails(link, fromView) {
            $.ajax({
                type:'GET',
                url: link,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data, status, xhr) {
                    const activityDetails = data.data.details;
                    const activityFiles = data.data.files;
                    const subprojectName = data.data.subproject;
                    const tbas = data.data.tba;
                    const comments = data.data.comments;
                    const user = data.data.user;

                    if (fromView) {
                       user_id = user.id;

                       $('#subproject_id').text(activityDetails.subproject_id);
                       $('#subproject_name').text(subprojectName.subproject_name);
                       $('#activity_no').text(activityDetails.activity_no);
                       $('#title').text(activityDetails.title);
                       $('#description').text(activityDetails.description);
                       $('#acceptance_criteria').text(activityDetails.acceptance_criteria);
                       
                       $('#files > a').length > 0 ?  $('#files > a').remove() : '' ; 

                       activityFiles.forEach(function(files) {
                            $("#files").append("<a style='padding-left: 15px'></a>");
                            $('#files > a').attr('id', files.file_link);
                            $("#files > a").attr("href", files.file_link);
                            $('#files > a').text(files.file_link);
                        });
                       
                       $('#tbas > p').length > 0 ?  $('#tbas > p').remove() : '' ; 

                       tbas.forEach(function(tba) {
                            $("#tbas").append("<p style='padding-left: 15px'></p>");
                            $('p').attr('id', files.file_link);
                            $('#tbas > p').text(files.file_link);
                        });
                       
                       $('#comment > tr').length > 0 ? $('#comment > tr').remove(): '';

                       comments.forEach(function(comment) {
                            $("#comment").append('<tr><td style="width: 170px">' + comment.date_added +'</td><td>' + comment.comment +'</td></tr>');
                       });

                    }
                }
            });
        }
    </script>
@endpush


@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection