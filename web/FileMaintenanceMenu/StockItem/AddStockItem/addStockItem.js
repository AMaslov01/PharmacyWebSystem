/*
    Add Stock Item
    JS for the addStockItem.php page
    C00290930 Evgenii Salnikov 04.2024
*/

/* Function for the MENU button behaviour */
document.getElementById('menu_button').addEventListener('click', function() { // If button is clicked
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    var page_name = document.querySelector('.page_name');
    if (links.style.display === 'none' || links.style.display === '') {
        links.style.display = 'block'; // Show the links
        menu_button.style.transform = 'scale(1.2)'; // Make the MENU larger
        page_name.style.display = 'none'; // Hide the page name
    } else {
        links.style.display = 'none'; // Hide the links
        menu_button.style.transform = 'scale(1.05)'; // Make the MENU smaller
        page_name.style.display = 'block'; // Show the page name
    }
});

/* Function for validating the form */
function validateForm(){
    return confirmChanges();
}

/* Function for confirming the changes */
function confirmChanges(){
    return confirm("Are you sure you want to make these changes?");
}

/* Function to change the style of the Supplier Name, because it requires logic, and cannot be done strictly with CSS only */
document.getElementById("supplierName").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

/* Function to when displaying the added message, scroll the user to its location on the page */
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("added");
    var message = messageDiv.textContent || messageDiv.innerText; // Set the message
    if (message.trim().length > 1) { // Simply, if message exists
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});