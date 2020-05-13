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
                                <input type="text" class="form-control" style="width: 100%; text-align: right" 
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
                               <input type="text" class="form-control" style="width: 100%; text-align: right">
                               </input>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                    <label> Description: </label>
                                </div>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="display: inline-flex; padding-top: 10px">
                                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-top: 12px">
                                    <label> Status </label>
                                </div>
                                <input type="text" class="form-control" style="width: 100%; text-align: right">
                                </input>
                            </div>

                            <div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 20px; padding-top: 10px">
                                <label> Acceptance Criteria: </label>
                                @for( $i= 0 ; $i < 5 ; $i ++ )
                                <div style="padding-top: 5px">
                                    <input type="text" class="form-control" style="width: 100%;">
                                    </input>
                                </div>
                                @endfor
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

    @push('scripts') 
        <script>
           $('#subproject').on('change',function(e){
                var subproject_id = $(this).val();
                console.log(subproject_id);
                $.ajax({
                    type:'GET',
                    url:'/api/activity?subproject_id=' + subproject_id,
                    data:{},
                    success:function(data) {
                        var recent_activity = Object.keys(data.data).pop();
                        console.log(data.data[recent_activity]['activity_no']);
                    }
                });
            });
        </script>
    @endpush  
    
 
    