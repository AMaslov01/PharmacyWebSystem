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

function confirmChanges(){
    // May be: "Please confirm that the details are correct"
    return confirm("Are you sure you want to make these changes?"); // Display confirmation dialog and return user's choice
}

function validateForm(){
    return confirmChanges();
}
function updatePrice() {
    const select = document.getElementById("itemID");
    const price = select.options[select.selectedIndex].dataset.price || 0;
    calculateTotal(price);
}

function calculateTotal(price) {
    const quantity = parseInt(document.getElementById("quantity").value || 0);
    const total = price * quantity;
    document.getElementById("totalCost").value = total.toFixed(2);
}

function resetForm() {
    document.getElementById("totalCost").value = '';
}
