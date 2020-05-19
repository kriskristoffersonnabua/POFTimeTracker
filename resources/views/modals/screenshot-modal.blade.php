    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Screenshots </h4>
            </div>

            <div class="modal-body">

                <div class="x_panel" style="padding: 10px;">
                    <div class="row" style="display: flex;">
                        <div style="width: 800px;">
                            <div style="display: flex; padding-left: 20px;">
                                <label> Date </label>
                                <p style="padding-left: 15px" id="reportDate"></p>
                            </div>

                            <div style="display: flex; padding-left: 20px;">
                                <label> Employee Name: </label>
                                <p style="padding-left: 15px" id="employeeName"></p>
                            </div>

                            <div style="display: flex; padding-left: 20px; ">
                                <label> Project Name </label>
                                <p style="padding-left: 15px" id="projectName"></p>
                            </div>

                            <div style="display: flex; 20px; padding-left: 20px; ">
                                <label> Activity Title </label>
                                <p style="padding-left: 15px" id="activityTitle"></p>
                            </div>
                        </div>

                        <div style="width: 500px;">
                            <div style="display: flex; padding-left: 20px; ">
                                <label> Time Start </label>
                                <p style="padding-left: 15px" id="timeStart"></p>
                            </div>

                            <div style="display: flex; padding-left: 20px; ">
                                <label> Time End </label>
                                <p style="padding-left: 15px" id="timeEnd"></p>
                            </div>

                            <div style="display: flex; padding-left: 20px; ">
                                <label> Time Consumed </label>
                                <p style="padding-left: 15px" id="timeConsumed"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: flex; padding: 0px 10px 10px 10px;">
                        <div class="x_panel" style="margin-right: 5px">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 500px">
                                <table id="datatable" class="table table-striped screenshots">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="x_panel screenshot" style="margin-right: 5px">
                            <img style="width: 100%;" src="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>