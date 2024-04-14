<!--
    NAME:           ABDULLAH JOBBEH
    DESCRIPTION:    ADD CUSTOMER FILE FOR ADDING CUSTOMER TO DATABASE  
    DATE:           1/4/2024
    STUDENTID:      C00284285
-->
<?php   
    session_start(); // Start a new session or resume the existing one
    include '../../../db.inc.php'; // Include the database connection file

    // Reset message handling
    if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
        unset($_SESSION['form_submitted']); // Clear the form submission session flag
        header('Location: addCustomer.php'); // Redirect to the addCustomer page to prevent form resubmission
        exit;
    }

    // Retrieve any previously set message from session, otherwise set to empty
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

    // Check if the form has been submitted and the form has not been previously submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        // SQL query to find the highest current customerId
        $sql = "SELECT MAX(customerID) AS MaxcustomerID FROM Customer";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxCustomerID = $row['MaxcustomerID'];
        $newCustomerID = $maxCustomerID + 1; // Increment to get new customer ID

        // Collect data from form fields
        $customerSurname = $_POST['surname'];
        $customerName = $_POST['firstname'];
        $Address1 = $_POST['address'];
        $eircode = $_POST['eircode'];
        $dateOfBirth = $_POST['dob'];
        $telephoneNumber = $_POST['phone'];
    
        // SQL to insert the new customer into the database
        $sql = "INSERT INTO Customer (customerID, customerSurname, customerName, Address1, eircode, dateOfBirth, telephoneNumber) VALUES 
		('$newCustomerID', '$customerSurname', '$customerName', '$Address1', '$eircode', '$dateOfBirth', '$telephoneNumber')";
		
        // Execute the query and handle the result
        if (mysqli_query($con, $sql)) {
            $customerID = mysqli_insert_id($con);
            header("Location: confirmCustomer.php?customerID=$customerID"); // Redirect to confirmation page with the new customer ID
            exit;
        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $_SESSION['form_submitted'] = true; // Mark the form as submitted in the session
    } else if (isset($_SESSION['form_submitted'])) {
        $message = "YOU HAVE ALREADY SUBMITTED THE FORM";
    }

    // If the page is reloaded with a non-POST request, clear the submission flag
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        unset($_SESSION['form_submitted']);
        $message = '';
    }

    mysqli_close($con); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="addCustomer.css">
    <title>Add Customer</title>
</head>
<body>

    <!-- Page Header with logo and navigation -->
    <div class="header">
        <div class="logo">
            <a href="../../../menu.html"><img src="../../../Resources/logo6.png" alt="logo" width="110px" height="110px"></a>
        </div>

        <div class="menu_button" id="menu_button">
            <p class="menu">MENU</p>
        </div>

        <div class="page_name">
            <p class="page">ADD CUSTOMER FORM</p>
        </div>

        <!-- Navigation Links -->
        <div class="links" id="links">
            <!-- Link structure shown with explicit style attributes -->
            <div class="link" style="top: 5px; left: 0;">
                <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
            </div>
            <div class="link" style="top: 50px; left: 0;">
                <a style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
            </div>
            <div class="link" style="top: 0; left: 350px">
                <a style="margin: 0; color: white; font-size: 30px;">STOCK CONTROL MENU</a>
            </div>
            <div class="link" style="top: 50px; left: 350px">
                <a style="margin: 0; color: white; font-size: 30px;">SUPPLIER ACCOUNTS MENU</a>
            </div>
            <div class="link" style="top: 0; left: 820px">
                <a href="../../fileMaintenanceMenu.html" style="margin: 0; color: white; font-size: 30px;">FILE MAINTENANCE MENU</a>
            </div>
            <div class="link" style="top: 50px; left: 820px">
                <a style="margin: 0; color: white; font-size: 30px;">REPORTS MENU</a>
            </div>
        </div>

        <div class="logout">
            <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" alt="logo" width="160px" height="160px"></a>
        </div>
    </div>

    <!-- Form for adding a new customer with input validations -->
    <form method="post" onsubmit="return validateForm()">
        <div class="form_line">
            <label for="firstname">FIRSTNAME</label>
            <input type="text" id="firstname" name="firstname" pattern="[A-Za-z. ]+" required>
        </div>

        <div class="form_line">
            <label for="surname">SURNAME</label>
            <input type="text" id="surname" name="surname" pattern="[A-Za-z. ]+" required>
        </div>

        <div class="form_line">
            <label for="address">ADDRESS</label>
            <input type="text" id="address" name="address" pattern="[A-Za-z0-9., ]+" placeholder="County, Town, Street, House, Flat" required>
        </div>

        <div class="form_line">
            <label for="eircode">EIRCODE</label>
            <input type="text" id="eircode" name="eircode" pattern="[A-Za-z]{1}[0-9]{2}[A-Za-z]{2}[0-9]{2}" placeholder="A12BC34" required>
        </div>

        <div class="form_line">
            <label for="dob">DATE OF BIRTH</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <div class="form_line">
            <label for="phone">TELEPHONE NUMBER</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9\(\)\s\-]+" placeholder="(123) 456-7890" required>
        </div>

        <div class="form_line">
            <input type="reset" value="CLEAR" name="reset"/>
            <input type="submit" value="SEND" name="submit"/>
        </div>
    </form>

    <script src="addCustomer.js"></script>
</body>
</html>
