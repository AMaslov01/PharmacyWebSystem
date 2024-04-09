/*
    Customer Prescription Report
    JavaScript for the Screen
    C00290945 Artemiy Maslov 03.2024
*/
// Get the select element
var selectElement = document.getElementById("customerDescription");

// Function to toggle display of links and adjust menu button size
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

// Function to show/hide start and end date inputs based on selection
function populate() {
    var select = document.getElementById("customerDescription");
    var startDatesDescription = document.getElementById("startDatesDescription");
    var endDatesDescription = document.getElementById("endDatesDescription");
    var selectedValue = select.value;
    if (selectedValue === 'default') {
        startDatesDescription.style.display = 'none';
        endDatesDescription.style.display = 'none';
    } else {
        startDatesDescription.style.display = 'block';
        endDatesDescription.style.display = 'block';
    }
}

// Function to enable/disable date inputs based on selection
function enableDiv() {
    var select = document.getElementById('customerDescription');
    var selectOption = select.options[selectElement.selectedIndex];
    var startDiv = document.getElementById('startDatesDescription');
    var endDiv = document.getElementById('endDatesDescription');
    var startLabel = document.getElementById('startDatesLabel');
    var endLabel = document.getElementById('endDatesLabel');
    if(selectOption.value != "default") {
        startDiv.style.display = 'block';
        startLabel.style.display = 'block';
        endDiv.style.display = 'block';
        endLabel.style.display = 'block';
    } else {
        startDiv.style.display = 'none';
        startLabel.style.display = 'none';
        endDiv.style.display = 'none';
        endLabel.style.display = 'none';
    }
}

// Function to check if end date is after start date
function checkDates(){
    var date1 = new Date(document.getElementById("startDatesDescription").value);
    var date2 = new Date(document.getElementById("endDatesDescription").value);
    if(date1 >= date2) {
        alert("Ending date must be after starting date!");
        return false;
    }
    return true;
}

// Function to handle form submission
function onSubmit(){
    checkDates();
}

// Functions to set sorting options and trigger form submission
function dateOrder(){
    document.reportForm.choice.value = "date";
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}
function surnameOrder(){
    document.reportForm.choice.value = "Surname";
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}
function costOrder(){
    document.reportForm.choice.value = "Cost";
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}

// Function to handle 'OPEN' button click and trigger form submission
function openButton(button){
    document.reportForm.choice.value = button.value;
    document.getElementById("startDatesDescription").removeAttribute("required");
    document.getElementById("endDatesDescription").removeAttribute("required");
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}

// Function to navigate back and trigger form submission
function navigateBack(){
    document.reportForm.choice.value = "nothing";
    document.getElementById("startDatesDescription").removeAttribute("required");
    document.getElementById("endDatesDescription").removeAttribute("required");
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}

// Function to perform search and trigger form submission
function search(){
    document.reportForm.choice.value = document.getElementById("searchById").value;
    document.getElementById("startDatesDescription").removeAttribute("required");
    document.getElementById("endDatesDescription").removeAttribute("required");
    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}
