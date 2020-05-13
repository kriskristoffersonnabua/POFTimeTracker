<div class="modal-dialog modal-sm" style="width: 450px">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Sub Project Details</h4>
            </div>

            <div class="modal-body">

                <div style="padding: 5px">
                    <label> Sub Project No. </label>
                    <p> Sub Project 00001 </p>
                </div>

                <div style="padding: 5px">
                    <label> Sub Project Name </label>
                    <p> Pesamakini Backend UI </p>
                </div>

                <div style="padding: 5px">
                    <label> Description </label>
                    <p> This is a description. This is a description. </p>
                </div>

                <div style="padding: 5px">
                    <label> Team Leader </label>
                    <p> Lee Kwang Soo </p>
                </div>

                <div style="padding: 5px">
                    <label> Members </label>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 300px;">
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                <th class="th-sm" style="width: 50%">Employee Name</th>
                                <th class="th-sm" >Total Time Consumed</th>
                                <th class="th-sm" >Date Assigned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=0; $i < 5; $i++)
                                <tr>
                                    <td >
                                        <p>Kang Daniel</p>
                                    </td>
                                    <td> 
                                        <p>05/05/2020</p>
                                    </td>
                                    <td> 
                                        <p>05/05/2020</p>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>