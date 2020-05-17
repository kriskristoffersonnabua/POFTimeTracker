<div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Assign Sub Project</h4>
            </div>

            <form id="assignSubProjectForm">
                @csrf
                <div class="modal-body">

                    <div style="padding: 10px">
                        <label> SubProject No. </label>
                        <input type="text" class="form-control" disabled style="width: 100%" id="subpr_no" readonly="readonly" placeholder="00001">
                    </div>
    
                    <div style="padding: 10px">
                        <label> SubProject Name </label>
                        <input type="text" class="form-control" disabled id="subpr_name" style="width: 100%">
                    </div>
    
                    <div style="padding: 10px">
                        <label> Team Leader </label>
                        <select name="user_id" class="form-control" id="tl_id">
                            @foreach($users as $user)
                                @if(!$user->hasRole('administrator'))
                                <option value="{{$user->id}}">{{$user->employee_no}} - {{$user->first_name}} {{$user->last_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
    
                    <div style="padding: 10px">
                        <label> Employees </label>
                        <select name="employees[]" class="form-control mdb-select md-form" id="employees" multiple>
                            @foreach($users as $user)
                                @if(!$user->hasRole('administrator'))
                                <option value="{{$user->id}}">{{$user->employee_no}} - {{$user->first_name}} {{$user->last_name}}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="project_id" id="pro_id"/>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>