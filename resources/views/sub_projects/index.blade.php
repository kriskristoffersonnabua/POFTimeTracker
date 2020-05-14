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
        <h3>SubProjects</h3>
    </div>
    <div class="title_right">
        <div class="col-md-8 col-sm-8 filter-fields form-group row pull-right text-right">
            <label> Projects </label>
            <select class="form-control" id="select-project">
                @foreach ($projects as $project)
                    <option {{ app('request')->input('project_id') == $project->id ? 'selected' : '' }} 
                        value="{{$project->id}}">
                        {{$project->project_no}} - {{$project->name}}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-success btn-sm addSubProject" type="button" data-toggle="modal" 
                data-target=".add-sub-modal" 
                data-href="{{url()->action('Admin\SubProjectController@create')}}" 
                data-method="POST">
                    <span class="fa fa-plus"></span>
                    Add SubProject
            </button>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="" role="main">
        <div class="">
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                    <div class="">
                        <div class="col-md-3 col-sm-3 col-xs-12 filter-fields pull-right top_search">
                            <div class="input-group">
                                <input name="search" type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default searchProjects" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- start project list -->
                        
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                <th class="th-sm" >SubProject No.</th>
                                <th class="th-sm" >SubProject Name</th>
                                <th class="th-sm" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subprojects as $project)
                                <tr>
                                    <td >{{$project->subproject_no}}</td>
                                    <td  >
                                        <a>{{$project->subproject_name}}</a>
                                        <br />
                                        {{-- <small>{{ $project->created_at}}</small> --}}
                                        <small>{{ $project->description}}</small>
                                    </td>
                                    <td>
                                        <a href="{{url()->action('Admin\ActivitiesController@index', ['subproject_id' => $project->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> View Activities </a>

                                        @if(auth()->user()->hasRole('administrator'))
                                        <a href="{{url()->action('Admin\SubProjectController@assign', ['id' => $project->id])}}" 
                                            data-id="{{$project->id}}" 
                                            data-project_id="{{$project->project_id}}" 
                                            data-project_no="{{$project->subproject_no}}" 
                                            data-name="{{$project->subproject_name}}" 
                                            data-user_id="{{$project->user_id}}" 
                                            class="btn btn-warning btn-sm assignSubProject" data-toggle="modal" data-target=".assign-modal">
                                            <i class="fa fa-check"></i> Assign 
                                        </a>
                                        <a href="{{url()->action('Admin\SubProjectController@update', ['id' => $project->id])}}" 
                                            data-id="{{$project->id}}" 
                                            data-project_id="{{$project->project_id}}" 
                                            data-project_no="{{$project->subproject_no}}" 
                                            data-name="{{$project->subproject_name}}" 
                                            data-description="{{$project->description}}" 
                                            class="btn btn-info btn-sm updateSubProject" data-toggle="modal" data-target=".add-sub-modal">
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a href="{{url()->action('Admin\SubProjectController@destroy', ['id' => $project->id])}}" data-id="{{$project->id}}" class="btn btn-danger btn-sm deleteProject" data-toggle="modal" data-target=".delete-modal">
                                            <i class="fa fa-trash-o"></i> Delete 
                                        </a>
                                        @endif 
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

        <div class="modal fade assign-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.assign-modal',['users' => $users])
        </div>

        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.delete-modal')
        </div>

        <div class="modal fade add-sub-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.add-sub-modal',['projects' => $projects, 'project_id' => app('request')->input('project_id')])
        </div>

        <!---- End of Modals ---->
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-project").change(function(){
                window.location = "?project_id=" + $(this).val();
            });

            let selected = null;
            $(document).on('click','.searchProjects',function(event){
                event.preventDefault();
                selected = $(this);
                
                let search = $('input[name=search]').val();
                document.location.search =  "?name=" + search;
            });

            $(document).on('click','.addSubProject',function(event){
                event.preventDefault();
                selected = $(this);
                
                $('#subProjectForm').attr('action', selected.attr('data-href'));
                $('#subProjectForm').attr('method', selected.attr('data-method'));

                $('#subproject-select').val($('#select-project').val());
                $('#subproject_no').val(getSubProjNo($('#select-project').val()));

                $('input[name=name]').val('');
                $('textarea[name=description]').html('');
                $('#subProjectForm').find('input[name=_method]').remove();
            });

            $(document).on('click','.updateSubProject',function(event){
                event.preventDefault();
                selected = $(this);
                
                $('#subProjectForm').attr('action', selected.attr('href'));
                $('#subProjectForm').attr('method', "POST");
                $('select[name=project_id]').val(selected.attr('data-project_id'));
                $('input[name=subproject_no]').val(selected.attr('data-project_no'));
                $('input[name=subproject_name]').val(selected.attr('data-name'));
                $('textarea[name=description]').html(selected.attr('data-description'));
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value:"PATCH"
                }).appendTo('#subProjectForm');
            });

            $(document).on('click','.assignSubProject',function(event){
                event.preventDefault();
                selected = $(this);
                
                $('#assignSubProjectForm').attr('action', selected.attr('href'));
                $('#assignSubProjectForm').attr('method', "POST");
                $('#subpr_no').val(selected.attr('data-project_no'));
                $('#subpr_name').val(selected.attr('data-name'));
                $('#tl_id').val(selected.attr('data-user_id'));
                $("#pro_id").val(selected.attr('data-project_id'));
                getAssignedEmployees(selected.attr('data-id'));
                $('<input>').attr({
                    type: 'hidden',
                    name: '_token',
                    value: "{{ csrf_token() }}"
                }).appendTo('#assignSubProjectForm');
            });

            $(document).on('click','.deleteProject',function(event){
                event.preventDefault();
                selected = $(this);
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

        function getSubProjNo(project_id) {
            $.ajax({
                method: "GET",
                url: "{{url()->action('Admin\SubProjectController@getNextSubProjectNo')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "project_id":project_id
                },
                success: function (data, status, xhr) {
                    $("#subproject_no").val(data);
                },
                error: function(){
                    alert("Something went wrong.");
                }
            });
        }

        function getAssignedEmployees(subproject_id) {
            $.ajax({
                method: "GET",
                url: "{{url()->action('Admin\SubProjectController@getNextSubProjectNo', ['id' => " + subproject_id + "])}}",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data, status, xhr) {
                    if( data.length > 0 ) {
                        $("#employees option").each(function(){
                            for( i = 0; i < data.length; i++) {
                                if( data[i].emp_user_id == $(this).val() ) {
                                    $(this).prop('selected', 'true')
                                }
                            }
                        });
                    }
                },
                error: function(){
                    alert("Something went wrong.");
                }
            });
        }
    </script>
@endpush

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection