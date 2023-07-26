<?php
// Include the "conn.php" file that contains the database connection code
include('../conn.php');

// Start the PHP session to access session data
session_start();

// Get the username stored in the session variable
$usernameCheck = $_SESSION['userSession'];

// Check if the user is not logged in (userSession is not set)
if (!isset($_SESSION['userSession'])) {
    // Redirect the user to the login page
    header("location:./login.php");
    // Terminate further execution of the script
    die();
}

// Execute an SQL query to select the username from the database where the provided username matches
$ses_sql = mysqli_query($db, "SELECT userName FROM usertbl WHERE userName = '$usernameCheck'");

// Fetch the result of the query as an associative array
$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

// Retrieve the 'userName' value from the fetched array and store it in the $login_session variable
$login_session = $row['userName'];
?>
