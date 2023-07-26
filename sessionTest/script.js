// document.getElementById('loginForm').addEventListener('submit', function(event) {
//     event.preventDefault();

//     const formData = new FormData(event.target);
//     const username = formData.get('username');
//     const password = formData.get('password');

//     console.log(username+'  '+password);
//     // Send the login request to the server using Ajax
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', 'script.php', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 const response = JSON.parse(xhr.responseText);
//                 if (response.success) {
//                     // Redirect the user to the dashboard or home page on successful login
//                     window.location.href = './userGM/';
//                 } else {
//                     document.getElementById('message').innerText = 'Invalid username or password.';
//                 }
//             } else {
//                 document.getElementById('message').innerText = 'An error occurred during login.';
//             }
//         }
//     };
//     xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));
// });

$(document).on('submit', '#loginForm', function (e) {
    e.preventDefault();

    $.ajax({
        method: "POST",
        url: "script.php",
        data: $(this).serialize(),
        success: function (data) {
            console.log(data); // Check the response in the browser console
            $('#message').html(data);
            $('#loginForm').find('input').val('')
        }
    });
});