<?php
require_once '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdfFile'])) {
        // Handle PDF file upload
        $targetDirectory = 'uploads/';

        // Check if the "uploads" directory exists, if not, create it
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $targetFile = $targetDirectory . basename($_FILES['pdfFile']['name']);

        // Check if the file is a PDF
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($fileType !== 'pdf') {
            echo 'Invalid file format. Please upload a PDF file.';
            exit;
        }

        // Move the PDF file to the server's target directory
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $targetFile)) {
            // File uploaded successfully, now save the PDF filename in the database
            $pdfFilename = $_FILES['pdfFile']['name'];

            // Use a prepared statement to insert the PDF filename into the database
            $pdfSql = "INSERT INTO filetbl (pdf) VALUES (?)";
            $pdfStmt = mysqli_prepare($db, $pdfSql);
            mysqli_stmt_bind_param($pdfStmt, 's', $pdfFilename);

            if (mysqli_stmt_execute($pdfStmt)) {
                echo 'PDF file uploaded and saved successfully on the server and in the database.';
            } else {
                echo 'Error uploading the PDF file on the server. Error: ' . mysqli_error($db);
            }

            mysqli_stmt_close($pdfStmt);
        } else {
            echo 'Error uploading the PDF file on the server.';
        }
    }

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
    echo 'No file or image data was uploaded.';
}

mysqli_close($db);
?>