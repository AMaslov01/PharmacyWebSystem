/*
    Amend/View Doctor
    JavaScript for the Screen
    C00290945 Artemiy Maslov 02.2024
*/
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

// Add event listener to the select element for doctor description
document.getElementById("doctorDescription").addEventListener("change", function () {
    var select = this;
    // Change background color based on selection
    if (select.value !== "") {
        select.style.backgroundColor = "#727272"; // Set background color to gray
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)"; // Set background color to green
    }
});

// Function to populate form fields based on selected doctor
function populate() {
    var sel = document.getElementById("doctorDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no doctor is selected
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
        // Populate fields with doctor details
        var doctorDetails = details.split(',');
        document.getElementById("doctorID").value = doctorDetails[0];
        document.getElementById("surname").value = doctorDetails[1];
        document.getElementById("firstName").value = doctorDetails[2];
        document.getElementById("surgeryAddress").value = doctorDetails[3];
        document.getElementById("surgeryEircode").value = doctorDetails[4];
        document.getElementById("surgeryTelephoneNumber").value = doctorDetails[5];
        document.getElementById("mobileTelephoneNumber").value =doctorDetails[6];
        document.getElementById("homeAddress").value = doctorDetails[7];
        document.getElementById("homeEircode").value = doctorDetails[8];
        document.getElementById("homeTelephoneNumber").value = doctorDetails[9];
    }
}

// Function to toggle form field locks
function toggleLock() {
    if(document.getElementById("amendViewButton").value === "AMEND") {
        // Enable fields for editing
        document.getElementById("surname").disabled = false;
        document.getElementById("firstName").disabled = false;
        document.getElementById("surgeryAddress").disabled = false;
        document.getElementById("surgeryEircode").disabled = false;
        document.getElementById("surgeryTelephoneNumber").disabled = false;
        document.getElementById("mobileTelephoneNumber").disabled = false;
        document.getElementById("homeAddress").disabled = false;
        document.getElementById("homeEircode").disabled = false;
        document.getElementById("homeTelephoneNumber").disabled = false;
        document.getElementById("amendViewButton").value = "VIEW"; // Change button text
        document.getElementById("amendViewButton").style.backgroundColor = "rgb(0, 146, 69)"; // Change button background color
    } else {
        // Disable fields for viewing
        document.getElementById("surname").disabled = true;
        document.getElementById("firstName").disabled = true;
        document.getElementById("surgeryAddress").disabled = true;
        document.getElementById("surgeryEircode").disabled = true;
        document.getElementById("surgeryTelephoneNumber").disabled = true;
        document.getElementById("mobileTelephoneNumber").disabled = true;
        document.getElementById("homeAddress").disabled = true;
        document.getElementById("homeEircode").disabled = true;
        document.getElementById("homeTelephoneNumber").disabled = true;
        document.getElementById("amendViewButton").value = "AMEND"; // Change button text
        document.getElementById("amendViewButton").style.backgroundColor = "#727272"; // Change button background color
    }
}

// Event listener to show/hide message div on page load
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("amended");
    var message = messageDiv.textContent || messageDiv.innerText;
    if (message.trim().length > 1) {
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});

// Function to confirm changes before submission
function confirmChanges(){
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

// Function to validate form submission
function validateForm(){
    if(document.getElementById("amendViewButton").value === "AMEND"){
        return false; // Prevent form submission if in amend mode
    }
    return confirmChanges(); // Otherwise, confirm changes before submission
}