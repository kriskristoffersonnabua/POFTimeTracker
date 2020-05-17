<!DOCTYPE html>
<html>
    <head>
        <title>Report export</title>
        <style>
            .table-wrapper-scroll-y {
                display: block;
            }
            table.dataTable thead .sorting:after,
            table.dataTable thead .sorting:before,
            table.dataTable thead .sorting_asc:after,
            table.dataTable thead .sorting_asc:before,
            table.dataTable thead .sorting_asc_disabled:after,
            table.dataTable thead .sorting_asc_disabled:before,
            table.dataTable thead .sorting_desc:after,
            table.dataTable thead .sorting_desc:before,
            table.dataTable thead .sorting_desc_disabled:after,
            table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
            }
            td {
                text-align: left;
            }
        </style>
    </head>

    <body>
        <div class="main-wrap">

            <table id="datatable" class="table table-striped projects">
                <thead>
                    <tr>
                        <th class="th-sm" style="width: 10%">Date</th>
                        <th class="th-sm" >Project Name</th>
                        <th class="th-sm" >Employee Name</th>
                        <th class="th-sm" style="width: 25%">Activity</th>
                        <th class="th-sm" style="width: 8%">Time Start</th>
                        <th class="th-sm" style="width: 8%">Time End</th>
                        <th class="th-sm" style="width: 8%">Time Consumed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td style="width: 7%">{{$report['date']}}</td>
                        <td>{{$report['name']}}</td>
                        <td>{{$report['employee']['first_name'].' '.$report['employee']['last_name']}}</td>
                        <td>{{$report['activity']['title']}}</td>
                        <td>{{$report['time_start']}}</td>
                        <td>{{$report['time_end']}}</td>
                        <td>{{$report['time_consumed']}}hrs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>