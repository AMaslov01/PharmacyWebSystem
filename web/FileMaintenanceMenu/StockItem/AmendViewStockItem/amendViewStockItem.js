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
        document.getElementById("supplierName").disabled = false;
        document.getElementById("amendViewButton").value = "VIEW";
        document.getElementById("amendViewButton").style.backgroundColor = "rgb(0, 146, 69)";
        document.getElementById("supplierDiv1").style.display = 'none';
        document.getElementById("supplierDiv2").style.display = 'block';
    } else {
        document.getElementById("description").disabled = true;
        document.getElementById("costPrice").disabled = true;
        document.getElementById("retailPrice").disabled = true;
        document.getElementById("reorderLevel").disabled = true;
        document.getElementById("reorderQuantity").disabled = true;
        document.getElementById("quantityInStock").disabled = true;
        document.getElementById("supplierName").disabled = true;
        document.getElementById("amendViewButton").value = "AMEND";
        document.getElementById("amendViewButton").style.backgroundColor = "#727272";
        document.getElementById("supplierDiv2").style.display = 'none';
        document.getElementById("supplierDiv1").style.display = 'block';
        // TODO: make it so that correct supplier name is preselected
        document.getElementById("preselectedSupplier").value = "SUPPLIER"
        //document.getElementById("supplierDiv2").value = document.getElementById("supplierDiv1").value;
    }
}

/*
function toggleSupplierField(isAmend) {
    var parentDiv = document.getElementById('supplierField'); // Assuming you wrap your supplier name field in a div with id="supplierField"
    parentDiv.innerHTML = ''; // Clear the current field

    if (isAmend) {
        // Create and append the input field
        var input = document.createElement('input');
        input.type = 'text';
        input.id = 'supplierName';
        input.name = 'supplierName';
        input.pattern = '[0-9A-Za-z., ]+';
        input.required = true;
        parentDiv.appendChild(input);
    } else {
        // Create and append the select dropdown
        var select = document.createElement('select');
        select.id = 'supplierName';
        select.name = 'supplierName';
        select.required = true;

        // Option placeholder
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Select a supplier';
        select.appendChild(defaultOption);
        var suppliers;
        // Fetch and append supplier options
        <?php
        echo "var suppliers = [";
        include '../../../db.inc.php'; // Adjust the path as necessary
        $sql = "SELECT supplierID, supplierName FROM supplier ORDER BY supplierName ASC";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "{id: '{$row['supplierID']}', name: '{$row['supplierName']}'},";
            }
        }
        echo "];";
        mysqli_close($con);
        ?>

        suppliers.forEach(function(supplier) {
            var option = document.createElement('option');
            option.value = supplier.id;
            option.textContent = supplier.name;
            select.appendChild(option);
        });

        parentDiv.appendChild(select);
    }
}
*/

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

function confirmChanges(){
    // May be: "Please confirm that the details are correct"
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    if(document.getElementById("amendViewButton").value === "AMEND"){
        return false;
    }
    return confirmChanges();
}