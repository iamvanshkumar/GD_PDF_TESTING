<?php
// convert_pdf_to_images.php

// Function to convert PDF to images
function convertPdfToImages($pdfPath)
{
    $outputPath = __DIR__ . '/converted_images/';
    if (!is_dir($outputPath)) {
        mkdir($outputPath);
    }

    // Create Imagick object
    $imagick = new Imagick();

    // Set resolution for image generation (adjust as needed)
    $imagick->setResolution(300, 300);

    // Read the PDF file
    $imagick->readImage($pdfPath);

    // Loop through all pages and save them as images
    foreach ($imagick as $page) {
        // Set the image format (png, jpeg, etc.)
        $page->setImageFormat('png');

        // Generate a unique image filename for each page
        $imageName = basename($pdfPath, '.pdf') . '_' . $page->getIteratorIndex() . '.png';
        $outputFilePath = $outputPath . $imageName;

        // Save the image to the output folder
        $page->writeImage($outputFilePath);
    }

    // Clear the Imagick object
    $imagick->clear();
    $imagick->destroy();

    // Get the list of converted images
    $imageFiles = glob($outputPath . '*.png');
    return $imageFiles;
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['pdf_path'])) {
        $pdfPath = $_GET['pdf_path'];
        $convertedImages = convertPdfToImages($pdfPath);
        echo json_encode($convertedImages);
    } else {
        echo json_encode(array('error' => 'Missing pdf_path parameter'));
    }
}
?>
