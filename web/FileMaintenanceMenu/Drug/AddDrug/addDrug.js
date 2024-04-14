// Author			: Nebojsa Kukic
// Date				: 23/02/2024
// Purpose			: Add a Drug to the Customer Table.
//					: This is the javascript


// Wait for the entire content of the web page to load before running the script
document.addEventListener('DOMContentLoaded', function() {
    // Grab references to each input and the form itself by their respective IDs
    const form = document.getElementById('formID');
    const brandName = document.getElementById('brandName');
    const genericName = document.getElementById('genericName');
    const drugForm = document.getElementById('drugForm');
    const drugStrength = document.getElementById('drugStrength');
    const usageInstructions = document.getElementById('usageInstructions');
    const sideEffects = document.getElementById('sideEffects');
	const costPrice = document.getElementById('costPrice');
	const retailPrice = document.getElementById('retailPrice');
	const reorderLevel = document.getElementById('reorderLevel');
	const reorderQuantity = document.getElementById('reorderQuantity');

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
    brandName.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid first name using alphabetic characters only.");
        }
    });

    genericName.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid surname using alphabetic characters only.");
        }
    });

    drugForm.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid address.");
        }
    });

    drugStrength.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid Eircode, e.g., A12BC34.");
        }
    });

    usageInstructions.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!validateAge(this.value)) {
            this.setCustomValidity("Invalid date of birth. The age must be more than 1 day and less than 100 years.");
        }
    });

    sideEffects.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid telephone number in the format (123) 456-7890.");
        }
    });

	costPrice.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid telephone number in the format (123) 456-7890.");
        }
    });

	retailPrice.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid telephone number in the format (123) 456-7890.");
        }
    });

	reorderLevel.addEventListener('input', function() {
        this.setCustomValidity('');
        if (!this.checkValidity()) {
            this.setCustomValidity("Please enter a valid telephone number in the format (123) 456-7890.");
        }
    });

	reorderQuantity.addEventListener('input', function() {
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
        brandName.reportValidity();
        genericName.reportValidity();
        drugForm.reportValidity();
        drugStrength.reportValidity();
        usageInstructions.reportValidity();
        sideEffects.reportValidity();
		costPrice.reportValidity();
        retailPrice.reportValidity();
        reorderLevel.reportValidity();
		reorderQuantity.reportValidity();

        // Return true if all fields are valid, else false
        return brandName.checkValidity() && genericName.checkValidity() && drugForm.checkValidity() &&
               drugStrength.checkValidity() && usageInstructions.checkValidity() && sideEffects.checkValidity() &&
			   costPrice.checkValidity() && retailPrice.checkValidity() && reorderLevel.checkValidity() && reorderQuantity.checkValidity();
    }


    
});
