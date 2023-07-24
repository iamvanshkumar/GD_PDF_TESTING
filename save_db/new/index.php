<!DOCTYPE html>
<html>

<head>
    <title>PDF Upload Example</title>
</head>

<body>

    <form id="pdfUploadForm" enctype="multipart/form-data">
        <input type="file" name="pdfFile" id="pdfFile">
        <button type="button" onclick="uploadAndDisplayPDF()">Upload and Display PDF</button>
    </form>
    <div id="pdf-img"></div>
    <button type="button" onclick="saveImageToServer()">Save Image to Server</button>
    <div id="status"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>
    <script src="./script.js"></script>
</body>

</html>