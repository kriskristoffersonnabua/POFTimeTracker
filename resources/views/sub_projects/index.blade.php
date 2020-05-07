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
                        <h2>Sub Projects</h2>
                        
                        <div class="title_right">
                            <div class="col-md-4 col-sm-4 col-xs-4 form-group pull-right top_search">
                                
                                <div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 30px">
                                    <div class="col-md-3 col-sm-3 col-xs-3" style="padding-top: 10px; padding-left: 20px">
                                        <label> Projects </label>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <select class="form-control">
                                            @for ($i = 1; $i < 10 ; $i++)
                                                <option> Project 0000{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <button class="btn btn-success" type="button" data-toggle="modal" data-target=".add-sub-modal">Add Sub Project</button>
                                </div>
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
                                <th class="th-sm" style="width: 5%">Sub Project No.</th>
                                <th class="th-sm" >Name</th>
                                <th class="th-sm" >Description</th>
                                <th class="th-sm" style="width: 20%">Links</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=0; $i < 20; $i++)
                                <tr>
                                    <td style="width: 5%">#</td>
                                    <td  >
                                        <a>Pesamakini Backend UI</a>
                                        <br />
                                        <small>Created 01.01.2015</small>
                                    </td>
                                    <td> 
                                    DataTables has most features enabled by default, 
                                    so all you need to do to use it with your own tables is to call the construction function:
                                    </td>
                                    <td style="width: 25%">
                                        <a href="#" class="btn btn-dark btn-sm" data-toggle="modal" data-target=".assign-modal">
                                            <i class="fa fa-check"></i> Assign 
                                            </a>
                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> View </a>
                                        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target=".add-sub-modal">
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".delete-modal">
                                            <i class="fa fa-trash-o"></i> Delete 
                                        </a>
                                    </td>
                                </tr>
                                @endfor
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

        <div class="modal fade add-sub-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.add-sub-modal')
        </div>

        <div class="modal fade assign-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.assign-modal')
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