<!--
    Add Stock Item
    Adding a new stock item
    C00290930 Evgenii Salnikov 04.2024
-->
<?php
session_start(); // Start the session
include '../../../db.inc.php'; // Include the database connection file

// Check if the reset action is requested
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    unset($_SESSION['form_submitted']); // Unset the form_submitted session variable
    // Redirect to the same page without the query parameter to avoid accidental resets on refresh
    header('Location: addStockItem.php');
    exit; // Terminate script execution
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Initialize message variable with session message or empty string

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Fetch the highest current StockID
    $sql = "SELECT MAX(StockID) AS MaxStockID FROM Stock";
    $result = mysqli_query($con, $sql); // Execute the query
    $row = mysqli_fetch_assoc($result); // Fetch the result row
    $maxStockID = $row['MaxStockID']; // Get the highest StockID

    // Increment the StockID by 1 for the new record
    $newStockID = $maxStockID + 1;

    // Retrieve form values
    $supplierID = $_POST['supplierName'];
    $description = $_POST['description'];
    $costPrice = $_POST['costPrice'];
    $retailPrice = $_POST['retailPrice'];
    $reorderLevel = $_POST['reorderLevel'];
    $reorderQuantity = $_POST['reorderQuantity'];
    $supplierStockCode = $_POST['supplierStockCode'];

    // Prepare the INSERT SQL statement
    $sql = "INSERT INTO Stock (StockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, supplierID, supplierStockCode, quantityInStock) VALUES ('$newStockID', '$description', '$costPrice', '$retailPrice', '$reorderLevel', '$reorderQuantity', '$supplierID', '$supplierStockCode', 0)";

    // Execute the INSERT query
    if (mysqli_query($con, $sql)) {
        $message = "A NEW STOCK ITEM HAS BEEN ADDED. ID: $newStockID"; // Success message
    } else {
        $message = "An Error in the SQL Query: " . mysqli_error($con); // Error message
    }

    $stockID = mysqli_insert_id($con); // Get the last inserted ID

    $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
} elseif (isset($_SESSION['form_submitted'])) {
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
}

// Clear the form submission flag when displaying the form again
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    $message = ''; // Reset the message
}

mysqli_close($con); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Link to external css -->
        <link rel="stylesheet" href="addStockItem.css">
        <title>Add Stock Item</title>
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
                <p class="page">ADD STOCK ITEM</p>
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
            <!-- Form field for description -->
            <div class="form_line">
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required>
            </div>

            <!-- Form field for cost price -->
            <div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="0.01" step=".01" required>
            </div>

            <!-- Form field for retail price -->
            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="0.01" step=".01" required>
            </div>

            <!-- Form field for reorder level -->
            <div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" min="0" required>
            </div>

            <!-- Form field for reorder quantity -->
            <div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" min="1" required>
            </div>

            <!-- Form field for the supplier name -->
            <div class="form_line">
                <label for="supplierName">SUPPLIER NAME</label>
                <select name="supplierName" id="supplierName" required>
                    <option value="">Select a supplier</option>

                    <?php
                    include '../../../db.inc.php';

                    // Preparing the sql statement
                    $sql = "SELECT supplierID, supplierName FROM supplier ORDER BY supplierName ASC";
                    if (!empty($con)) {
                        // Execute the query
                        $result = mysqli_query($con, $sql);
                    }

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Populate the select tag with fetched data
                            echo '<option value="'.$row['supplierID'].'">'.$row['supplierName'].'</option>';
                        }
                    } else {
                        // In case of an error, display the error message
                        echo '<option value="">Failed to load suppliers</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- Supplier stock code input field -->
            <div class="form_line">
                <label for="supplierStockCode">SUPPLIER STOCK CODE</label>
                <input type="text" id="supplierStockCode" name="supplierStockCode" pattern="[0-9A-Za-z]+" required>
            </div>

            <!-- CLEAR and ADD buttons -->
            <div class="form_line">
                <input type="reset" value="CLEAR" name="reset"/>
                <input type="submit" value="ADD" name="submit"/>
            </div>

            <!-- Appearing OK button to reload the page without sending the form -->
            <div class="form_line">
                <div class="added" id="added">
                    <br><br><br>
                    <label><?php if (!empty($message)) : ?>
                            <p><?php echo $message; ?></p>
                            <!-- OK button to reset the message -->
                            <div class="okButton"><a href="addStockItem.php?action=resetMessage" class="okText">OK</a></div>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
        </form>
        <!-- Link to external JavaScript file -->
        <script src="addStockItem.js"></script>
    </body>
</html>