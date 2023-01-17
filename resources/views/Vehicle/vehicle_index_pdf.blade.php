<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vehicles</title>
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

        <table id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true"
            data-show-refresh="true" data-show-toggle="true" data-pagination="true" data-toolbar="#toolbar">

            <thead>

                <tr>


                    <th data-field="prenom" data-sortable="true">Id</th>

                    <th data-field="date" data-sortable="true">Vehicle No.</th>

                    <th data-field="note3" data-sortable="true">Fuel Type </th>

                    <th data-field="note31" data-sortable="true">Manufacturer</th>

                    <th data-field="note32" data-sortable="true">Owner Name</th>

                    <th data-field="note33" data-sortable="true">Driver Name</th>
                    <th data-field="note33" data-sortable="true">Plant</th>
                    <th data-field="note33" data-sortable="true">IMEI No.</th>
                    <th data-field="note33" data-sortable="true">Status</th>


                </tr>

            </thead>

            <tbody>

                <?php
                
                $i = 1;
                
                $flag = 0;
                
                ?>

                @foreach ($vehicle_info as $vehicle)
                    <?php $encrypt_id = enCrypt($vehicle->id); ?>

                    <tr>

                        <td>{{ $vehicle->vehicle_char_id }}</td>
                        <td>{{ $vehicle->number }}</td>
                        <td>{{ $vehicle->fuel_type }}</td>
                        <td>{{ $vehicle->manufacturername }}</td>

                        @php
                            
                            $flag = 1;
                            
                        @endphp



                        @if ($flag == 0)
                            <td>--</td>
                        @else
                            @php
                                
                                $flag = 0;
                                
                            @endphp
                        @endif

                        <td>{{ $vehicle->ownername }}</td>

                        <td>{{ $vehicle->drivername }}</td>
                        <td>{{ $vehicle->plant_name }}</td>
                        <td>{{ $vehicle->gps_device_imei_number }}</td>
                        <td>{{ $vehicle->onBoard == 1 ? 'Active' : 'In Active' }}</td>

                    </tr>

                    <?php
                    
                    $i++; ?>
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
