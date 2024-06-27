document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('modalOverlay');

    // Assuming "Roles & Permissions" triggers the modal
    document.querySelector('.menu-item a[href="manageUser.html"]').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        fetch('manageUser.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                modalOverlay.style.display = 'flex'; // Show the modal

                // Attach event listener to close button after content is loaded
                document.getElementById('closeButton').addEventListener('click', function () {
                    modalOverlay.style.display = 'none'; // Hide the modal
                });
            })
            .catch(error => console.error('Failed to load form:', error));
    });
});
