<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
        </div>

        <form id="addEditForm">
            @csrf
            <div class="modal-body">

                <div style="padding: 10px">
                    <label> Employee No. </label>
                    <input name="employee_no" type="text" class="form-control" style="width: 100%" value="{{$next}}" readonly="readonly" placeholder="00001"/>
                </div>

                <div style="padding: 10px">
                    <label> Email </label>
                    <input name= "email" type="text" class="form-control" style="width: 100%"/>
                </div>

                <div style="padding: 10px">
                    <label> First name </label>
                    <input name= "first_name" type="text" class="form-control" style="width: 100%"/>
                </div>

                <div style="padding: 10px">
                    <label> Last name </label>
                    <input name= "last_name" type="text" class="form-control" style="width: 100%"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>