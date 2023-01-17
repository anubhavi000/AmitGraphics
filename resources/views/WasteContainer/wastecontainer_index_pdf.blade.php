
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Waste Container</title>
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

  <table id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-show-refresh="true" data-show-toggle="true" data-pagination="true" data-toolbar="#toolbar">
    <thead>
      <tr>
          <th data-field="date234" data-sortable="true"> Id</th>
        <th data-field="date" data-sortable="true"> Name</th>
        <th style="text-align: right" data-field="examen" data-sortable="true">Volume</th>
        <th style="text-align:right" data-field="examen1" data-sortable="true">Price</th>
        <th data-field="note" data-sortable="true">Description</th>

      </tr>
    </thead>
    <tbody>
      @foreach($wastecontainer as $wastelist)
        
      <tr>
        <td>{{$wastelist->char_id}}</td>
        <td>{{$wastelist->name}}</td>
        <td>{{$wastelist->volume}}</td>
        <td>{{$wastelist->price}}</td>
        <td>{{$wastelist->description}}</td>
        
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
