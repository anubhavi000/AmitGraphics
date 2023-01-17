<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get name from url</title>
</head>
<body>

<!--  for assigning value to variable from url -->
<?php
$url = $_SERVER['REQUEST_URI'];    
$exploded_arr=explode('/' , $url);
$count = count($exploded_arr);
$var=[];
for($i=$count-2; $i<=$count; $i++){
if(!empty($exploded_arr[$i])){
    $var[]= $exploded_arr[$i].'</br>';
}
}

?>

 <!-- for using that variables  -->
<p>hello <b><?php echo $var[0]; ?></b></p>
<p>your title is  <b><?php echo $var[1]; ?></b></p>
</body>
</html>