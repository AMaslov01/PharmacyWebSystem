
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
document.getElementById('selectDates').addEventListener('submit', function(event) {
    document.getElementById('reportForm').style.display = 'block';
});

function dateOrder(){
    document.reportForm.choice.value = "DOB";
    document.reportForm.submit();
}

// JavaScript function to set choice value and submit form for surname order
function surnameOrder(){
    document.reportForm.choice.value = "Surname";
    document.reportForm.submit();
}




























