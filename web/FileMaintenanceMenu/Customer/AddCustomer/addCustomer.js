// Wait for the entire content of the web page to load before running the script
document.addEventListener('DOMContentLoaded', function() {
    // Grab references to each input and the form itself by their respective IDs
    const form = document.getElementById('formID');
    const firstname = document.getElementById('firstname');
    const surname = document.getElementById('surname');
    const address = document.getElementById('address');
    const eircode = document.getElementById('eircode');
    const dob = document.getElementById('dob');
    const phone = document.getElementById('phone');

    // Event listener for the menu button for toggling visibility of links
    document.getElementById('menu_button').addEventListener('click', function() {
        var links = document.querySelector('.links');
        var menu_button = document.querySelector('.menu_button');
        var page_name = document.querySelector('.page_name');

        // Toggle links display and adjust menu button appearance
        if (links.style.display === 'none' || links.style.display === '') {
            links.style.display = 'block'; // Show links if hidden
            menu_button.style.transform = 'scale(1.2)'; // Enlarge menu button
            page_name.style.display = 'none'; // Hide the page name during menu display
        } else {
            links.style.display = 'none'; // Hide links if shown
            menu_button.style.transform = 'scale(1.05)'; // Return menu button size to normal
            page_name.style.display = 'block'; // Show the page name when menu is not displayed
        }
    });

    // Validate each input field on input event
    firstname.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid first name using alphabetic characters only.");
        }
    });

    surname.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid surname using alphabetic characters only.");
        }
    });

    address.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid address.");
        }
    });

    eircode.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid Eircode, e.g., A12BC34.");
        }
    });

    dob.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!validateAge(this.value)) {
            this.setCustomValidity("Invalid date of birth. The age must be more than 1 day and less than 100 years.");
        }
    });

    phone.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid telephone number in the format (123) 456-7890.");
        }
    });

    // Prevent form submission until all validations pass
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Stop form from submitting immediately
        if (validateForm()) {
            form.submit(); // Submit form if all validations pass
        }
    });

    // Function to check the validity of all fields
    function validateForm() {
        // Force the browser to display validation messages for all fields
        firstname.reportValidity();
        surname.reportValidity();
        address.reportValidity();
        eircode.reportValidity();
        dob.reportValidity();
        phone.reportValidity();

        // Return true if all fields are valid, else false
        return firstname.checkValidity() && surname.checkValidity() && address.checkValidity() &&
               eircode.checkValidity() && dob.checkValidity() && phone.checkValidity();
    }

    // Function to validate age with given constraints
    function validateAge(dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        const oneDayAgo = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 1);
        const oneHundredYearsAgo = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());
        return birthDate > oneHundredYearsAgo && birthDate < oneDayAgo; // Check if age is within valid range
    }
});
