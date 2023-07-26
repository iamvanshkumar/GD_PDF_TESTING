<!DOCTYPE html>
<html>
<head>
    <title>PDF File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <style>
        .container {
            width: 500px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            font-size: 24px;
        }

        .message {
            margin-bottom: 20px;
            text-align: center;
        }

        .pdf-container {
            width: 100%;
            height: 500px;
        }

        .pdf-page {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: 100%;
        }
    </style>
    <script>
        function displayPDF(url) {
            const loadingTask = pdfjsLib.getDocument(url);
            loadingTask.promise.then(function(pdf) {
                const viewerContainer = document.getElementById('pdfViewer');
                while (viewerContainer.firstChild) {
                    viewerContainer.removeChild(viewerContainer.firstChild);
                }

                for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                    pdf.getPage(pageNum).then(function(page) {
                        const scale = 1.5;
                        const viewport = page.getViewport({ scale: scale });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(function() {
                            const imageDataURI = canvas.toDataURL(); // Convert canvas to image data URI
                            const div = document.createElement('div');
                            div.classList.add('pdf-page');
                            div.style.backgroundImage = `url(${imageDataURI})`;
                            viewerContainer.appendChild(div);
                        });
                    });
                }
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
            $uploadOk = 1;
            $message = "";

            // Check if file is a PDF
            $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if ($pdfFileType != "pdf") {
                $message = "Only PDF files are allowed.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                $message = "File already exists.";
                $uploadOk = 0;
            }

            // Check file size (Max: 5MB)
            if ($_FILES["pdfFile"]["size"] > 5 * 1024 * 1024) {
                $message = "File size exceeds the limit of 5MB.";
                $uploadOk = 0;
            }

            // Upload file if all checks pass
            if ($uploadOk) {
                if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
                    $message = "File uploaded successfully.";
                } else {
                    $message = "Error uploading file.";
                }
            }
        }
        ?>
        <h1>PDF File Upload</h1>
        <div class="message">
            <?php if (isset($message)): ?>
                <div class="bg-green-200 text-green-800 p-3 mb-5"><?php echo $message; ?></div>
            <?php endif; ?>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="file" name="pdfFile" accept="application/pdf" required>
            </div>
            <div>
                <input type="submit" value="Upload" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
            </div>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdfFile"])) {
            $pdfFile = $_FILES["pdfFile"]["name"];
            echo "<h2 class='text-2xl text-center mt-10 mb-5'>PDF Viewer:</h2>";
            echo "<div id='pdfViewer' class='pdf-container'></div>";
            echo "<script>displayPDF('uploads/$pdfFile');</script>";
        }
        ?>
    </div>
</body>
</html>
