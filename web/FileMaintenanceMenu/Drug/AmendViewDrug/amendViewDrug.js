
// Author			: Nebojsa Kukic
// Date				: 23/02/2024
// Purpose			: Add a Drug to the Customer Table.
//					: This is the html and php	



/* Function for the MENU button behaviour */
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

/* Function to change the style of the Stock Item Description, because it requires logic, and cannot be done strictly with CSS only */
document.getElementById("drugDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

/* Function to populate form field with data-details */
function populate() {
    var sel = document.getElementById("drugDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no drug is selected
        document.getElementById("drugID").value = "";
        document.getElementById("supplierID").value = "";
        document.getElementById("brandName").value = "";
        document.getElementById("genericName").value = "";
        document.getElementById("drugForm").value = "";
        document.getElementById("drugStrength").value = "";
        document.getElementById("usageInstructions").value = "";
        document.getElementById("sideEffects").value = "";
		document.getElementById("costPrice").value = "";
        document.getElementById("retailPrice").value = "";
        document.getElementById("quantityInStock").value = "";
        document.getElementById("reorderLevel").value = "";
        document.getElementById("reorderQuantity").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var drugDetails = details.split(',');

		document.getElementById("drugID").value = drugDetails[0];
        document.getElementById("supplierID").value = drugDetails[1];
        document.getElementById("brandName").value = drugDetails[2];
        document.getElementById("genericName").value = drugDetails[3];
        document.getElementById("drugForm").value = drugDetails[4];
        document.getElementById("drugStrength").value = drugDetails[5];
        document.getElementById("usageInstructions").value = drugDetails[6];
        document.getElementById("sideEffects").value = drugDetails[7];
		document.getElementById("costPrice").value = drugDetails[8];
        document.getElementById("retailPrice").value = drugDetails[9];
        document.getElementById("quantityInStock").value = drugDetails[10];
        document.getElementById("reorderLevel").value = drugDetails[11];
        document.getElementById("reorderQuantity").value = drugDetails[12];
    }
}

/* Function to toggle the disable property of all form fields with amend/view button states */
function toggleLock() {
    
    if(document.getElementById("amendViewButton").value === "AMEND") {
        document.getElementById("supplierID").disabled = false;
        document.getElementById("brandName").disabled = false;
        document.getElementById("genericName").disabled = false;
        document.getElementById("drugForm").disabled = false;
        document.getElementById("drugStrength").disabled = false;
        document.getElementById("usageInstructions").disabled = false;
        document.getElementById("sideEffects").disabled = false;
		document.getElementById("costPrice").disabled = false;
        document.getElementById("retailPrice").disabled = false;
        document.getElementById("quantityInStock").disabled = false;
        document.getElementById("reorderLevel").disabled = false;
        document.getElementById("reorderQuantity").disabled = false;
		document.getElementById("amendViewButton").value = "VIEW";
        document.getElementById("amendViewButton").style.backgroundColor = "rgb(0, 146, 69)";
        document.getElementById("supplierDiv1").style.display = 'block';
        document.getElementById("supplierDiv2").style.display = 'none';

    } else {
        populate();
		document.getElementById("supplierID").disabled = true;
        document.getElementById("brandName").disabled = true;
        document.getElementById("genericName").disabled = true;
        document.getElementById("drugForm").disabled = true;
        document.getElementById("drugStrength").disabled = true;
        document.getElementById("usageInstructions").disabled = true;
        document.getElementById("sideEffects").disabled = true;
		document.getElementById("costPrice").disabled = true;
        document.getElementById("retailPrice").disabled = true;
        document.getElementById("quantityInStock").disabled = true;
        document.getElementById("reorderLevel").disabled = true;
        document.getElementById("reorderQuantity").disabled = true;
		document.getElementById("amendViewButton").value = "AMEND";
        document.getElementById("amendViewButton").style.backgroundColor = "#727272";
        document.getElementById("supplierDiv1").style.display = 'block';
        document.getElementById("supplierDiv2").style.display = 'none';
    }
}

/* Function to swap between first and second supplier form fields */
function changeSelect() {
    document.getElementById("supplierDiv1").style.display = 'none';
    document.getElementById("supplierDiv2").style.display = 'block';
}

// When displaying the added message, scroll the user to its location on the page
// When the page is loaded:...
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("amended");
    //var body = document.getElementsByTagName("body");
    var message = messageDiv.textContent || messageDiv.innerText;
    if (message.trim().length > 1) {
        //body.style.height = "1400px";
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        //body.style.height = "1000px";
        messageDiv.style.display = "none"; // Hide div if no message
    }
});

/* Function for confirming the changes */
function confirmChanges(){
    // May be: "Please confirm that the details are correct"
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

/* Function for validating the form */
function validateForm(){
    if(document.getElementById("amendViewButton").value === "AMEND"){
        return false;
    }
    return confirmChanges();
}