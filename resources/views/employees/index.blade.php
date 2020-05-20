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
<div class="page-title">
    <div class="title_left">
        <h3>Employees</h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
            <button class="btn btn-success btn-sm addEmployee pull-right" type="button" data-toggle="modal" 
                data-target=".add-modal" 
                data-href="{{url()->action('Admin\EmployeesController@create')}}" 
                data-method="POST" data-next="{{$next}}">
                    <span class="fa fa-plus"></span>
                    Add Employee
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
                    <div class="x_content">
                        <!-- start project list -->
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th class="th-sm">Employee No.</th>
                                    <th class="th-sm">Last Name</th>
                                    <th class="th-sm">First Name</th>
                                    <th class="th-sm">Email</th>
                                    <th class="th-sm">Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($users))
                                    @foreach($users as $user)
                                        @if(!$user->hasRole('administrator'))
                                            <tr>
                                                <td>{{$user->employee_no}}</td>
                                                <td>{{$user->last_name}}</td>
                                                <td>{{$user->first_name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{date('m/d/Y', strtotime($user->created_at))}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>
                        <!-- end project list -->

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade add-modal" tabindex="-1" role="dialog" aria-hidden="true">
            @include('modals.add-employee-modal', ['next' => $next])
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
            let selected = null;
            $(document).on('click','.addEmployee',function(event){
                event.preventDefault();
                selected = $(this);
                
                $('#addEditForm').attr('action', selected.attr('data-href'));
                $('#addEditForm').attr('method', selected.attr('data-method'));
                $('input[name=employee_no]').val(selected.attr('data-next'));
                $('input[name=first_name]').val('');
                $('input[name=last_name]').val('');
                $('input[name=email]').html('');
            });
        });
    </script>
@endpush
