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
    </style>
    <script src="./script.js"></script>
</head>

<body>
    <!-- Input for file upload -->
    <input name="notePDF" type="file" id="pdf-file" accept=".pdf" />
    <!-- Button to trigger manual PDF upload -->
    <button onclick="uploadPDF()">Upload PDF</button>
    <div id="pdf-img" class="pdf-container"></div>
</body>

</html>