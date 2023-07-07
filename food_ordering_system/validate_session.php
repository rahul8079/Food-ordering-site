<?php

session_start();

if(empty($_SESSION['user_id'])){

    header('Location: user_login.php');
    die;
}

?>