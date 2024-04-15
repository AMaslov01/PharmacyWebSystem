<!--
// Author			: Nebojsa Kukic
// Date				: 04/2024
// Purpose			: A payment to suppliers form
//					: This is the php and html	
-->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../db.inc.php'; // Include your database connection file

$message = ""; // Initialize message variable

// Place the PHP script logic here that handles form submission from below
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Your PHP code to handle the form submission and update the supplier amount owed
    // Make sure you use prepared statements for database interactions
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="paymentToSuppliers.css">
	
    <title>PAYMENT TO SUPPLIERS</title>
</head>
    <body>

		

        <div class="header">
            <div class="logo">
                <a href="../../menu.html"><img src="../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <div class="page_name">
                <p class="page">PAYMENT TO SUPPLIERS</p>
            </div>

            <div class="links" id="links">
                <div class="link" style="top: 5px; left: 0;">
                    <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
                </div>

                <div class="link" style="top: 50px; left: 0;">
                    <a href="../../DispenseDrugs/dispenseDrugs.php" style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
                </div>

                <div class="link" style="top: 0; left: 350px">
                    <a style="margin: 0; color: white; font-size: 30px;">STOCK CONTROL MENU</a>
                </div>

                <div class="link" style="top: 50px; left: 350px">
                    <a href="../supplierAccountsMenu.html"style="margin: 0; color: white; font-size: 30px;">SUPPLIER ACCOUNTS MENU</a>
                </div>

                <div class="link" style="top: 0; left: 820px">
                    <a href="../../FileMaintenanceMenu/fileMaintenanceMenu.html" style="margin: 0; color: white; font-size: 30px;">FILE MAINTENANCE MENU</a>
                </div>

                <div class="link" style="top: 50px; left: 820px">
                    <a style="margin: 0; color: white; font-size: 30px;" href="../../ReportsMenu/reportsMenu.html">REPORTS MENU</a>
                </div>
            </div>

            <div class="logout">
                <a href="../../logIn.html"><img src="../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>
<br><br><br><br><br><br><br><br>




<form action="paymentToSuppliers.php" method="post">
        <div class="form_line">
            <label for="supplierID">Select Supplier:</label>
            <select name="supplierID" id="supplierID" required>
                <option value="">Select a Supplier</option>
                <?php
                // Fetch all suppliers that are not deleted and display them in the dropdown
                $sql = "SELECT supplierID, supplierName FROM supplier WHERE isDeleted = 0 ORDER BY supplierName ASC";
                $result = mysqli_query($con, $sql);
                
                if($result && mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.htmlspecialchars($row['supplierID']).'">'.htmlspecialchars($row['supplierName']).'</option>';
                    }
                } else {
                    echo '<option value="">No suppliers available</option>';
                }
                ?>
            </select>
        </div>

        <div class="form_line">
            <label for="paymentAmount">Payment Amount:</label>
            <input type="number" name="paymentAmount" id="paymentAmount" min="0.01" step="0.01" required>
        </div>

        <div class="form_line">
            <input type="submit" value="Process Payment">
        </div>
    </form>

    <!-- Display message -->
    <div class="form_line">
                <div>
                    <br><br><br>
					
                    <label><?php if (!empty($message)) : ?>
                            <p><?php echo $message; ?></p>
                            <!-- OK button to reset the message -->
                            <div class="okButton"><a href="paymentToSupplier.php.php?action=resetMessage" class="okText">OK</a></div>
                        <?php endif; ?>
                    </label>
                </div>
            </div>

        
       
        


        <script src="paymentToSuppliers.js"></script>
    </body>
</html>