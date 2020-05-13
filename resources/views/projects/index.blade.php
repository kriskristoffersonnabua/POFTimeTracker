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
                <div class="x_panel" style="width: 90%;">
                    <div class="x_title">
                        <h2>Projects</h2>
                        <div class="title_right">
                            <div class="col-md-1 col-sm-1 col-xs-1 form-group pull-right top_search">
                                <button class="btn btn-success addProject" type="button" data-toggle="modal" data-target=".add-modal" data-href="{{url()->action('Admin\ProjectController@create')}}" data-method="POST" data-next="{{$next}}">Add Project</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 form-group pull-right top_search" style="height: 30px">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default searchProjects" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                    <div class="x_content">
                        <!-- start project list -->
                        
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                <th class="th-sm" style="width: 5%">Project No.</th>
                                <th class="th-sm" >Project Name</th>
                                <th class="th-sm" >Project Description</th>
                                <th class="th-sm" style="width: 20%">Links</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td style="width: 5%">{{$project->project_no}}</td>
                                    <td  >
                                        <a>{{ $project->name}}</a>
                                        <br />
                                        <small>{{ $project->created_at}}</small>
                                    </td>
                                    <td> 
                                    {{ $project->description}}
                                    </td>
                                    <td style="width: 20%">
                                        <a href="{{ route('subprojects')}}" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> View </a>

                                        @if(auth()->user()->hasRole('administrator'))
                                        <a href="{{url()->action('Admin\ProjectController@update', ['id' => $project->id])}}" data-id="{{$project->id}}" data-project_no="{{$project->project_no}}" data-name="{{$project->name}}" data-description="{{$project->description}}" class="btn btn-info btn-sm updateProject" data-toggle="modal" data-target=".add-modal">
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a href="{{url()->action('Admin\ProjectController@destroy', ['id' => $project->id])}}" data-id="{{$project->id}}" class="btn btn-danger btn-sm deleteProject" data-toggle="modal" data-target=".delete-modal">
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
        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.delete-modal')
        </div>

        <div class="modal fade add-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.add-modal', ['next' => $next])
        </div>

        <!---- End of Modals ---->
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
    <script>
    $(document).ready(function(){
        let selected = null;
        $(document).on('click','.searchProjects',function(event){
            event.preventDefault();
            selected = $(this);
            
            let search = $('input[name=search]').val();
            document.location.search =  "?name=" + search;
        });

        $(document).on('click','.addProject',function(event){
            event.preventDefault();
            selected = $(this);
            
            $('#addEditForm').attr('action', selected.attr('data-href'));
            $('#addEditForm').attr('method', selected.attr('data-method'));
            $('input[name=project_no]').val(selected.attr('data-next'));
            $('input[name=name]').val('');
            $('textarea[name=description]').html('');
            $('#addEditForm').find('input[name=_method]').remove();
        });

        $(document).on('click','.updateProject',function(event){
            event.preventDefault();
            selected = $(this);
            
            $('#addEditForm').attr('action', selected.attr('href'));
            $('#addEditForm').attr('method', "POST");
            $('input[name=project_no]').val(selected.attr('data-project_no'));
            $('input[name=name]').val(selected.attr('data-name'));
            $('textarea[name=description]').html(selected.attr('data-description'));
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value:"PATCH"
            }).appendTo('#addEditForm');
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
    </script>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection