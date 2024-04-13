/*
    File Maintenance Menu
    JS for the fileMaintenanceMenu.html page
    C00290930 Evgenii Salnikov 04.2024
*/

// buttons and actions variables
var customer_button = document.querySelector('.customer_button');
var customer_actions = document.querySelector('.customer_actions');
var doctor_button = document.querySelector('.doctor_button');
var doctor_actions = document.querySelector('.doctor_actions');
var drug_button = document.querySelector('.drug_button');
var drug_actions = document.querySelector('.drug_actions');
var supplier_button = document.querySelector('.supplier_button');
var supplier_actions = document.querySelector('.supplier_actions');
var stock_button = document.querySelector('.stock_button');
var stock_actions = document.querySelector('.stock_actions');

/* Function for the MENU button behaviour */
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

/* Function to hide other actions when customer is selected */
document.getElementById('customer_button').addEventListener('click', function() {
    if (customer_actions.style.display === 'none' || customer_actions.style.display === '') {
        customer_actions.style.display = 'block';
        customer_button.style.transform = 'scale(1.12)';

        doctor_actions.style.display = 'none';
        doctor_button.style.transform = 'scale(1)';
        drug_actions.style.display = 'none';
        drug_button.style.transform = 'scale(1)';
        supplier_actions.style.display = 'none';
        supplier_button.style.transform = 'scale(1)';
        stock_actions.style.display = 'none';
        stock_button.style.transform = 'scale(1)';
    } else {
        customer_actions.style.display = 'none';
        customer_button.style.transform = 'scale(1.05)';
    }
});

/* Function to hide other actions when doctor is selected */
document.getElementById('doctor_button').addEventListener('click', function() {
    if (doctor_actions.style.display === 'none' || doctor_actions.style.display === '') {
        doctor_actions.style.display = 'block';
        doctor_button.style.transform = 'scale(1.12)';

        customer_actions.style.display = 'none';
        customer_button.style.transform = 'scale(1)';
        drug_actions.style.display = 'none';
        drug_button.style.transform = 'scale(1)';
        supplier_actions.style.display = 'none';
        supplier_button.style.transform = 'scale(1)';
        stock_actions.style.display = 'none';
        stock_button.style.transform = 'scale(1)';
    } else {
        doctor_actions.style.display = 'none';
        doctor_button.style.transform = 'scale(1.05)';
    }
});

/* Function to hide other actions when drug is selected */
document.getElementById('drug_button').addEventListener('click', function() {
    if (drug_actions.style.display === 'none' || drug_actions.style.display === '') {
        drug_actions.style.display = 'block';
        drug_button.style.transform = 'scale(1.12)';

        customer_actions.style.display = 'none';
        customer_button.style.transform = 'scale(1)';
        supplier_actions.style.display = 'none';
        supplier_button.style.transform = 'scale(1)';
        stock_actions.style.display = 'none';
        stock_button.style.transform = 'scale(1)';
        doctor_actions.style.display = 'none';
        doctor_button.style.transform = 'scale(1)';
    } else {
        drug_actions.style.display = 'none';
        drug_button.style.transform = 'scale(1.05)';
    }
});

/* Function to hide other actions when supplier is selected */
document.getElementById('supplier_button').addEventListener('click', function() {
    if (supplier_actions.style.display === 'none' || supplier_actions.style.display === '') {
        supplier_actions.style.display = 'block';
        supplier_button.style.transform = 'scale(1.12)';

        customer_actions.style.display = 'none';
        customer_button.style.transform = 'scale(1)';
        drug_actions.style.display = 'none';
        drug_button.style.transform = 'scale(1)';
        stock_actions.style.display = 'none';
        stock_button.style.transform = 'scale(1)';
        doctor_actions.style.display = 'none';
        doctor_button.style.transform = 'scale(1)';
    } else {
        supplier_actions.style.display = 'none';
        supplier_button.style.transform = 'scale(1.05)';
    }
});

/* Function to hide other actions when stock is selected */
document.getElementById('stock_button').addEventListener('click', function() {
    if (stock_actions.style.display === 'none' || stock_actions.style.display === '') {
        stock_actions.style.display = 'block';
        stock_button.style.transform = 'scale(1.12)';

        customer_actions.style.display = 'none';
        customer_button.style.transform = 'scale(1)';
        drug_actions.style.display = 'none';
        drug_button.style.transform = 'scale(1)';
        supplier_actions.style.display = 'none';
        supplier_button.style.transform = 'scale(1)';
        doctor_actions.style.display = 'none';
        doctor_button.style.transform = 'scale(1)';
    } else {
        stock_actions.style.display = 'none';
        stock_button.style.transform = 'scale(1.05)';
    }
});