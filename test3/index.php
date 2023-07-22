<!DOCTYPE html>
<html>

<head>
    <title>PDF File Display</title>
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
    <script>
        function displayPDFAsImage(url) {
            const loadingTask = pdfjsLib.getDocument(url);
            loadingTask.promise.then(function (pdf) {
                pdf.getPage(1).then(function (page) { // Render only the first page (page number 1)
                    const scale = 1; // Set the scale to 1 to fit the entire page
                    const viewport = page.getViewport({ scale });

                    // Create an image element
                    const img = document.createElement('img');
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Convert the PDF page to an image and set it as the img source
                    page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
                        img.src = canvas.toDataURL(); // Convert canvas to data URL and set as img src
                        img.className = 'h-36 w-full overflow-hidden';
                        // Append the image to the pdfContainer div
                        const pdfContainer = document.getElementById('pdf-img');
                        pdfContainer.appendChild(img);
                    }).catch(function (error) {
                        console.error('Error rendering PDF as image:', error);
                    });
                }).catch(function (error) {
                    console.error('Error loading PDF:', error);
                });
            }).catch(function (error) {
                console.error('Error loading PDF:', error);
            });
        }


        function saveImageToServer() {
            const pdfContainer = document.getElementById('pdf-img');
            const img = pdfContainer.querySelector('img');

            // Get the base64 data URL of the image
            const imageData = img.src.split(',')[1];

            // Send the image data to the server using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_image.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('Image saved successfully.');
                    } else {
                        alert('Failed to save image.');
                    }
                }
            };
            xhr.send('imageData=' + encodeURIComponent(imageData));
        }

    </script>




</head>

<body>
    <div class="container">
        <h1>PDF File Display</h1>
        <div
            class="grid grid-cols-3 gap-2 rounded-md shadow-md hover:shadow-lg bg-white dark:bg-gray-800 p-2 h-38 duration-300">
            <div class="border-r pr-2 flex justify-center items-center">
                <div id="pdf-img" class="pdf-container"></div>
            </div>
            <div class="col-span-2 flex-col flex justify-between">
                <a onclick="openNote(7,'Software Engg. Handwritten Notes pdf download free')">
                    <h6 class="text-gray-600 amber-hover-text font-bold text-md">
                        Software Engg. Handwritten Notes pdf download free </h6>
                </a>
                <div class="block">
                    <span class=" amber uppercase text-white px-1 text-xs">
                        Data Structures </span>
                </div>
                <div class="flex justify-between uppercase font-medium items-center text-sm ">
                    <span class="text-gray-500">
                        BSC IT </span>
                    <span id="paid" class="my-1 px-2 text-white ">
                        paid </span>
                </div>
                <div class="flex justify-between items-center text-gray-400 uppercase text-sm ">
                    <span class="">
                        <i class="bx bx-calendar"></i>
                        2023-07-17 </span>
                    <span class="">
                        <i class="bx bx-bar-chart"></i>
                        10000 </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Call the function to display the PDF as an image inside the provided container
        const pdfFile = './test.pdf'; // Update with your PDF file path
        displayPDFAsImage(pdfFile);
    </script>

<button onclick="saveImageToServer()">Save Image</button>
</body>

</html>