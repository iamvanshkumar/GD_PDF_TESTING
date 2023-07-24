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
}

function saveImageToServer() {
    const pdfContainer = document.getElementById('pdf-img');
    const img = pdfContainer.querySelector('img');

    const imageData = img.src.split(',')[1];

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

function uploadPDF() {
    const fileInput = document.getElementById('pdf-file');
    const file = fileInput.files[0];
    if (file) {
        const fileReader = new FileReader();
        fileReader.onload = function (event) {
            const pdfData = event.target.result;
            // Call the displayPDFAsImage() with the saveImageToServer() function as a callback
            displayPDFAsImage(pdfData, saveImageToServer);
        };
        fileReader.readAsDataURL(file);
    } else {
        alert('Please select a PDF file.');
    }
}
