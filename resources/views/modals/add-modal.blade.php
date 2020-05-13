<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add/Edit Project</h4>
        </div>

        <form id="addEditForm">
            @csrf
            <div class="modal-body">
                <div style="padding: 10px">
                    <label> Project No. </label>
                    <input name="project_no" type="text" class="form-control" style="width: 100%" readonly="readonly" placeholder="00001" value="{{$next}}">
                </div>

                <div style="padding: 10px">
                    <label> Project Name </label>
                    <input name="name" type="text" class="form-control" style="width: 100%"></input>
                </div>

                <div style="padding: 10px">
                    <label> Project Description </label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>