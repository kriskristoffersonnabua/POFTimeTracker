    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Activity Form </h4>
            </div>

            <div class="modal-body">
                <div class="x_panel" style="padding: 10px;">
                    <div class="row" style="display: flex;">
                        <div style="width: 500px;">
                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-8 col-sm-8 col-xs-8" style="padding-top: 12px">
                                    <label> Sub Project No.: </label>
                                </div>
                                <select id="subproject" class="form-control">
                                    @foreach ($subprojects as $subproject)
                                        <option value="{{$subproject->id}}"> {{ $subproject->subproject_name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-8 col-sm-8 col-xs-8" style="padding-top: 12px">
                                    <label> Activity No. </label>
                                </div>
                                <input id="activity_no" type="text" class="form-control" style="width: 100%; text-align: right" 
                                    readonly="readonly" placeholder="00001">
                                </input>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                <label> TBAs: </label>
                                @for( $i= 0 ; $i < 5 ; $i ++ )
                                <div style="padding-top: 5px">
                                    <input type="text" class="form-control" style="width: 100%;">
                                    </input>
                                </div>
                                @endfor
                            </div>
                                
                            <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                <label> List of Files: </label>
                                @for( $i= 0 ; $i < 5 ; $i ++ )
                                <input type="file"> </input>
                                @endfor
                            </div>
                        </div>

                        <div style="width: 500px;">
                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                    <label> Title: </label>
                                </div>
                               <input id="title" type="text" class="form-control" style="width: 100%; text-align: right">
                               </input>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                    <label> Description: </label>
                                </div>
                                <textarea id="description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                    <label> Status </label>
                                </div>
                                <input id="status" type="text" class="form-control" style="width: 100%; text-align: right">
                                </input>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                <label> Acceptance Criteria: </label>
                                <div style="padding-top: 5px">
                                    <input id="acceptanceCriteria" type="text" class="form-control" style="width: 100%;">
                                    </input>
                                </div>    
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                <label> Estimated Hours: </label>
                                <div style="padding-top: 5px">
                                    <input id="estimatedHours" type="text" class="form-control" style="width: 100%;">
                                    </input>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="createActivity" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

    @push('scripts') 
        <script>
           var subproject_id , updated_activity_no;

           $('#subproject').on('change',function(e){
                subproject_id = $(this).val();
               
                $.ajax({
                    type:'GET',
                    url:'/api/activity?subproject_id=' + subproject_id,
                    data:{},
                    success:function(data) {
                        $('#activity_no').val(1);

                        if (data.data.length) {
                            var recent_activity = Object.keys(data.data).pop();
                            updated_activity_no = parseInt(data.data[recent_activity]['activity_no']) + 1;
                            $('#activity_no').val(updated_activity_no);
                        }
                    }
                });
            });

            $('#createActivity').on('click', function(e){
                var description = $('#description').val();
                var title = $('#title').val();
                var status = $('#status').val();
                var acceptanceCriteria = $('#acceptanceCriteria').val();
                var estimatedHours = parseInt($('#estimatedHours').val());
                var employeeId = 1

                $.ajax({
                    type:'POST',
                    url:'/api/activity',
                    data:{
                        subproject_id:subproject_id, 
                        activity_no:updated_activity_no, 
                        title:title,
                        description:description,
                        acceptance_criteria:acceptanceCriteria,
                        estimated_hours:estimatedHours,
                        status:status,
                        employee_user_id:employeeId
                    },
                    success:function(data) {
                        
                    }
                });
               
            })
        </script>
    @endpush  
    
 
    