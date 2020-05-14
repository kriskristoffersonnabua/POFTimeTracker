<div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add/Edit Sub Project</h4>
            </div>

            <form id="subProjectForm">
                @csrf
                <div class="modal-body">
                    <div style="padding: 10px">
                        <label> Projects </label>
                        <select class="form-control" id="subproject-select">
                            @foreach ($projects as $project)
                                <option {{ $project_id == $project->id ? 'selected' : '' }} 
                                    value="{{$project->id}}">
                                    {{$project->project_no}} - {{$project->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="padding: 10px">
                        <label> SubProject No. </label>
                        <input type="text" class="form-control" style="width: 100%" readonly="readonly" id="subproject_no">
                    </div>

                    <div style="padding: 10px">
                        <label> SubProject Name </label>
                        <input type="text" class="form-control" style="width: 100%">
                    </div>

                    <div style="padding: 10px">
                        <label> SubProject Description </label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>