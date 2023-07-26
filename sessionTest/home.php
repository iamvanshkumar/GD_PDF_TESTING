<?php
session_start();

// Check if the user is logged in (session is set)
if (isset($_SESSION['userSession'])) {
    $loggedIn = true;
    $username = $_SESSION['userSession'];
} else {
    $loggedIn = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <?php if ($loggedIn): ?>
        <!-- User is logged in, show username and logout button -->
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <a href="./logout.php">LOGOUT</a>
    <?php else: ?>
        <!-- User is not logged in, show login button -->
        <a href="./login.php">LOGIN</a>
    <?php endif; ?>
</body>
</html>
