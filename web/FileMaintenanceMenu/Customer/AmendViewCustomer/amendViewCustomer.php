<!--
    NAME:           ABDULLAH JOBBEH
    DESCRIPTION:    AMEND VIEW CUSTOMER FILE FOR AMENDING A CUSTOMER FROM A DATABASE  
    DATE:           1/4/2024
    STUDENTID:      C00284285
-->
<?php
// Enable detailed error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start or resume a session to retain user data between requests
session_start();

// Include the database connection script from a relative path
include '../../../db.inc.php';

// Check if a reset action has been requested via GET parameter
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    // Clear session variable used to check form submission
    unset($_SESSION['form_submitted']);
    // Redirect to remove the action parameter from the URL
    header('Location: amendViewCustomer.php');
    exit;
}

// Retrieve and store any session messages, or set default if not set
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

// Check if the form has been submitted and ensure it hasn't been submitted before
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Prepare SQL query to update customer details based on form input
    $sql = "UPDATE customer SET   
                    customerSurname = '{$_POST['surname']}',
                    customerName = '{$_POST['firstname']}',
                    Address1 = '{$_POST['Address']}',
                    eircode = '{$_POST['eircode']}',
					dateOfBirth = '{$_POST['dob']}',
                    telephoneNumber = '{$_POST['TelephoneNumber']}'
                    WHERE customerID = '{$_POST['customerIdentity']}'";

    // Execute the query and check for success
    if (mysqli_query($con, $sql)) {
        $message = "RECORD UPDATED SUCCESSFULLY. ID: ".$_POST['customerIdentity'];
    } else {
        // On error, set a message with the SQL error
        $message = "An Error in the SQL Query: " . mysqli_error($con);
    }

    // Mark the form as submitted in the session to prevent resubmission
    $_SESSION['form_submitted'] = true;
} elseif (isset($_SESSION['form_submitted'])) {
    // Notify user if the form was already submitted
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM";
}

// Clear the form submission flag if the page is refreshed or revisited
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    $message = '';
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="amendViewCustomer.css">
    <title>View/Amend Customer</title>
</head>
<body>

<div class="header">
    <!-- Simplified header for navigation and logo -->
    <div class="logo">
        <a href="../../../menu.html"><img src="../../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
    </div>

    <div class="menu_button" id="menu_button">
        <p class="menu">MENU</p>
    </div>

    <div class="page_name">
        <p class="page">VIEW/AMEND CUSTOMER</p>
    </div>
    
    <!-- Dynamic display of links based on user interaction -->
    <div class="links" id="links">
        <!-- Various navigation links to other parts of the system -->
        <!-- Links are dynamically shown or hidden based on user actions -->
        <div class="link" style="top: 5px; left: 0;">
            <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
        </div>
        <!-- Example of linking to other functionalities of the system -->
        <div class="link" style="top: 50px; left: 0;">
            <a href="dispenseDrugs.php" style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
        </div>
        <!-- Each link can be styled individually or use a common class -->
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
        <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
    </div>
</div>

<!-- Form for submitting customer changes -->
<form action="amendViewCustomer.php" method="post" onsubmit="return validateForm()">
    <!-- Customer selection dropdown -->
    <div class="form_line">
        <label for="customerIdentity">SELECT CUSTOMER</label>
        <select name="customerIdentity" id="customerIdentity" onclick="populate()" required>
            <option value="">Select a Customer</option>
            <?php
            // Reconnect to the database for fetching customer options
            include '../../../db.inc.php';

            // SQL query to fetch active customers
            $sql = "SELECT customerID, customerSurname, customerName, Address1,
                        eircode, dateOfBirth, telephoneNumber FROM customer
                        WHERE customer.isDeleted = 0
                        ORDER BY customerSurname ASC";
            $result = mysqli_query($con, $sql);

            // Generate options for the dropdown menu with customer details
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $details = implode(',', $row); // Combine details for use in the script
                    echo '<option value="'.$row['customerID'].'" data-details="'.$details.'">'.$row['customerSurname'].'</option>';
                }
            } else {
                echo '<option value="">Failed to load Customer</option>';
            }

            // Close the database connection again
            mysqli_close($con);
            ?>
        </select>
    </div>
    <!-- Button for amending view, script-controlled to toggle field editability -->
    <input type="button" value="AMEND" id="amendViewButton" onclick="toggleLock()">
    <!-- Input fields for customer details, initially disabled -->
    <!-- Include JavaScript to handle enabling these fields when 'AMEND' is clicked -->
    <div class="form_line">
        <label for="customerID">CUSTOMER ID</label>
        <input type="text" id="customerID" name=customerID required disabled>
    </div>

    <!-- More fields follow similar pattern -->
    <div class="form_line">
        <label for="surname">SURNAME</label>
        <input type="text" id="surname" name="surname" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="firstname">FIRST NAME</label>
        <input type="text" id="firstname" name="firstname" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="Address">ADDRESS</label>
        <input type="text" id="Address" name="Address" pattern="[0-9A-Za-z\s]+" required disabled>
    </div>

    <div class="form_line">
        <label for="eircode">EIRCODE</label>
        <input type="text" id="eircode" name="eircode" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
    </div>

    <div class="form_line">
        <label for="dob">DATE OF BIRTH</label>
        <input type="date" id="dob" name="dob" required disabled>
    </div>

    <div class="form_line">
        <label for="TelephoneNumber">TELEPHONE NUMBER</label>
        <input type="tel" id="TelephoneNumber" name="TelephoneNumber" pattern="[0-9\s+\-]+" required disabled>
    </div>

    <!-- Submit button -->
    <div class="form_line">
        <span></span>
        <input type="submit" value="SAVE" name="submit"/>
    </div>
    <!-- Section to display messages and a button to reset the form state -->
    <div class="form_line">
        <div class="amended" id="amended">
            <br><br><br>
            <label>
                <?php if (!empty($message)) : ?>
                    <p><?php echo $message; ?></p>
                    <!-- Button to clear the message, linking to a reset action -->
                    <div class="okButton"><a href="amendViewCustomer.php?action=resetMessage" class="okText">OK</a></div>
                <?php endif; ?>
            </label>
        </div>
    </div>
</form>
<script src="amendViewCustomer.js"></script>
</body>
</html>
