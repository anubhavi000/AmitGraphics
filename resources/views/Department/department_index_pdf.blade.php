
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department</title>
    <style>
        table {
            width: 100%;
        }

        table,
        tr,
        td,
        th {
            margin: 0px;

            border: 1px solid black;
            border-collapse: collapse;
            font-size: 13px;
        }
    </style>
</head>
<body>
                            <div id="hide_2" class="table-responsive">
                                <!--<div id="toolbar">-->
                                <!--    <select class="form-control">-->
                                <!--        <option value="">Export Basic</option>-->
                                <!--        <option value="all">Export All</option>-->
                                <!--        <option value="selected">Export Selected</option>-->
                                <!--    </select>-->
                                <!--</div>-->

                                <table id="table" data-toggle="table">
                                    <thead>
                                        <tr>
                                            
                                             <th data-field="date12" data-sortable="true">Id</th>

                                            <th data-field="date1" data-sortable="true">Name</th>

                                           
                                            <th data-field="date4" data-sortable="true">Description</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department as $department_details)
                                           
                                        <tr>
                                           
                                           <td >{{$department_details->char_id}}</td>
                                            <td>{{$department_details->name}}</td>
                                         
                                            <td>{{$department_details->description}}</td>
                                        
                                            

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- Close Row -->
                </div>
                <!-- Close Container -->
            </div>
          </body>
  