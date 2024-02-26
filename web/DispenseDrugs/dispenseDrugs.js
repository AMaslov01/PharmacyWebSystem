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

document.getElementById("stockItemDescription").addEventListener("change", function () {
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
        document.getElementById("customerID").value = "";
        document.getElementById("customerName").value = "";
        document.getElementById("address").value = "";
        document.getElementById("dateOfBirth").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var stockDetails = details.split(',');
        document.getElementById("customerID").value = stockDetails[0];
        document.getElementById("customerName").value = stockDetails[1];
        document.getElementById("address").value = stockDetails[2];
        document.getElementById("dateOfBirth").value = stockDetails[3];
    }
}

function confirmChanges(){
    return confirm("Are you sure you want to delete this item?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    var sel = document.getElementById("stockItemDescription");
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");
    var stockDetails = details.split(',');

    if(stockDetails[2] > 0 && stockDetails[5] > 0) {
        alert("You can not delete this item");
        return false;
    }
    return confirmChanges();
}