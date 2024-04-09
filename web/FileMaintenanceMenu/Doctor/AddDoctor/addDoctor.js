/*
    Add Doctor
    JavaScript for the Screen
    C00290945 Artemiy Maslov 02.2024
*/
// Event listener for the menu button
document.getElementById('menu_button').addEventListener('click', function() {
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    var page_name = document.querySelector('.page_name');
    // Toggle display of links and adjust menu button size accordingly
    if (links.style.display === 'none' || links.style.display === '') {
        links.style.display = 'block'; // Show the links
        menu_button.style.transform = 'scale(1.2)'; // Make the MENU larger
        page_name.style.display = 'none';
    } else {
        links.style.display = 'none'; // Hide the links
        menu_button.style.transform = 'scale(1.05)'; // Make the MENU smaller
        page_name.style.display = 'block';
    }
});

// Function to validate form submission
function validateForm(){
    return confirmChanges();
}

// Function to confirm changes
function confirmChanges(){
    return confirm("Are you sure you want to make these changes?");
}

// Display message div if there is a message
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("added");
    var message = messageDiv.textContent || messageDiv.innerText;
    // Check if message is present and adjust display accordingly
    if (message.trim().length > 1) {
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});

