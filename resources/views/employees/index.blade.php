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
                        <h2>Employees</h2>
                        <div class="clearfix"> </div>
                    </div>

                    <div class="x_content">
                        <!-- start project list -->
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th class="th-sm" style="width: 7%">Employee No.</th>
                                    <th class="th-sm">Last Name</th>
                                    <th class="th-sm">First Name</th>
                                    <th class="th-sm">Email</th>
                                    <th class="th-sm" style="width: 15%">Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=0; $i < 20; $i++)
                                <tr>
                                    <td>101</td>
                                    <td>
                                        <a>Ji</a>
                                    </td>
                                    <td>
                                        Chang Wook
                                    </td>
                                    <td>
                                        jichangwook@gmail.com
                                    </td>
                                    <td>
                                        01/01/2015
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