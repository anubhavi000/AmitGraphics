<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <fieldset>
      <div style="text-align: center" class="container">
<h1>Update Whatsapp Recievers here</h1>
<form method="POST" class=form-group action="/whats">
    @csrf
    <input type="text" name="userid" placeholder="Enter Userid ">
  <input type="text" name="name" placeholder="enter new name to be Updated ">
  <input type="email" name="email" placeholder="enter respective email">
  <input type="text" name=phone placeholder="enter the whatsapp number">
  <Button type="submit" class="btn btn-primary">Add Now</Button>

</form>
</fieldset>
<fieldset>
    <div class="container" style="text-align: center">
        <h1>Send Message Now</h1>
    <form method="POST" action="/send" class="form-group">
        @csrf
    <input type="text" name = "phone" placeholder="enter the phone number">
    <input type ="text" name="reciever" placeholder= "client name">
    <input type="date" class="datepicker" name ="bill_date" placeholder="Bill no">
  <Button type="submit" class="btn btn-primary">Send Now</Button>
    </form>
    </div>
</fieldset>

    
   
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
