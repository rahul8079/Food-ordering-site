<?php

include 'connection.php';

session_start();

$user_id = $_SESSION['user_id'];
$sql = "SELECT name,email,phone,address from users where user_id = '$user_id'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

    $row = mysqli_fetch_assoc($result);
    

    
}

?>