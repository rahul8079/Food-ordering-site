<?php

session_start();

$name  = $_SESSION['user_name'];

?>


<!DOCTYPE html>

<html>

<head>

    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/seller_dashboard.css">

    <style>
        /* Form container */
        #add-item-form {
            height: 500px;
            width: 500px;
            margin-top: 100px;
            margin-left: 200px;
            background-color: black;
            padding: 20px;
            display: none;
            /* Hide the form by default */
        }

        /* Form labels */
        #add-item-form label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        /* Form inputs */
        #add-item-form input[type="text"],
        #add-item-form textarea,
        #add-item-form input[type="number"],
        #add-item-form input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        /* Submit button */
        #add-item-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        #add-item-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

</head>

<body>

    <div class="side-menu">
        <a href="#" class="menu-option" onclick="myAccountInfo()">My Account</a>
        <a href="#" class="menu-option">Orders</a>
        <a href="#" class="menu-option" onclick="showItems()">Items</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content" id="content">

        <div id="add-item-form">
            <form method="post" action="">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required><br>

                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea><br>

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" required><br>

                <input type="submit" value="Add Food Product">
            </form>
        </div>

        <a href='#' class='add-item' id='add-item' style="display:none;">Add Item</a>

    </div>



    <script>
        function myAccountInfo() {


        }

        function showItems() {

            var addItemButton = document.getElementById("add-item");
            addItemButton.style.display = addItemButton.style.display === "none" ? "block" : "none";


        }

        document.getElementById("add-item").onclick = function() {
            var form = document.getElementById("add-item-form");
            var addItemButton = document.getElementById("add-item");
            form.style.display = form.style.display === "block" ? "none" : "block";
            addItemButton.style.display = addItemButton.style.display === "none" ? "block" : "none";
        }
    </script>

</body>

</html>