<div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add/Edit Sub Project</h4>
            </div>

            

            <div class="modal-body">

                <div style="padding: 10px">
                    <label> Projects </label>
                    <select class="form-control">
                        @for ($i = 1; $i < 10 ; $i++)
                        <option> Project 0000{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div style="padding: 10px">
                    <label> Sub Project No. </label>
                    <input type="text" class="form-control" style="width: 100%" readonly="readonly" placeholder="00001"></input>
                </div>

                <div style="padding: 10px">
                    <label> Project Name </label>
                    <input type="text" class="form-control" style="width: 100%"></input>
                </div>

                <div style="padding: 10px">
                    <label> Project Description </label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>