var inputStart = document.getElementById("startDatesDescription").value;
var inputEnd = document.getElementById("endDatesDescription").value;
// Get the select element
var selectElement = document.getElementById("customerDescription");

// Get the selected option
var selectedOption = selectElement.options[selectElement.selectedIndex];

// Get the value attribute of the selected option
var selectedValue = selectedOption.value;

// Get the text content of the selected option
var selectedText = selectedOption.textContent;

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


function enableDiv() {
    var select = document.getElementById('customerDescription');
    var selectOption = select.options[selectElement.selectedIndex];
    if(selectOption.value != "default") {
        var startDiv = document.getElementById('startDatesDescription');
        var endDiv = document.getElementById('endDatesDescription');
        var startLabel = document.getElementById('startDatesLabel');
        var endLabel = document.getElementById('endDatesLabel');


        // Check if the selected value is not the default option
        if (select.value !== "default") {
            console.log("done");
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
}
function checkDates(){
    var date1 = new Date(document.getElementById("startDatesDescription").value);
    var date2 = new Date(document.getElementById("endDatesDescription").value);
    var reportForm = document.getElementById("reportForm");
    if(date1>=date2) {
        alert("Ending date must be after starting date!");
        return false;
    }
    return true;
}
function storeValues(){
    selectElement = document.getElementById("customerDescription");

// Get the selected option
    selectedOption = selectElement.options[selectElement.selectedIndex];

// Get the value attribute of the selected option
    selectedValue = selectedOption.value;

// Get the text content of the selected option
    selectedText = selectedOption.textContent;
    console.log("select value: " + selectedValue);
    console.log("select text: " + selectedText);
    inputStart = document.getElementById("startDatesDescription").value;
    console.log("start: " + inputStart);
    inputEnd = document.getElementById("endDatesDescription").value;
    console.log("end: " + inputEnd);
}

/*
function restoreValues(){
    selectElement = document.getElementById("customerDescription");

// Get the selected option
    selectElement.value = selectedValue;
    selectElement.textContent = selectedText;
    document.getElementById("startDatesDescription").value = inputStart;
    document.getElementById("endDatesDescription").value = inputEnd;
    console.log("restored values");
} */

function onSubmit(){
    checkDates();
    storeValues();
}
function dateOrder(){
    document.reportForm.choice.value = "date";
    console.log(document.reportForm.choice.value);


    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);

}

// JavaScript function to set choice value and submit form for surname order
function surnameOrder(){

    document.reportForm.choice.value = "Surname";
    console.log(document.reportForm.choice.value);


    var form = document.getElementById("reportForm");
    var submitEvent = new Event("submit");
    form.dispatchEvent(submitEvent);
}
/*
document.getElementById("reportForm").addEventListener("submit", function(event) {
    // Your function logic here
    console.log("Form submitted to server.");
    restoreValues();

    // This will execute after the form is submitted to the server
});*/





















