/*
    NAME:           ABDULLAH JOBBEH
    DESCRIPTION:    JavaScript file for handling the UI interactions and form operations in an
                    amend customer form within a database management context.
    DATE:           1/4/2024
    STUDENTID:      C00284285
*/

// Toggle display of navigation links upon clicking the menu button.
document.getElementById('menu_button').addEventListener('click', function() {
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    var page_name = document.querySelector('.page_name');

    if (links.style.display === 'none' || links.style.display === '') {
        links.style.display = 'block'; // Show the navigation links
        menu_button.style.transform = 'scale(1.2)'; // Enlarge the menu button
        page_name.style.display = 'none'; // Hide the page name
    } else {
        links.style.display = 'none'; // Hide the navigation links
        menu_button.style.transform = 'scale(1.05)'; // Restore menu button size
        page_name.style.display = 'block'; // Show the page name
    }
});

// Adjust background color of the customer identity dropdown based on selection.
document.getElementById("customerIdentity").addEventListener("change", function () {
    this.style.backgroundColor = this.value !== "" ? "#727272" : "rgb(0, 146, 69)";
});

// Populate form fields based on the selected customer's information.
function populate() {
    var select = document.getElementById("customerIdentity");
    var details = select.options[select.selectedIndex].getAttribute("data-details");

    if (select.value === "") {
        clearFormFields(); // Clear all fields if no customer is selected
    } else {
        var customerDetails = details.split(',');
        fillFormFields(customerDetails); // Fill form with customer details
    }
}

// Clears all input fields within the form.
function clearFormFields() {
    document.getElementById("customerID").value = "";
    document.getElementById("surname").value = "";
    document.getElementById("firstname").value = "";
    document.getElementById("Address").value = "";
    document.getElementById("eircode").value = "";
    document.getElementById("dob").value = "";
    document.getElementById("TelephoneNumber").value = "";
}

// Fill form fields with data provided.
function fillFormFields(details) {
    document.getElementById("customerID").value = details[0];
    document.getElementById("surname").value = details[1];
    document.getElementById("firstname").value = details[2];
    document.getElementById("Address").value = details[3];
    document.getElementById("eircode").value = details[4];
    document.getElementById("dob").value = details[5];
    document.getElementById("TelephoneNumber").value = details[6];
}

// Toggle the disabled state of form fields for editing or viewing.
function toggleLock() {
    var editMode = document.getElementById("amendViewButton").value === "AMEND";
    ["surname", "firstname", "Address", "eircode", "dob", "TelephoneNumber"].forEach(function(id) {
        document.getElementById(id).disabled = editMode;
    });
    document.getElementById("amendViewButton").value = editMode ? "VIEW" : "AMEND";
    document.getElementById("amendViewButton").style.backgroundColor = editMode ? "#727272" : "rgb(0, 146, 69)";
}

// Show or hide the message div on page load based on content.
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("amended");
    var message = messageDiv.textContent.trim();
    messageDiv.style.display = message.length > 0 ? "block" : "none";
    if (message.length > 0) {
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});

// Confirm changes before form submission.
function confirmChanges() {
    return confirm("Are you sure you want to make these changes?");
}

// Prevent form submission if in "AMEND" mode, otherwise confirm changes.
function validateForm() {
    return document.getElementById("amendViewButton").value !== "AMEND" && confirmChanges();
}
