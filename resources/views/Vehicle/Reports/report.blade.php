 <!DOCTYPE html>
<html>
<head>
	<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding:10px;
}
</style>
</head>
<body>

	<center><h2>Vehicles</h2>
  <p style="margin-top:-20px">Vehicles</p>
</center>
</div>
<div style="display:flex; justify-content:center; ">
<table style=" width:80% ; text-align:center">
  <tr>
    <th>Id</th>
    <th>Vehicle Number</th> 
    <th>Driver Name</th>
    <th>Driver Number</th>
   <th>Helper Name</th>
   <th>Helper Number</th>
   <th>Rate Per Km</th>
    <th>STATUS</th>
 
    <th>CREATED ON</th>
 
  </tr>
  @php
  $flag=0;
  @endphp
  @foreach($vehicle as $vehicles)
  <tr>
    <td>{{$vehicles->id}}</td>
    <td>{{$vehicles->vehicle_Number}}</td>
       <td>{{$vehicles->driver_Name}}</td>
        <td>{{$vehicles->driver_Contact}}</td>
        <td>{{$vehicles->helper_Name}}</td>
         <td>{{$vehicles->helper_Contact}}</td>
         <td>{{$vehicles->rate_perkm}}</td>
    <td>Active</td>
    
 


                                                     
    
   
<td>{{$vehicles->created_at}}</td>


  </tr>
 @endforeach
</table>
</div>
</body>
</html> 