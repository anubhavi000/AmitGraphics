<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/pdf/fstdropdown.css')}}">
    

    <title>Synergy</title>
  </head>
<style>
  .syn_font{
    color: #818A91;
  }
  .syn_drop{
    left: -150px !important;
  }
  .tag{
    display: inline-block;
padding: .35em .4em;
font-size: 85%;
font-weight: 600;
line-height: 1;
color: #FFF;
text-align: center;
vertical-align: baseline;
border-radius: .18rem;
  }
  .tag-danger{
    background-color: #FFB64D;
  }
  .tag-success {
    background-color: #37BC9B;
}
.dwn{
  background-color: #4f81a4;
  border: 1px solid #4f81a4;
}
.fnt{
  font-weight: bold;
}
.btn-blue{
    background-color:steelblue;
    color:white;
}
</style>

  <body style="background: #f3f3f3">
   
    <div class="container-fluid" style="padding: 10px;">
      <div class="row" style="margin: 10px;">
     <div class="col-md-6">
      <h3 class="content-header-title mb-0">Vehicle Renewal Details</h3>

       <p class="syn_font"><i class="fas fa-suitcase"></i>Vehicle ID: <strong style="font-weight: bolder;">{{$vehicle->id??''}}</strong></p> 
     </div>
     </div>
     
       @php 
  $id= $vehicle->id;
  $encrypt_id= enCrypt($id);
  @endphp
<!--@if(session()->has('success'))-->

<!--    <div class="alert alert-success text-center">-->
<!--        {{ session()->get('success') }}-->

   

<!--    </div>-->
<!--@endif-->
    <div class="row bg-white" style="margin: 20px;margin-top: -4px; padding:30px" >
        <div class="col-md-12 " id="formdiv">
              <h3><i class="fas fa-address-book"></i> There is a pending Renewal for this Vehicle .Please Approve/Discard it to Proceed .</h3>
              <h4><u>Vehicle Details </u></h4>
               <form action='{{ url("vehicleagreementrenew/{$encrypt_id}") }}' method="POST">
                    @csrf
                    <input type="text" value="{{ $encrypt_id }}" hidden name="vehicle_id">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Vehicle Number</label>
                            <p> <input type="text" name="vehicle_no" value="{{ $vehicle->vehicle_Number ?? '' }}"
                                    class="form-control" readonly></p>
                        </div>
                        <div class="col-md-3">
                            <label>Vehicle Model</label>
                            <p> <input type="text" name="vehicle_model" value="{{ $model->model ?? '' }}"
                                    class="form-control" readonly></p>
                        </div>
                        <div class="col-md-3">
                            <label>Current Agreement Start Date</label>
                            <p> <input type="date" name="current_agreement_date"
                                    value="{{ $vehicle->renewal_start_date ?? '' }}" class="form-control" readonly></p>
                        </div>
                        <div class="col-md-3">
                            <label>Current Agreement End Date</label>
                            <p> <input type="date" name="current_agreement_end_date"
                                    value="{{ $vehicle->renewal_end_date ?? '' }}" class="form-control" readonly></p>
                        </div>
          
                    </div>

                    


                        <h4 class="mt-4"><u>Renewal Details</u></h4>
                        <div class="row">

                            <div class="col-md-2">
                                <label>Stamp Paper No </label>
                                <p> <input type="text" name="stamp_paper_no" class="form-control" ></p>
                            </div>
                            <div class="col-md-2">
                                <label>Stamp Paper Date </label>
                                <p> <input type="date" name="stamp_paper_date" class="form-control" ></p>
                            </div>
                            <div class="col-md-2">
                                <label>Renewal On </label>
                                <p> <input type="date" name="renewal_date" class="form-control" ></p>
                            </div>
                            <div class="col-md-3">
                                <label>After Renewal, Agreement Start Date </label>
                                <p> <input type="date" name="renewal_start_date" class="form-control"
                                        onchange="setagreementenddate(this.value)" ></p>
                            </div>
                            <div class="col-md-3">
                                <label>After Renewal, Agreement End Date </label>
                                <p> <input type="date" name="renewal_end_date" id="agreement_end_date"
                                        class="form-control" readonly></p>
                            </div>
                        </div>
                        <h4 class="mt-4"><u>Renewal Log</u></h4>
                        <div class="row">
                            <table class="table" id="renewalcontainer">

                           
                            <tr>
                              <td>
                                <div>
                                <label>Stamp Paper No </label>
                                <p> <input type="text" name="stamp_paper_no_logs[]" class="form-control" ></p>
                              </div>
                            </td>
                            <td><div >
                                <label>Stamp Paper Date </label>
                                <p> <input type="date" name="stamp_paper_date_logs[]" class="form-control" ></p>
                            </div></td>
                            <td><div >
                                <label>Renewal On </label>
                                <p> <input type="date" name="renewal_date_logs[]" class="form-control"></p>
                            </div></td>
                            <td><div>
                                <label>After Renewal, Agreement Start Date </label>
                                <p> <input type="date" name="renewal_start_date_logs[]" class="form-control"
                                        ></p>
                            </div></td>
                            <td><div >
                                <label>After Renewal, Agreement End Date </label>
                                <p> <input type="date" name="renewal_end_date_logs[]" 
                                        class="form-control" ></p>
                            </div></td></tr>
                          </table>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-blue mr-2" type="button" onclick="addRow()"> <i
                                    class="fas fa-plus"> </i></button>
                            <button class="btn btn-danger mr-2" type="button" onclick="deleteRow()"> <i
                                    class="fas fa-minus"> </i></button>
                        </div>
                        <div class="row mt-4">
                            <button class="btn btn-blue mr-2" type="submit"> <i class="fas fa-check">
                                </i>Approve</button>
                            <button class="btn btn-danger mr-2"> <i class="fas fa-times"> </i> Cancel</button>
                        </div>
                </form>
</div> 
    </div>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
      function myFunction() {
          window.print();
      }

      function addRow() {
           let container= document.getElementById("renewalcontainer");
           let newrow= document.createElement("tr");
           newrow.innerHTML= `<td><div >
                                <label>Stamp Paper No </label>
                                <p> <input type="text" name="stamp_paper_no_logs[]" class="form-control" ></p>
                            </div></td>
                            <td><div >
                                <label>Stamp Paper Date </label>
                                <p> <input type="date" name="stamp_paper_date_logs[]" class="form-control" ></p>
                            </div></td>
                            <td><div >
                                <label>Renewal On </label>
                                <p> <input type="date" name="renewal_date_logs[]" class="form-control" ></p>
                            </div></td>
                            <td><div>
                                <label>After Renewal, Agreement Start Date </label>
                                <p> <input type="date" name="renewal_start_date_logs[]" class="form-control"
                                        ></p>
                            </div></td>
                            <td><div >
                                <label>After Renewal, Agreement End Date </label>
                                <p> <input type="date" name="renewal_end_date_logs[]" 
                                        class="form-control" ></p>
                            </div></td>`;

                            container.appendChild(newrow);
        }
        function deleteRow() {
                    let table = document.getElementById("renewalcontainer");
                    var rows = table.getElementsByTagName("tr");
                        table.deleteRow(-1);
        }



function setagreementenddate(value){
//   alert(value);
    var year = new Date(value).getFullYear();
    var month = new Date(value).getMonth();
    // console.log(month, year);
    if(month>2) {   //greater than march
        var newdate= new Date(year+1 , "02" , "32" );
    } else {
        var newdate= new Date(year , "02" , "32" );
    }
    // console.log(newdate.toISOString().substring(0,10));
    newdate2 = newdate.toISOString().substring(0,10)
    document.getElementById("agreement_end_date").value=newdate2;
}
  </script>
  </body>
</html>