<?php   
    session_start();
    include '../../../db.inc.php';

    // Check if the reset action is requested
    if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
        unset($_SESSION['form_submitted']);
        // Redirect to the same page without the query parameter to avoid accidental resets on refresh
        header('Location: addCustomer.php');
        exit;
    }

    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        // Fetch the highest current  customerId
        $sql = "SELECT MAX(cutomerID) AS MaxcustomerID FROM Customer";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxCustomerID = $row['MaxcustomerID'];

        // Increment the Customerid by 1 for the new record
        $newCustomerID = $maxCustomerID + 1;

        $customerSurname= $_POST['surname'];
        $customerName = $_POST['firstname'];
        $Address1 = $_POST['address'];
        $eircode = $_POST['eircode'];
        $dateOfBirth = $_POST['dob']
        $telephoneNumber = $_POST['phone']	
    

        $sql = "INSERT INTO Customer (customerID, description, customerSurname, customerName, Address1, eircode, dateOfBirth, telephoneNumber) VALUES ('$customerSurname', '$customerName', '$address', '$eircode', '$dateOfBirth', '$telephoneNumber', 0)";

        if (mysqli_query($con, $sql)) {
            $message = "A NEW CUSTOMER HAS BEEN ADDED. ID: $maxStockID";
        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $customerID = mysqli_insert_id($con);

        $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
    } elseif (isset($_SESSION['form_submitted'])) {
        $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
    }

    // Clear the form submission flag when displaying the form again
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        unset($_SESSION['form_submitted']);
        $message = '';
    }

    mysqli_close($con);
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="addCustomer.css">
        <title>Add Customer</title>
    </head>
    <body>

        <div class="header">
            <div class="logo">
                <a href="../../../menu.html"><img src="../../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <div class="page_name">
                <p class="page">ADD CUSTOMER FORM</p>
            </div>

            <div class="links" id="links">
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
                <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <form method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <label for="surname">SURNAME</label>
                <input type="text" id="surname" name="surname" pattern="[A-Za-z. ]+" required>
            </div>

            <div class="form_line">
                <label for="firstname">FIRSTNAME</label>
                <input type="text" id="firstname" name="firstname" pattern="[A-Za-z. ]+" required>
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
