
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Designation</title>
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
    <!--  <select class="form-control">-->
    <!--    <option value="">Export Basic</option>-->
    <!--    <option value="all">Export All</option>-->
    <!--    <option value="selected">Export Selected</option>-->
    <!--  </select>-->
    <!--</div>-->

    <table id="table" data-toggle="table" data-search="true" data-filter-control="true"
        data-show-export="true" data-show-refresh="true" data-show-toggle="true"
        data-pagination="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th data-field="date23" data-sortable="true">Id</th>

                <th data-field="date" data-sortable="true">Designation Name</th>

                <th data-field="note" data-sortable="true">Description</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($designation as $designation_details)
                <?php
                $encrypt_id = enCrypt($designation_details->id);
                
                ?>
                <tr>
                    
                    <td>{{ $designation_details->char_id }}</a></td>
                    <td>{{ $designation_details->name }}</td>

                    <td>{{ $designation_details->description }}</td>

                   

                </tr>
            @endforeach

        </tbody>
    </table>
</div>
</div>

</div>
<svg xmlns="" version="1.1">
<defs>
<filter id="goo">
    <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7"
        result="goo"></feColorMatrix>
    <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
</filter>
</defs>
</svg>
<!-- Close Row -->
</div>
<!-- Close Container -->
</div>
</body>