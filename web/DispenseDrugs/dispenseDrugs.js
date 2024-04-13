/*
    Dispense Drugs
    JS for the dispenseDrugs.php page
    C00290930 Evgenii Salnikov 04.2024
*/

// Function for the MENU button behaviour
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

// Function for styling customer description field because requires logic and can not be done strictly with CSS
document.getElementById("customerDescription").addEventListener("change", function () {
    var select = this;
    if (select.value !== "") {
        select.style.backgroundColor = "#727272";
    } else {
        select.style.backgroundColor = "rgb(0, 146, 69)";
    }
});

// Function for populating the form fields
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

/* Function to when displaying the added message, scroll the user to its location on the page */
document.addEventListener("DOMContentLoaded", function() {
    var messageDiv = document.getElementById("added");
    var message = messageDiv.textContent || messageDiv.innerText; // Set the message
    if (message.trim().length > 1) { // Simply, if message exists
        messageDiv.style.display = "block"; // Make sure the div is visible
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        messageDiv.style.display = "none"; // Hide div if no message
    }
});

// Function that gets triggered when you select a drug. This function will parse the data-details for the selected option, extract the price, and update a hidden input or a display element.
function updateDrugPrice() {
    document.getElementById('clearMessage').innerHTML = '';
    var select = document.getElementById('drugBrandName');
    var details = select.options[select.selectedIndex].getAttribute('data-details');

    if (details) {
        var detailsArray = details.split(',');
        var retailPrice = detailsArray[2]; // RetailPrice is the third ([2]) item

        // Update hidden input or any display element
        document.getElementById('displayPrice').style.display = "block";
        document.getElementById('displayPrice').innerText = "RETAIL PRICE: " + retailPrice;
        document.getElementById('retailPrice').value = retailPrice;
    }
}

// Function to add, process and store the added drug
function addDrug() {
    // Capture form data
    const drugBrandName = document.getElementById('drugBrandName').options[document.getElementById('drugBrandName').selectedIndex].text;
    const drugID = document.getElementById('drugBrandName').value;
    const sizeOfDosage = parseInt(document.getElementById('sizeOfDosage').value);
    const frequencyOfDosage = parseInt(document.getElementById('frequencyOfDosage').value);
    const lengthOfDosage = parseInt(document.getElementById('lengthOfDosage').value);
    const instructions = document.getElementById('instructions').value;

    // Validate input to ensure none of the required fields are zero or NaN
    if (isNaN(sizeOfDosage) || sizeOfDosage <= 0 ||
        isNaN(frequencyOfDosage) || frequencyOfDosage <= 0 ||
        isNaN(lengthOfDosage) || lengthOfDosage <= 0) {
        return; // Prevent adding incomplete data
    }

    // Get the retail price from the hidden input
    const pricePerUnit = parseInt(document.getElementById('retailPrice').value); // Assuming you have an input with id 'retailPrice' storing the price

    // Calculate the cost of the drug
    const cost = sizeOfDosage * frequencyOfDosage * lengthOfDosage * pricePerUnit;

    // Store the drug information in sessionStorage or a temporary JavaScript object
    const drugData = {
        drugID,
        drugBrandName,
        sizeOfDosage,
        frequencyOfDosage,
        lengthOfDosage,
        instructions,
        cost
    };

    // Display a message with the drug cost and update the list of added drugs
    let messageArea = document.getElementById('drugMessages');
    let existingMessages = messageArea.innerHTML;
    existingMessages += `<p class="drugsData">ADDED: ${drugBrandName} - SIZE: ${sizeOfDosage} - FREQUENCY: ${frequencyOfDosage} - LENGTH: ${lengthOfDosage} - COST: ${cost.toFixed(2)}</p>`;
    messageArea.innerHTML = existingMessages;

    // Store in sessionStorage
    if (!sessionStorage.getItem('drugs')) { // Check if there is any data stored in sessionStorage under the key 'drugs'. If nothing is stored under that key, it returns null
        // Set the item in sessionStorage with the key 'drugs'. If there is no data for 'drugs' (it's null), it initializes 'drugs' in the storage with an empty array in JSON format. JSON.stringify([]) converts an empty array [] into a JSON string
        sessionStorage.setItem('drugs', JSON.stringify([]));
    }
    // Retrieve the JSON string stored under 'drugs' from sessionStorage and convert it back into a JavaScript array. JSON.parse is a function that parses a JSON string, constructing the JavaScript value or object described by the string
    let drugs = JSON.parse(sessionStorage.getItem('drugs'));
    // Add the new drugData object to the array that was just parsed from the JSON string
    drugs.push(drugData);
    // After modifying the drugs array by adding new drug data, the entire array is converted back into a JSON string so that it can be stored in sessionStorage
    sessionStorage.setItem('drugs', JSON.stringify(drugs));
}

// Function to update hidden input drug before submission
document.getElementById('drugForm').addEventListener('submit', function() {
    const drugs = sessionStorage.getItem('drugs');
    document.getElementById('drugsData').value = drugs ? drugs : '[]';
});

// Function for the clear button
function resetDrugs() {
    // Clear the drugs array from sessionStorage
    sessionStorage.removeItem('drugs');

    // Clear the display of added drugs in the HTML
    document.getElementById('drugMessages').innerHTML = '';
    document.getElementById('displayPrice').style.display = "none";
    document.getElementById('clearMessage').innerHTML += `<p class="drugsData">CLEARED DRUGS AND FORM</p>`;
}

// Adding an event listener to the clear button
document.getElementById('clear').addEventListener('click', resetDrugs);

// Function to confirm changes
function confirmChanges(){
    // May be: "Please confirm that the details are correct"
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

// Function to validate teh form
function validateForm(){
    return confirmChanges();
}