<?php

$hostname = "localhost";
$username = "root";
$password = "root";
$dbname = "food_ordering_system";

$conn = new mysqli($hostname,$username,$password,$dbname);

if($conn->connect_error){
    echo "Unable to connect with database : " . mysqli_connect_error();
}


?>