<?php
/**
 * NAME:           ABDULLAH JOBBEH
 * DESCRIPTION:    DELETE CUSTOMER FILE FOR DELETING CUSTOMER FROM DATABASE
 * DATE:           1/4/2024
 * STUDENT ID:     C00284285
 */

// Start or resume a session
session_start();

// Include database connection details from an external file
include '../../../db.inc.php';

// Handle reset action if specified in the GET request
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    unset($_SESSION['form_submitted']);  // Clear the session flag for form submission
    header('Location: deleteCustomer.php');  // Redirect to the main page to prevent resubmission
    exit;  // Stop script execution
}

// Check if there is a message stored in the session and retrieve it
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

// Check if the form has been submitted and it is the first submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // SQL query to mark a customer as deleted based on customer ID from form input
    $sql = "UPDATE customer SET isDeleted = '1' WHERE customerID = '{$_POST['customerIdetity']}'";

    // Execute the SQL query
    if (mysqli_query($con, $sql)) {
        // Check if any rows were affected (to confirm that the record was actually updated)
        if (mysqli_affected_rows($con) > 0) {
            $message = "RECORD DELETED SUCCESSFULLY. ID: " . $_POST['customerIdetity'];
        } else {
            $message = "NO CHANGES WERE MADE TO THE RECORD. ID: " . $_POST['customerIdetity'];
        }
    } else {
        // If SQL execution fails, capture and store the error message
        $message = "An Error in the SQL Query: " . mysqli_error($con);
    }

    // Set a session variable to indicate that the form has been submitted
    $_SESSION['form_submitted'] = true;
} elseif (isset($_SESSION['form_submitted'])) {
    // Inform the user that the form has already been submitted if they try to submit again
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM";
}

// If the request method is not POST, reset the form submission flag
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    $message = '';  // Clear any previous messages
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Link to external css -->
        <link rel="stylesheet" href="deleteCustomer.css">
        <title>Delete Stock Item</title>
    </head>
    <body>
        <!-- Static header of the page -->
        <div class="header">
            <!-- Logo in the top left corner -->
            <div class="logo">
                <a href="../../../menu.html"><img src="../../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <!-- Menu button that displays the menu links -->
            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <!-- Name of the current page -->
            <div class="page_name">
                <p class="page">DELETE CUSTOMER</p>
            </div>

            <!-- Links to other pages that show up with the click on Menu button -->
            <div class="links" id="links">
                <div class="link" style="top: 5px; left: 0;">
                    <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
                </div>

                <div class="link" style="top: 50px; left: 0;">
                    <a href="../../../DispenseDrugs/dispenseDrugs.php" style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
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

            <!-- Logout logo and button -->
            <div class="logout">
                <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <!-- The form, that calls validateForm() function when submitted -->
        <form method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <!-- Automatically populated dropdown list of all not-deleted CUSTOMERS -->
                <label for="customerIdetity">SELECT CUSTOMER</label>
                <select name="customerIdetity" id="customerIdetity" onclick="populate()" required>
                    <option value="">Select CUSTOMER</option>
                    <?php
                    include '../../../db.inc.php';

                // Query to fetch all customers who are not marked as deleted
                    $sql = "SELECT customerID, customerSurname, customerName, Address1, eircode, dateOfBirth, telephoneNumber
                        FROM customer 
                        WHERE customer.isDeleted = 0
                        ORDER BY customerSurname ASC";

                    // Run the query
                    $result = mysqli_query($con, $sql);

                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }
        
                // Populate dropdown with customer names
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                        $details = implode(',', $row);  // Create a string of customer details
                            echo '<option value="'.$row['customerID'].'" data-details="'.$details.'">'.$row['customerSurname'].'</option>'; 
                        }
                    } else {
                        echo '<option value="">Failed to load customers</option>'; // Output failed to load doctors message
                    }

                    mysqli_close($con); // Close database connection again
                    ?>

                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="customerid">CUSTOMER ID</label>
                <input type="number" id="customerid" name="customerid" pattern="[0-9]+" required disabled>
            </div>

            <div class="form_line">
                <label for="firstname">FIRST NAME</label>
                <input type="text" id="firstname" name="firstname" pattern="[A-Za-z]+" required disabled>
            </div>

            <div class="form_line">
                <label for="lastname"> LAST NAME</label>
                <input type="text" id="lastname" name="lastname"  pattern="[A-Za-z]+" required disabled>
            </div>

            <div class="form_line">
            <label for="address">ADDRESS</label>
                <input type="text" id="address" name="address" pattern="[0-9A-Za-z\s]+" required disabled>
            </div>

            <div class="form_line">
                <label for="eircode">EIRCODE</label>
                <input type="text" id="eircode" name="eircode"  pattern="[A-Za-z]{1}[0-9]{2}[A-Za-z]{2}[0-9]{2}" required disabled>
            </div>

            <div class="form_line">
                <label for="dob">DATE OF BIRTH</label>
                <input type="date" id="dob" name="dob"   required disabled>
            </div>

            <div class="form_line">
                <label for="telephonenumber">NUMBER</label>
                <input type="number" id="telephonenumber" name="telephonenumber"  pattern="[0-9\s+\-]+" required disabled>
            </div>


            <!-- Save button -->
            <div class="form_line">
                <span></span>
                <input type="submit" value="DELETE" id="deleteButton"/>
            </div>

            <div class="form_line">
                <div class="deleted" id="deleted">
                    <br><br><br>
                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                        <!-- OK button to reset the message -->
                        <div class="okButton"><a href="deleteCustomer.php?action=resetMessage" class="okText">OK</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- Link to external JS -->
        <script src="deleteCustomer.js"></script>
    </body>
</html>