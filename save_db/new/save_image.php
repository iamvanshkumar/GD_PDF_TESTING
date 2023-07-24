<?php
require_once '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['imageData'])) {
        // Handle image data upload
        $imageData = $_POST['imageData'];

        // Generate a unique file name for the image
        $imageFileName = uniqid() . '.jpg';

        // Path to the image folder on your server
        $imageFolder = 'img/';

        // Decode the base64 image data
        $decodedImage = base64_decode($imageData);

        // Save the image to the specified folder
        if (file_put_contents($imageFolder . $imageFileName, $decodedImage)) {
            // Image saved successfully, now save the image filename in the database
            $imageSql = "INSERT INTO filetbl (image) VALUES (?)";
            $imageStmt = mysqli_prepare($db, $imageSql);
            mysqli_stmt_bind_param($imageStmt, 's', $imageFileName);

            if (mysqli_stmt_execute($imageStmt)) {
                echo 'Image uploaded and saved successfully on the server and in the database.';
            } else {
                echo 'Error uploading the image on the server. Error: ' . mysqli_error($db);
            }

            mysqli_stmt_close($imageStmt);
        } else {
            echo 'Failed to save the image on the server.';
        }
    }
} else {
    echo 'No image data was uploaded.';
}

mysqli_close($db);
?>
