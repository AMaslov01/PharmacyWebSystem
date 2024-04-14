/*
    NAME:           ABDULLAH JOBBEH
    DESCRIPTION:    JAVA SCRIPT FILE FOR DELETING CUSTOMER FROM A DATABASE
    DATE:           1/4/2024
    STUDENTID:      C00284285
*/
/* Function for the MENU button behaviour */
/* Handles the behavior of the menu button to toggle visibility of the navigation links. */
document.getElementById('menu_button').addEventListener('click', function() {
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    var page_name = document.querySelector('.page_name');
    if (links.style.display === 'none' || links.style.display === '') {
        links.style.display = 'block'; // Show the navigation links
        menu_button.style.transform = 'scale(1.2)'; // Enlarge the MENU button
        page_name.style.display = 'none'; // Hide the page name
    } else {
        links.style.display = 'none'; // Hide the navigation links
        menu_button.style.transform = 'scale(1.05)'; // Return MENU button size to normal
        page_name.style.display = 'block'; // Show the page name
    }
});

/* Changes the background color of the select element based on the selected option */
document.getElementById("customerIdetity").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272"; // Darken background for non-empty selection
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)"; // Reset background for empty selection
    }
});

/* Populates form fields based on the selected customer from the dropdown menu */
function populate() {
    var sel = document.getElementById("customerIdetity");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no customer is selected
        document.getElementById("customerid").value = "";
        document.getElementById("firstname").value = "";
        document.getElementById("lastname").value = "";
        document.getElementById("address").value = "";
        document.getElementById("eircode").value = "";
        document.getElementById("dob").value = "";
        document.getElementById("telephonenumber").value = "";
    } else {
        // Split the details and assign them to form fields
        var customerDetails = details.split(',');
        document.getElementById("customerid").value = customerDetails[0];
        document.getElementById("firstname").value = customerDetails[1];
        document.getElementById("lastname").value = customerDetails[2];
        document.getElementById("address").value = customerDetails[3];
        document.getElementById("eircode").value = customerDetails[4];
        document.getElementById("dob").value = customerDetails[5];
        document.getElementById("telephonenumber").value = customerDetails[6];
    }
}

/* Automatically scroll to the message section if a message exists when the page is loaded */
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("deleted");
    var message = messageDiv.textContent || messageDiv.innerText;
    if (message.trim().length > 1) {
        messageDiv.style.display = "block"; // Ensure the message div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' }); // Smoothly scroll to the message div
    } else {
        messageDiv.style.display = "none"; // Hide the message div if there is no message
    }
});

/* Confirm the action with the user before deleting an item */
function confirmChanges(){
    return confirm("Are you sure you want to delete this Customer?"); // Display a confirmation dialog
}

/* Validates the form before submission to ensure all conditions for deletion are met */
function validateForm(){
    var sel = document.getElementById("customerIdetity");
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");
    var customerDetails = details.split(',');

    // Example condition: Ensure specific fields meet criteria before allowing deletion
    if(customerDetails[2] > 0 || customerDetails[5] > 0) {
        alert("You cannot delete this Customer."); // Alert the user if conditions are not met
        return false; // Prevent form submission
    }
    return confirmChanges(); // Ask for user confirmation before proceeding
}
