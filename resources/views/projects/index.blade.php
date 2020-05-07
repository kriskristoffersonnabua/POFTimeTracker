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
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="col-md-3 col-sm-3 col-xs-3" style="padding-left: 30px">
                                    <button class="btn btn-success" type="button" data-toggle="modal" data-target=".add-modal">Add Project</button>
                                </div>
                            
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
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
                                <th class="th-sm" style="width: 5%">Project No.</th>
                                <th class="th-sm" >Project Name</th>
                                <th class="th-sm" >Project Description</th>
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
                                    <td style="width: 20%">
                                        <a href="#" class="btn btn-primary btn-s"><i class="fa fa-folder"></i> View </a>
                                        <a href="#" class="btn btn-info btn-s" data-toggle="modal" data-target=".add-modal">
                                            <i class="fa fa-pencil"></i> Update 
                                        </a>
                                        <a href="#" class="btn btn-danger btn-s" data-toggle="modal" data-target=".delete-modal">
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

        <div class="modal fade add-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.add-modal')
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