<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = remove_email_trash($_REQUEST['email']); // Removes all white-spaces and special characters

    $pass = remove_password_trash($_REQUEST['pass']); // Removes all white-spaces and backslashes


    $hashed_password = md5($pass);

    $sql = "SELECT * FROM users WHERE email='$email'  AND password = '$hashed_password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        echo "success";

        while ($row = mysqli_fetch_assoc($result)) {

            session_start();

            $user_id = $row['user_id'];
            $user_name = $row['name'];
            $user_type = $row['user_type'];

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_type'] = $user_type;

            switch ($user_type) {

                case 'seller':
                    header("Location: seller_dashboard.php");
                    break;

                case 'buyer':
                    header("Location: buyer_dashboard.php");
                    break;

                default:
                    header("Location: admin_dashboard.php");
            }
        }
    } else {
        show_error_message("please enter valid username and password" . mysqli_error($conn));
    }
}


function show_error_message($message)
{
    echo '<div class="error-message">';

    echo '<p>' . $message . '</p>';

    echo '</div>';
}

function remove_email_trash($data)
{
    $data = stripslashes($data);
    $data = trim($data);
    $data = htmlspecialchars($data);

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
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/login_page.css">
</head>

<body>
    <div class="container">

        <h2>Login</h2>

        <form action="" method="post">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" id="pass" name="pass" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="signup-link">
                <p>Don't have an account? <a href="user_registration.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>

</html>