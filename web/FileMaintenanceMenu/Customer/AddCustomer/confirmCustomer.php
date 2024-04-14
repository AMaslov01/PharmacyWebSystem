<!--
    NAME:           ABDULLAH JOBBEH
    DESCRIPTION:    ADD CUSTOMER FILE FOR ADDING CUSTOMER TO DATABASE  
    DATE:           1/4/2024
    STUDENTID:      C00284285
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Ensures proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Customer</title>
    <!-- Link to external CSS for styling -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
// Start the session to access session variables
session_start();
// Include database connection settings
include '../../../db.inc.php';

// Check if there's a customer ID in the query string
if (isset($_GET['customerID'])) {
    $customerID = $_GET['customerID'];

    // Fetch customer details from the database
    $sql = "SELECT * FROM Customer WHERE customerID = '$customerID'";
    $result = mysqli_query($con, $sql);
    
    // Fetch the customer data if available and display it
    if ($row = mysqli_fetch_assoc($result)) {
        // Display a header and customer details
        echo "<h2>Confirmation</h2>";
        echo "<p>Customer ID: " . $row['customerID'] . "</p>";
        echo "<p>Name: " . $row['customerName'] . " " . $row['customerSurname'] . "</p>";
        // Additional details can be displayed here
    } else {
        // Display an error message if no customer found
        echo "<p>Customer not found.</p>";
    }
} else {
    // Display an error message if no customer ID is provided in the query string
    echo "<p>No customer ID provided.</p>";
}

// Close the database connection
mysqli_close($con);
?>
<!-- Create a form with a confirmation button -->
<form action="addCustomer.php" method="post">
    <div class="okButton">
        <!-- Link to reset the form processing state and redirect to addCustomer page -->
        <a href="addCustomer.php?action=resetMessage" class="okText">Confirm</a>
    </div>
</form>

</body>
</html>
