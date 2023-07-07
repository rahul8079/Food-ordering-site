<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = remove_trash($_REQUEST['fullname']);
    $email = remove_trash($_REQUEST['email']);
    $pass = remove_password_trash($_REQUEST['pass']);
    $cpass = remove_password_trash($_REQUEST['cpass']);
    $phone = remove_trash($_REQUEST['phone']);
    $address = remove_trash($_REQUEST['address']);
    $user_type = $_REQUEST['user_type'];

    $arr = array(
        'name' => "/^[a-zA-Z ]+$/",
        'pass' => "/^[a-zA-Z0-9@!#]*$/",
        'cpass' => "/^[a-zA-Z0-9@!#]*$/",
        'phone' => "/^[0-9]+$/",
        'username' => "/^[a-zA-Z0-9]+$/"
    );

    $error_messages = array();   // Array for containing error messages

    foreach ($arr as $col => $pattern) {
        if (!preg_match($pattern, ${$col})) {
            $error_messages[] = "Please enter valid $col";
        }
    }

    if ($pass !== $cpass) {
        $error_messages[] = "Passwords do not match";
    }

    if (strlen($phone) > 10) {
        $error_messages[] = "please enter valid phone number!!";
    }

    $pass = md5($pass);  // password hashing 

    $cpass = md5($pass); // confirm password hashing 

    if (count($error_messages) === 0) {

        $sql = "INSERT INTO users (name, email, phone, address, user_type, password, confirm_pass) 
        VALUES('$name','$email','$phone', '$address','$user_type', '$pass','$cpass')";

        if (mysqli_query($conn, $sql)) {

            echo "success";
        } else {

            echo "failed" . mysqli_error($conn);
        }
    } else {

        echo "<h1> Warning!!!</h1>";
        print_r($error_messages);
    }
}


function remove_trash($data)
{

    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = trim($data);
    return $data;
}

function remove_password_trash($data)
{
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="css/signup_page.css">
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h2>Signup</h2>
            <label for="fullname">Name:</label>
            <input type="text" name="fullname" id="fullname">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email">

            <label for="address">Address:</label>
            <input type="text" name="address" id="address">

            <label for="phone">Phone:</label>
            <input type="tel" name="phone" id="phone">

            <label for="user_type">Usertype:</label>
            <select name="user_type" id="user_type">
                <option value="admin">admin</option>
                <option value="seller">seller</option>
                <option value="buyer" selected>buyer</option>
            </select>

            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass">

            <label for="cpass">Confirm Password:</label>
            <input type="password" name="cpass" id="cpass">

            <input type="submit" value="submit">
        </form>
    </div>
</body>

</html>