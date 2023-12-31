<?php

$con=mysqli_connect("localhost","root","", "mystore",3308);
if(!$con){
    die(mysqli_error("Error"+$con));
}
?>