<?php

include 'connection.php';
include 'validate_session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['image'])) {

        $file_name = $_FILES['image']['name'];
        $file_temp_name = $_FILES['image']['tmp_name'];
        $image_path = "../uploads/" . $file_name;

        move_uploaded_file($file_temp_name, $image_path);

        $category_name = $_REQUEST['name'];
        $description = $_REQUEST['description'];
        $status = $_REQUEST['status'];

        $sql = "INSERT INTO category (category_name,description,status,image) VALUES('$category_name','$description',
        '$status', '$image_path')";

        if (mysqli_query($conn, $sql)) {

            echo "<script> alert('Category Added Successfully!!'); </script>";
     
        } else {
            echo "<script> alert('Error') </script>";
            exit;
        }
    }
}

?>


<!Doctype html>

<html>

<head>

    <title>Add Category</title>
    <link rel="stylesheet" type="text/css" href="css/seller_dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/admin_dashboard.css">

</head>

<body>

    <div class="outer-container">
        <?php
        include 'sidebar.php';
        ?>

        <div id='add-category-form'>
            <form action='add_category.php' method='post' enctype='multipart/form-data'>
                <label for='name'>Category Name:</label>
                <input type='text' name='name' id='name' required><br>
                <label for='description'>Description:</label>
                <textarea name='description' id='description' rows='4' required></textarea><br>
                <label for='status'>Status:</label>
                <select name='status' id='status'>
                    <option value='active'>Active</option>
                    <option value='Not Active'>Not Active</option>
                </select><br><br>
                <label for='image'>Upload Image:</label>
                <input type='file' name='image' id='image' required><br><br><br>
                <input type='submit' value='Add Category'>
            </form>
        </div>
    </div>

</body>

</html>