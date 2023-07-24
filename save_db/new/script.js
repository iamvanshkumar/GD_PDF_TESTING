function uploadAndDisplayPDF() {
    const formData = new FormData();
    formData.append('pdfFile', document.getElementById('pdfFile').files[0]);

    // AJAX call to upload the file
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('status').innerText = 'File uploaded successfully.';
                // Display the PDF as an image after successful upload
                displayPDFAsImage('uploads/' + document.getElementById('pdfFile').files[0].name, function () {
                    alert('PDF displayed as an image.');
                    saveImageToServer();
                });
            } else {
                document.getElementById('status').innerText = 'Error uploading the file.';
            }
        }
    };

    xhr.send(formData);
}

function displayPDFAsImage(url, callback) {
    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function (pdf) {
        pdf.getPage(1).then(function (page) {
            const scale = 1;
            const viewport = page.getViewport({ scale });

            const img = document.createElement('img');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
                img.src = canvas.toDataURL('image/jpeg', 0.7);
                img.className = 'h-36 w-full overflow-hidden';

                const pdfContainer = document.getElementById('pdf-img');
                pdfContainer.appendChild(img);

                // Call the callback function to indicate that the rendering is complete
                if (typeof callback === 'function') {
                    callback();
                }
            }).catch(function (error) {
                console.error('Error rendering PDF as image:', error);
            });
        }).catch(function (error) {
            console.error('Error loading PDF:', error);
        });
    }).catch(function (error) {
        console.error('Error loading PDF:', error);
    });
    if (typeof callback === 'function') {
        callback();
    }
}

function saveImageToServer() {
    const pdfContainer = document.getElementById('pdf-img');
    const img = pdfContainer.querySelector('img');

    const imageData = img.src.split(',')[1];

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
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
