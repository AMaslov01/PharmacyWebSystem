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


function validateForm(){
    // Get the values entered in the email and confirm email fields
    var email = document.getElementById('email').value;
    var confirmEmail = document.getElementById('confirm_email').value;

    // Check if the entered emails match
    if (email != confirmEmail) {
        alert("Emails do not match!");
        return false; // Prevent form submission if emails don't match
    }

    // Call validateAge function to check age restriction (at least 17 years old)
    if (!validateAge()){
        alert("You must be at least 17 years old!");
        return false; // Prevent form submission if age condition is not met
    }

    // Call validateStartDate function to ensure start date is not before today
    if (!validateStartDate()){
        alert("Starting Date must not be before today's date!");
        return false; // Prevent form submission if start date is invalid
    }

    return true; // Allow form submission if all validations pass
}