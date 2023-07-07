<?php

include 'connection.php';

if (isset($_GET['delete_category'])) {

    $confirm_delete =  "<script> var confirm = confirm('Are you sure you want to delete this category?')</script>";
    if($confirm_delete){
        $category_id = $_GET['delete_category'];
        $sql = "DELETE FROM category WHERE category_id = $category_id";
        
        if(mysqli_query($conn, $sql)){
            echo json_encode("true");
        } else {
            echo json_decode("false");
        }
    }
    die;
}

?>