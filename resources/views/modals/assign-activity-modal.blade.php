<div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Assign Activity Form</h4>
            </div>
            <form id="assignActivityForm">
                @csrf
                <div class="modal-body">
                    <div class="row" style="padding-left: 10px; ">
                        <div style="display: inline-flex">
                            <label style="padding-right: 10px"> Activity No.: </label>
                            <p class="activity_no">  </p>
                        </div>
                    </div>
    
                    <div class="row" style="padding-left: 10px; ">
                        <div style="display: inline-flex">
                            <label style="padding-right: 10px"> Title: </label>
                            <p class="activity_title"> </p>
                        </div>
                    </div>
    
                    <div class="row" style="padding: 10px">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label> Employees </label>
                            <select class="form-control" name="employee_user_id">
                                @foreach($users as $user)
                                    @if(!$user->hasRole('administrator'))
                                    <option value="{{$user->id}}">{{$user->employee_no}} - {{$user->first_name}} {{$user->last_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label> Estimated Hours </label>
                            <input type="number" name="estimated_hours" step="0.01" class="form-control" style="width: 100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="project_id"/>
                    <input type="hidden" name="subproject_id"/>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>