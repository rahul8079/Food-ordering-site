<?php

include 'connection.php';

include 'validate_session.php';

session_start();

if (isset($_POST['update'])) {

    $_SESSION['total_cpp'] = $_POST['itemsPerPage'];
    $_GET['page'] = 1;
}

if (!isset($_SESSION['total_cpp'])) {
    $_SESSION['total_cpp'] = 10;
}


if (!isset($_GET['page']) || isset($_POST['search'])) {
    $page = 1;
    if (isset($_POST['search'])) {
        $_SESSION['search'] = true;
        $valueToSearch = $_POST['valueToSearch'];
        echo "<script>window.location.href = 'category_list.php?page=" . $page . "&Category_name=" . $valueToSearch . "';</script>";

    }
} else {
    $page = $_GET['page'];
    $valueToSearch = $_GET['Category_name'];
}

$totalContentPerPage = $_SESSION['total_cpp'];

$sql = "SELECT * FROM category";

$result = mysqli_query($conn, $sql);

$totalContent = mysqli_num_rows($result);

$totalPages = ceil($totalContent / $totalContentPerPage);

$start_from = ($page - 1) * $totalContentPerPage;

$order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : 'category_id ASC';

if (isset($_POST['search']) || $_SESSION['search']) {

    $totalContentPerPage = $_SESSION['total_cpp'];
    $query = "SELECT COUNT(category_id) AS total FROM category WHERE category_name LIKE '%$valueToSearch%'";
    $sql = "SELECT * FROM category WHERE category_name LIKE '%$valueToSearch%' ORDER BY $order_by LIMIT $start_from , $totalContentPerPage";
    $search_result = mysqli_query($conn, $sql);
    $totalSearch = mysqli_query($conn, $query);
    $totalSearch = mysqli_fetch_assoc($totalSearch);
    $total_content = $totalSearch['total'];
    $totalPages = ceil($total_content / $totalContentPerPage);
}

$result = mysqli_query($conn, $sql);

$category_table  = "<table>
                    <tr>
                    <th>Category id <p  id='category_id' style='color:white;'>&#9660;</p></th>
                    <th>Category name <p  id='category_name' style='color:white;'>&#9660;</p></th>
                    <th>Description <p  id='description' style='color:white;'>&#9660;</p></th>
                    <th>Status <p id='status' style='color:white;'>&#9660;</p></th>
                    <th>Image</th>
                    <th colspan=2>Action</th>
                    </tr>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $description = $row['description'];
        $description = strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
        $image_path = $row['image'];
        $category_id = $row['category_id'];

        $category_table .= "<tr>";
        $category_table .= "<td>" . $row['category_id'] . "</td>";
        $category_table .= "<td>" . ucfirst($row['category_name']) . "</td>";
        $category_table .= "<td>" . ucfirst($description) . "</td>";
        $category_table .= "<td>" . ucfirst($row['status']) . "</td>";
        $category_table .= "<td>" . "<img src='$image_path' width='100px' height='50px'>"  . "</td>";
        $category_table .= "<td><a href='update_category.php?category_id=$category_id' id='edit'>Update</a></td>";
        $category_table .= "<td><a href='#' onclick='deleteCategory($category_id)' id='delete'>Delete</a></td>";
        $category_table .= "</tr>";
    }

    $category_table .= "</table>";
} else {
    $category_table .= "<tr><td colspan='7'>No categories found.</td></tr>";
    $category_table .= "</table>";
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>All Categories</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/seller_dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/admin_dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/pagination.css">

    <script>
        function deleteCategory(categoryId) {

            if (confirm("Are you sure you want to delete this category?")) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'delete.php?delete_category=' + categoryId, true);
                xhr.send();
                xhr.onload = function() {
                    var result = xhr.responseText;
                    result = JSON.parse(result);
                    if (result == 'true') {
                        window.location.reload();
                    } else {
                        alert("Something went wrong");
                    }
                }
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            $("#category_id, #category_name, #description, #status").click(function(e) {
                e.preventDefault();
                var categoryRef = $(this).attr("id");
                console.log(categoryRef);
                $.ajax({
                    url: "sort_category.php",
                    type: "GET",
                    data: {
                        category_ref: categoryRef
                    },
                    success: function(data) {
                        window.location.reload()
                    }

                });
            });
        });
    </script>

</head>

<body>

    <body>

        <div class="outer-container">
            <?php
            include 'sidebar.php';
            ?>

            <div class="content-container">
                <div class="input-group mb-3">

                    <form action="" method="post">

                        <i class="fa fa-search"></i>
                        <input type="text" name="valueToSearch" placeholder="Category name" value="<?= $valueToSearch ?>" aria-label="Category name" aria-describedby="button-addon2">
                        <button type="submit" id="search" name='search' value='search'>search</button>

                    </form>
                </div>
                <div class="content" id="content">
                    <?php
                    echo $category_table;

                    ?>
                    <div>
                        <div class="pagination">
                            <a href="#" class="pagination-link">&laquo;</a>

                            <?php

                            for ($page = 1; $page <= $totalPages; $page++) {
                                if (!$_SESSION['search']) {
                                    echo '<a href = "category_list.php?page=' . $page . '" class="pagination-link">' . $page . ' </a>';
                                } else {
                                    echo '<a href = "category_list.php?page=' . $page . '&Category_name=' . $valueToSearch . '" class="pagination-link">' . $page . ' </a>';
                                }
                            }

                            ?>

                            <a href="#" class="pagination-link">&raquo;</a>
                        </div>
                        <form action="" method="post" class="items-per-page-form">
                            <label for="itemsPerPage">Items per Page:</label>
                            <input type="number" name="itemsPerPage" value="<?= $totalContentPerPage ?>" min="1">
                            <input type="submit" value="Update" name="update">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>