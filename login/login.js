document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        console.log('Form submitted');

        var formData = new FormData(this);

        fetch('db.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.headers.get('Content-Type').includes('application/json')) {
                return response.json();
            } else {
                // Not a JSON response
                throw new Error('Received non-JSON response from the server');
            }
        })
        .then(data => {
            if (data.success) {
                window.location.href = data.redirectUrl; // Redirect using the URL from the server
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred. Please check the console for more information.');
        });
    });
});
