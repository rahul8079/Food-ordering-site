<?php
session_start();
$name = $_SESSION['user_name'];
echo "<h1> hello $name , you are logged in</h1>";

?>