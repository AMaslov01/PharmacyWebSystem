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
    var sel = document.getElementById("stockItemDescription");
    var result = sel.options[sel.selectedIndex].value;
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");

    if (result === "") {
        // Clear all fields if no stock item is selected
        document.getElementById("stockID").value = "";
        document.getElementById("description").value = "";
        document.getElementById("quantityInStock").value = "";
        document.getElementById("costPrice").value = "";
        document.getElementById("supplierName").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var stockDetails = details.split(',');
        document.getElementById("stockID").value = stockDetails[0];
        document.getElementById("description").value = stockDetails[1];
        document.getElementById("quantityInStock").value = stockDetails[2];
        document.getElementById("costPrice").value = stockDetails[3];
        document.getElementById("supplierName").value = stockDetails[4];
    }

    console.log(stockDetails[5]);
}

document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("deleted");
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

function confirmChanges(){
    return confirm("Are you sure you want to delete this item?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    var sel = document.getElementById("stockItemDescription");
    var details = sel.options[sel.selectedIndex].getAttribute("data-details");
    var stockDetails = details.split(',');

    if(stockDetails[2] > 0 || stockDetails[5] > 0) {
        alert("You can not delete this item");
        return false;
    }
    return confirmChanges();
}