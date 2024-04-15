
// Author			: Nebojsa Kukic
// Date				: 23/02/2024
// Purpose			: Delete a Drug
//					: This is the js	


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
document.getElementById("drugDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

// Function to populate form fields based on selected option
function populate() {
    var sel = document.getElementById("drugDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no stock item is selected
        document.getElementById("brandName").value = "";
        document.getElementById("genericName").value = "";
        document.getElementById("drugForm").value = "";
        document.getElementById("drugStrength").value = "";
        document.getElementById("supplierID").value = "";
        
    } else {
        // Split the details using the delimiter (comma)
        var drugDetails = details.split(',');
        document.getElementById("brandName").value = drugDetails[0];
        document.getElementById("genericName").value = drugDetails[1];
        document.getElementById("drugForm").value = drugDetails[2];
        document.getElementById("drugStrength").value = drugDetails[3];
        document.getElementById("supplierID").value = drugDetails[4];
        
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
    var sel = document.getElementById("drugDescription");
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");
    var drugDetails = details.split(',');
    if(drugDetails[2] > 0 && drugDetails[5] > 0) {
        alert("You can not delete this item");
        return false;
    }
    return confirmChanges();
}
