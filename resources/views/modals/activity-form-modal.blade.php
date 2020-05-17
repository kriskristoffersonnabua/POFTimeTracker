    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Activity Form </h4>
            </div>

            <form id="activityForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="x_panel" style="padding: 10px;">
                        <div class="row" style="display: flex;">
                            <div style="width: 500px;">
                                <div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 10px">
                                    <div class="col-md-4 col-sm-6 col-xs-12" style="padding-top:8px">
                                        <label> SubProject: </label>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select id="subproject" class="form-control" name="subproject_id">
                                            @foreach ($subprojects as $project)
                                                @php $show = true @endphp
                                                @if(app('request')->input('project_id') != "" && app('request')->input('project_id') != $project->project_id)
                                                    @php $show = false @endphp
                                                @endif
                            
                                                @if($show) 
                                                    <option {{ app('request')->input('subproject_id') == $project->id ? 'selected' : '' }} 
                                                        value="{{$project->id}}" data-project_id="{{$project->project_id}}">
                                                        {{$project->subproject_no}} - {{$project->subproject_name}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-12" style="padding-top: 10px">
                                    <div class="col-md-4 col-sm-6 col-xs-12" style="padding-top: 8px">
                                        <label> Activity No. </label>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="activity_no" name="activity_no" type="text" class="form-control" 
                                            readonly="readonly" placeholder="00001">
                                    </div>
                                </div>
    
                                <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                    <label> TBAs: </label>
                                    @for( $i= 0 ; $i < 3 ; $i ++ )
                                    <div style="padding-top: 5px">
                                        <input type="text" name="tba[]" class="form-control" style="width: 100%;">
                                    </div>
                                    @endfor
                                </div>
                                    
                                <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                    <label> List of Files: </label>
                                    @for( $i= 0 ; $i < 3 ; $i ++ )
                                    <input type="file" name="file[]">
                                    @endfor
                                </div>
                            </div>
    
                            <div style="width: 500px;">
                                <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                    <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                        <label> Title: </label>
                                    </div>
                                   <input name="title" type="text" class="form-control" style="">
                                </div>
    
                                <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                    <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                        <label> Description: </label>
                                    </div>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                    <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                        <label> Acceptance Criteria: </label>
                                    </div>
                                    <textarea name="acceptance_criteria" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <input type="hidden" name="project_id"/>
                    <button id="createActivity" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>