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

document.getElementById("doctorDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

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
        var doctorDetails = details.split(',');
        console.log(doctorDetails);
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

function toggleLock() {
    if(document.getElementById("amendViewButton").value === "AMEND") {
        document.getElementById("surname").disabled = false;
        document.getElementById("firstName").disabled = false;
        document.getElementById("surgeryAddress").disabled = false;
        document.getElementById("surgeryEircode").disabled = false;
        document.getElementById("surgeryTelephoneNumber").disabled = false;
        document.getElementById("mobileTelephoneNumber").disabled = false;
        document.getElementById("homeAddress").disabled = false;
        document.getElementById("homeEircode").disabled = false;
        document.getElementById("homeTelephoneNumber").disabled = false;
        document.getElementById("amendViewButton").value = "VIEW";
        document.getElementById("amendViewButton").style.backgroundColor = "rgb(0, 146, 69)";
    } else {
        document.getElementById("surname").disabled = true;
        document.getElementById("firstName").disabled = true;
        document.getElementById("surgeryAddress").disabled = true;
        document.getElementById("surgeryEircode").disabled = true;
        document.getElementById("surgeryTelephoneNumber").disabled = true;
        document.getElementById("mobileTelephoneNumber").disabled = true;
        document.getElementById("homeAddress").disabled = true;
        document.getElementById("homeEircode").disabled = true;
        document.getElementById("homeTelephoneNumber").disabled = true;
        document.getElementById("amendViewButton").value = "AMEND";
        document.getElementById("amendViewButton").style.backgroundColor = "#727272";
    }
}

function confirmChanges(){
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    if(document.getElementById("amendViewButton").value === "AMEND"){
        return false;
    }
    return confirmChanges();

}
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