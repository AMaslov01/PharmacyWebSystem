document.getElementById('menu_button').addEventListener('click', function() {
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    var page_name = document.querySelector('.page_name');
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

function validateForm(){
    return confirmChanges();
}

function confirmChanges(){
    return confirm("Are you sure you want to make these changes?");
}


document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("added");
    var message = messageDiv.textContent || messageDiv.innerText;
    if (message.trim().length > 1) {
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});
