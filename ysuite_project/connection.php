<?php
    $conn = mysqli_connect("localhost", "root", "#password#", "db");
    if(mysqli_connect_error()){
        die("ERROR : Unable to connect:" . mysqli_connect_error());
    } 
?>
