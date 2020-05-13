<div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Assign Activity Form</h4>
            </div>

            <div class="modal-body">
                
                <div class="row" style="padding-left: 10px; ">
                    <div style="display: inline-flex">
                        <label style="padding-right: 10px"> Activity No.: </label>
                        <p> 00001 </p>
                    </div>
                </div>

                <div class="row" style="padding-left: 10px; ">
                    <div style="display: inline-flex">
                        <label style="padding-right: 10px"> Title </label>
                        <p> This is a title </p>
                    </div>
                </div>

                <div class="row" style="padding-left: 10px; ">
                    <div style="display: inline-flex">
                        <label style="padding-right: 10px"> Description </label>
                        <p> This is a description. </p>
                    </div>
                </div>

                <div style="padding: 10px">
                    <label> Employees </label>
                    <select class="form-control">
                        @for ($i = 1; $i < 10 ; $i++)
                        <option> Employee {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div style="padding: 10px">
                    <label> Estimated Hours </label>
                    <input type="text" class="form-control" style="width: 100%"></input>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>