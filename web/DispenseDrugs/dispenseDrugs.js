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

document.getElementById("customerDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

function populate() {
    var sel = document.getElementById("customerDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no stock item is selected
        document.getElementById("customerName").value = "";
        document.getElementById("customerSurname").value = "";
        document.getElementById("address").value = "";
        document.getElementById("dateOfBirth").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var customerDetails = details.split(',');
        document.getElementById("customerName").value = customerDetails[2];
        document.getElementById("customerSurname").value = customerDetails[1];
        document.getElementById("address").value = customerDetails[3];
        document.getElementById("dateOfBirth").value = customerDetails[4];
    }
}

function confirmChanges(){
    // May be: "Please confirm that the details are correct"
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    return confirmChanges();
}