/*
    Menu
    JS for the menu.html page
    C00290930 Evgenii Salnikov 04.2024
*/

/* Function for the MENU button behaviour */
document.getElementById('menu_button').addEventListener('click', function() {
    var links = document.querySelector('.links');
    var menu_button = document.querySelector('.menu_button');
    if (links.style.display === 'none' || links.style.display === '') {
        links.style.display = 'block'; // Show the links
        menu_button.style.transform = 'scale(1.2)'; // Make the MENU larger
    } else {
        links.style.display = 'none'; // Hide the links
        menu_button.style.transform = 'scale(1.05)'; // Make the MENU smaller
    }
});