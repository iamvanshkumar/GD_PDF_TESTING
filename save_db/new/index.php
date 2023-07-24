<!DOCTYPE html>
<html>

<head>
    <title>PDF Upload Example</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>

</head>

<body>

    <form id="pdfUploadForm" enctype="multipart/form-data">
        <input type="file" name="pdfFile" id="pdfFile">
        <button type="button" onclick="uploadAndDisplayPDF()">Upload and Display PDF</button>
    </form>
    <div id="pdf-img"></div>
    <div id="status"></div>
    <!-- <button type="button" onclick="saveImageToServer()">Save Image</button> -->

    <script src="./script.js"></script>
</body>

</html>