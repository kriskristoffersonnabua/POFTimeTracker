    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> View Details </h4>
            </div>

            <div class="modal-body">

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#details" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Details</a>
                        </li>
                        <li role="presentation" class=""><a href="#comments" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Comments</a>
                        </li>
                        <li role="presentation" class=""><a href="#timehist" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Employees Time History</a>
                        </li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="details" aria-labelledby="home-tab">
                            <div class="x_panel" style="padding: 10px;">
                                <div class="row" style="display: flex;">
                                    <div style="width: 350px;">
                                        <div style="display: inline-flex; padding-left: 20px;">
                                            <label> Sub Project No.: </label>
                                            <p style="padding-left: 15px"> 00001 </p>
                                        </div>

                                        <div style="display: inline-flex; padding-left: 20px;">
                                            <label> Sub Project Name: </label>
                                            <p style="padding-left: 15px"> Sub Project 101 </p>
                                        </div>

                                        <div style="display: inline-flex; padding-left: 20px; ">
                                            <label> Activity No.: </label>
                                            <p style="padding-left: 15px"> 00001 </p>
                                        </div>

                                        <div style="padding-left: 20px; ">
                                            <label> TBAs: </label>
                                            @for( $i= 0 ; $i < 5 ; $i ++ )
                                            <p style="padding-left: 15px"> TBA {{ $i }} </p>
                                            @endfor
                                        </div>
                                            
                                        <div style="padding-left: 20px; ">
                                            <label> List of Files: </label>
                                            @for( $i= 0 ; $i < 5 ; $i ++ )
                                            <p style="padding-left: 15px"> File {{ $i }} </p>
                                            @endfor
                                        </div>

                                    </div>

                                    <div style="width: 500px;">
                                        <div style="display: inline-flex; padding-left: 20px;">
                                            <label> Title </label>
                                            <p style="padding-left: 15px"> Pesamakini Backend UI </p>
                                        </div>

                                        <div style="display: inline-flex; padding-left: 20px; ">
                                            <label> Description: </label>
                                            <p style="padding-left: 15px"> This is a description.
                                                This is a description.
                                                This is a description.
                                                This is a description.
                                                This is a description.
                                                This is a description.
                                                This is a description.
                                            </p>
                                        </div>

                                        <div style="padding-left: 20px; ">
                                            <label> Acceptance Criteria: </label>
                                            @for( $i= 0 ; $i < 5 ; $i ++ )
                                            <p style="padding-left: 15px"> Acceptance Criteria {{ $i }} </p>
                                            @endfor
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="comments" aria-labelledby="profile-tab">
                            <div class="x_panel" style="padding: 10px;">
                                <div style="padding: 10px">
                                    <textarea class="form-control" rows="2" placeholder="Please type your comment here."></textarea>
                                </div>
                                <div  class="pull-right">
                                    <button type="button" class="btn btn-primary">Add Comment</button>
                                </div>
                                
                                <div class="x_content">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 400px">
                                        <table id="datatable" class="table table-striped projects" >
                                            <thead>
                                                <tr> 
                                                    <th style="width: 170px"> Date </th> 
                                                    <th> Comment </th>                                               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for( $i = 0; $i < 20; $i++)
                                                <tr>
                                                    <td style="width: 170px"> 01/01/2001 11:00am </td>
                                                    <td> Comment number {{ $i }}</td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="timehist" aria-labelledby="profile-tab">
                            <div class="x_panel" style="padding: 10px;">
                                <div class="x_content">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 510px">
                                        <table id="datatable" class="table table-striped projects" >
                                            <thead>
                                                <tr> 
                                                    <th style="width: 170px"> Date </th> 
                                                    <th> Employee Name </th>   
                                                    <th> Time Start </th>
                                                    <th> Time End </th>  
                                                    <th> Time Consumed </th>                                              
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for( $i = 0; $i < 20; $i++)
                                                <tr>
                                                    <td style="width: 170px"> 01/01/2001 11:00am </td>
                                                    <td> Lee Min Ho</td>
                                                    <td> 11:00 am </td>
                                                    <td> 11:00 pm </td>
                                                    <td> 12 hrs </td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>