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
        document.getElementById("costPrice").value = "";
        document.getElementById("retailPrice").value = "";
        document.getElementById("reorderLevel").value = "";
        document.getElementById("reorderQuantity").value = "";
        document.getElementById("quantityInStock").value = "";
        document.getElementById("supplierName").value = "";
    } else {
        // Split the details using the delimiter (comma)
        var stockDetails = details.split(',');
        document.getElementById("stockID").value = stockDetails[0];
        document.getElementById("description").value = stockDetails[1];
        document.getElementById("costPrice").value = stockDetails[2];
        document.getElementById("retailPrice").value = stockDetails[3];
        document.getElementById("reorderLevel").value = stockDetails[4];
        document.getElementById("reorderQuantity").value = stockDetails[5];
        document.getElementById("quantityInStock").value = stockDetails[6];
        document.getElementById("supplierName").value = stockDetails[7];
    }
}

function toggleLock() {
    if(document.getElementById("amendViewButton").value === "AMEND") {
        document.getElementById("description").disabled = false;
        document.getElementById("costPrice").disabled = false;
        document.getElementById("retailPrice").disabled = false;
        document.getElementById("reorderLevel").disabled = false;
        document.getElementById("reorderQuantity").disabled = false;
        document.getElementById("quantityInStock").disabled = false;
        document.getElementById("amendViewButton").value = "VIEW";
        document.getElementById("amendViewButton").style.backgroundColor = "rgb(0, 146, 69)";
    } else {
        document.getElementById("description").disabled = true;
        document.getElementById("costPrice").disabled = true;
        document.getElementById("retailPrice").disabled = true;
        document.getElementById("reorderLevel").disabled = true;
        document.getElementById("reorderQuantity").disabled = true;
        document.getElementById("quantityInStock").disabled = true;
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