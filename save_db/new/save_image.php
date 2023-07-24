<?php
if (isset($_POST['imageData'])) {
  // Get the base64 image data from the POST request
  $imageData = $_POST['imageData'];

  // Generate a unique file name for the image
  $fileName = uniqid() . '.jpg';

  // Path to the image folder on your server
  $imageFolder = 'img/';

  // Decode the base64 image data
  $decodedImage = base64_decode($imageData);

  // Save the image to the specified folder
  if (file_put_contents($imageFolder . $fileName, $decodedImage)) {
    // Image saved successfully
    http_response_code(200);
  } else {
    // Failed to save image
    http_response_code(500);
  }
} else {
  // No image data provided
  http_response_code(400);
}
?>
