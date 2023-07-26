<?php
require_once('../conn.php');

session_start();
// legal input values
$email = mysqli_real_escape_string($db, legal_input($_POST['email']));
$password = mysqli_real_escape_string($db, legal_input($_POST['password']));

if (!empty($email) && !empty($password)) {
    //  Sql Query to retrieve user data from database table
    retrieveData($email, $password);
} else {
    echo "All fields are required";
}

// convert illegal input value to legal value format
function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

// function to retrieve user data from database table
function retrieveData($email, $password)
{
    global $db;


    $sql = "SELECT * FROM usertbl WHERE email = '$email'";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['passcode'];
        // Assuming you are using password_hash for password hashing
        if ($password == $hashedPassword) {
            $_SESSION['userSession'] = $email;
            echo "<script>window.location.href='./home.php';</script>";
            exit;
        } else {
            echo 'Incorrect Password';
        }
    } else {
        echo 'User does not exist';
    }
}
?>