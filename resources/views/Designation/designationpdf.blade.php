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
</style>

  <body style="background: #f3f3f3">
    <div class="container-fluid" style="padding: 10px;">
      <div class="row" style="margin: 10px;">
     <div class="col-md-6">
      <h3 class="content-header-title mb-0">Designation Details</h3>
       <p class="syn_font"><i class="fas fa-inr"></i>Designation ID: <strong style="font-weight: bolder;">{{$designation ->id}}</strong></p> 
     </div>
     <div class="col-md-6" style="display: flex;justify-content: right;">
      <div class="mr-2">
       <button class="btn btn-secondary hidden-print btn-sm" onclick="myFunction()"><i class="fas fa-print"></i> Print</button>
      </div>
     
     </div>
    </div>
    <div class="row bg-white" style="margin: 20px;margin-top: -4px; padding:30px">
    <div class="col-md-12 ">
    <div class="row">
      <div class="col-md-4 ">
      <p class="syn_font text-center " style="margin-bottom:0px"> <strong style="font-weight: bolder; ">{{$designation->id}}</strong></p> 
      <img id="barcode" class="img-responsive" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAiwAAAA+CAYAAAAI9kBQAAAHbUlEQVR4nO2WUWpcQRADfStDyP2vFd8gtpBaI0wV7N9OT6ERj/74BwAAADDOx2sBAAAAgO9gYQEAAIB5WFgAAABgHhYWAAAAmIeFBQAAAOZhYQEAAIB5WFgAAABgHhYWAAAAmIeFBQAAAOb58cLy+efvf3/f/V+d7+LOS59P55W+L+3rvj99+N19uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfJlYSmdX/tAtAua9lehD1t9uPZz57XzVe9r56NynW/a//X7qbg+6jw375QvC0vp/NoHol3QtL8Kfdjqw7WfO6+dr3pfOx+V63zT/q/fT8X1Uee5ead8WVhK59c+EO2Cpv1V6MNWH6793HntfNX72vmoXOeb9n/9fiqujzrPzTvly8JSOr/2gWgXNO2vQh+2+nDt585r56ve185H5TrftP/r91NxfdR5bt4pXxaW0vm1D0S7oGl/Ffqw1YdrP3deO1/1vnY+Ktf5pv1fv5+K66POc/NO+bKwlM6vfSDaBU37q9CHrT5c+7nz2vmq97XzUbnON+3/+v1UXB91npt3ypeFpXR+7QPRLmjaX4U+bPXh2s+d185Xva+dj8p1vmn/1++n4vqo89y8U74sLKXzax+IdkHT/ir0YasP137uvHa+6n3tfFSu8037v34/FddHnefmnfL98cICAAAA8AoWFgAAAJiHhQUAAADmYWEBAACAeVhYAAAAYB4WFgAAAJiHhQUAAADmYWEBAACAeVhYAAAAYB4WFgAAAJiHhQUAAADmYWEBAACAeb4AKoM7OJCH/N4AAAAASUVORK5CYII=" style="width: 371px;">
    
      </div>
      <div class="col-md-4  text-center">
        <h4 ><u><b>{{$designation ->name}}</b></u></h4>
      </div>
      </div>
      <hr>
    </div>
    

    
<div class="col-md-12 ">
<h4><u>Designation Details</u></h4>
<div class="row">

<div class="col-md-3">
 <h6 class="fnt">Enabled</h6>
 @if($designation->enabled==1)
 <p><span class="tag tag tag-success">Yes</span></p>
 @else
 <p><span class="tag tag tag-danger">No</span></p>
 @endif
</div>

<div class="col-md-3">
 <h6 class="fnt">Description</h6>
 <p>{{!empty($designation ->description)?$designation ->description:'---'}} </p>
</div>


    
    <div class="col-md-3">
 <h6 class="fnt">Created On</h6>
 <p>{{!empty($designation ->created_at)?$designation ->created_at:'---'}} </p>
</div>
  <div class="col-md-3">
 <h6 class="fnt">Created By</h6>
 <p>{{!empty($designation ->created_by)?$designation ->created_by:'---'}} </p>
</div>
    </div>


</div>

  
</div>

</div> 
    </div>
  </div>
   
    <script>
      function myFunction() {
    window.print();
}
    </script>
  <script src="{{asset('/js/pdf/fstdropdown.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>