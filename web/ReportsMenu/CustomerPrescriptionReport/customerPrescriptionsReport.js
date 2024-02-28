
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

    var datesDescription = document.getElementById("datesDescription");

    var selectedValue = select.value;

    if (selectedValue === 'default') {
        datesDescription.style.display = 'none';
    } else {
        datesDescription.style.display = 'block';
    }
}


function enableDiv() {
    var select = document.getElementById('customerDescription');
    var div = document.getElementById('datesDescription');
    var label = document.getElementById('datesLabel');
    // Check if the selected value is not the default option
    if (select.value !== "default") {
        console.log("done");
        div.style.display = 'block';
        label.style.display = 'block';
    } else {
        div.style.display = 'none'; // Add the disabled class to disable the div
        label.style.display = 'none';
    }
}