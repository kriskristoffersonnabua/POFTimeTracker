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
                        <h2>Activities</h2>
                        
                        <div class="title_right">
                            <div class="form-group pull-right top_search">
                                
                                @if(auth()->user()->hasRole('administrator'))
                                <div style="padding-left: 30px">
                                @else
                                <div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 30px">
                                @endif
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label> Sub Projects </label>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <select class="form-control">
                                            @for ($i = 1; $i < 10 ; $i++)
                                                <option> Sub Project 0000{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                @if(!auth()->user()->hasRole('administrator'))
                                <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                                    <button class="btn btn-success" type="button" data-toggle="modal" data-target=".activity-form-modal">Add Activity</button>
                                </div>
                                @endif
                            </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>

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
                                <th class="th-sm">Sub Project Name</th>
                                <th class="th-sm">Status</th>
                                @if(auth()->user()->hasRole('administrator'))
                                <th class="th-sm">Date Added</th>
                                <th class="th-sm" style="width: 10%">Links</th>
                                @else
                                <th class="th-sm" style="width: 35%;">Links</th>
                                @endif
                                
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
                                        Sub Project 101
                                    </td>
                                    <td>
                                        On Going
                                    </td>
                                    @if(auth()->user()->hasRole('administrator'))
                                    <td>
                                        Created 01.01.2015
                                    </td>
                                    @endif
                                    <td>

                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".view-modal">
                                            <i class="fa fa-folder"></i> View 
                                        </a>
                                        @if(!auth()->user()->hasRole('administrator'))
                                        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target=".activity-form-modal">
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a href="#" class="btn btn-dark btn-sm" data-toggle="modal" data-target=".assign-activity-modal">
                                            <i class="fa fa-check"></i> Assign 
                                        </a>
                                        <a href="#" class="btn btn-success btn-sm">
                                            <i class="fa fa-thumbs-up"></i> For Testing 
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".delete-modal">
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
            @include('modals.assign-activity-modal')
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