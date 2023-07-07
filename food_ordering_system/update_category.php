<?php

include 'connection.php';
include 'validate_session.php';

$category_id;
$category_name;
$description;
$status;
$image;

if (isset($_GET['category_id'])) {

    global $category_id, $category_name, $description, $status, $image;

    $category_id = $_GET['category_id'];

    $sql = "SELECT * FROM category WHERE category_id= '$category_id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $category_name = $row['category_name'];
        $description = $row['description'];
        $status = $row['status'];
        $image = $row['image'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        global $category_id, $category_name, $description, $status, $image;

        $updated_category_name = empty($_REQUEST['name']) ? $category_name : $_REQUEST['name'];
        $updated_category_description = empty($_REQUEST['description']) ? $description : $_REQUEST['description'];
        $updated_category_status = empty($_REQUEST['status']) ? $status : $_REQUEST['status'];
        $updated_category_image = empty($_REQUEST['image']) ? $image : $_REQUEST['image'];

        $sql =  "UPDATE category SET category_name = '$updated_category_name' , 
            description = '$updated_category_description', status = '$updated_category_status' , 
            image = '$updated_category_image' WHERE category_id = '$category_id' ";

        if (mysqli_query($conn, $sql)) {

            echo "<script>alert('Category Updated Successfully!!');</script>";
            echo "<script>window.location.href = 'category_list.php';</script>";
            exit;
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Update Category</title>

</head>

<body>

    <div class="outer-container">
        <?php
        include 'sidebar.php';
        ?>

        <div id='add-category-form'>
            <form action='' method='post' enctype='multipart/form-data'>
                <label for='name'>Category Name:</label>
                <input type='text' name='name' id='name'><br>
                <label for='description'>Description:</label>
                <textarea name='description' id='description' rows='4'></textarea><br>
                <label for='status'>Status:</label>
                <select name='status' id='status'>
                    <option value='active'>Active</option>
                    <option value='Not Active'>Not Active</option>
                </select><br><br>
                <label for='image'>Update Image:</label>
                <input type='file' name='image' id='image'><br><br><br>
                <input type='submit' value='Update Category'>
            </form>
        </div>
    </div>


</body>

</html>