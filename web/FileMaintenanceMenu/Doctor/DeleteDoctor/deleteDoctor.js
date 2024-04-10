/*
    Delete Doctor
    JavaScript for the Screen
    C00290945 Artemiy Maslov 02.2024
*/
// Function to toggle display of navigation links and adjust MENU button size
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

// Function to change background color of select element based on value
document.getElementById("doctorDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

// Function to populate form fields based on selected option
function populate() {
    var sel = document.getElementById("doctorDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no stock item is selected
        document.getElementById("doctorID").value = "";
        document.getElementById("surname").value = "";
        document.getElementById("firstName").value = "";
        document.getElementById("surgeryAddress").value = "";
        document.getElementById("surgeryEircode").value = "";
        document.getElementById("surgeryTelephoneNumber").value = "";
        document.getElementById("mobileTelephoneNumber").value = "";
        document.getElementById("homeAddress").value = "";
        document.getElementById("homeEircode").value = "";
        document.getElementById("homeTelephoneNumber").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var doctorDetails = details.split(',');
        document.getElementById("doctorID").value = doctorDetails[0];
        document.getElementById("surname").value = doctorDetails[1];
        document.getElementById("firstName").value = doctorDetails[2];
        document.getElementById("surgeryAddress").value = doctorDetails[3];
        document.getElementById("surgeryEircode").value = doctorDetails[4];
        document.getElementById("surgeryTelephoneNumber").value = doctorDetails[5];
        document.getElementById("mobileTelephoneNumber").value = doctorDetails[6];
        document.getElementById("homeAddress").value = doctorDetails[7];
        document.getElementById("homeEircode").value = doctorDetails[8];
        document.getElementById("homeTelephoneNumber").value = doctorDetails[9];
    }
}

// Function to handle content loading event
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("deleted");
    var message = messageDiv.textContent || messageDiv.innerText;
    if (message.trim().length > 1) {
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});

// Function to confirm changes before deletion
function confirmChanges(){
    return confirm("Are you sure you want to delete this item?"); // Display confirmation dialog and return user's choice
}

// Function to validate form before deletion
function validateForm(){
    var sel = document.getElementById("doctorDescription");
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");
    var doctorDetails = details.split(',');
    if(doctorDetails[2] > 0 && doctorDetails[5] > 0) {
        alert("You can not delete this item");
        return false;
    }
    return confirmChanges();
}
