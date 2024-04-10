<!--
    View/Amend Stock Item
    Viewing and Amending a stock item
    C00290930 Evgenii Salnikov 04.2024
-->
<?php
session_start(); // Start the session
include '../../../db.inc.php';

// Check if the reset action is requested
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    unset($_SESSION['form_submitted']);
    // Redirect to the same page without the query parameter to avoid accidental resets on refresh
    header('Location: amendViewStockItem.php');
    exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Prepare the UPDATE SQL statement
    $sql = "UPDATE stock SET 
            description = '{$_POST['description']}',  
            costPrice = '{$_POST['costPrice']}', 
            retailPrice = '{$_POST['retailPrice']}', 
            reorderLevel = '{$_POST['reorderLevel']}', 
            reorderQuantity = '{$_POST['reorderQuantity']}', 
            quantityInStock = '{$_POST['quantityInStock']}',
            supplierID = '{$_POST['supplierName']}'
            WHERE stockID = '{$_POST['stockItemDescription']}'";

    // Create query and set the message
    if (mysqli_query($con, $sql)) {
        if (mysqli_affected_rows($con) > 0) {
            $message = "RECORD UPDATED SUCCESSFULLY. ID: ".$_POST['stockItemDescription'];
        } else {
            $message = "NO CHANGES WERE MADE TO THE RECORD. ID: ".$_POST['stockItemDescription'];
        }
    } else {
        $message = "An Error in the SQL Query: " . mysqli_error($con);
    }

    // Set a session variable to indicate form submission
    $_SESSION['form_submitted'] = true;
} elseif (isset($_SESSION['form_submitted'])) {
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
}

// If reached the page, without posting the form
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    $message = '';
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Link to external css -->
        <link rel="stylesheet" href="amendViewStockItem.css">
        <title>View/Amend Stock Item</title>
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
                <p class="page">VIEW/AMEND STOCK ITEM</p>
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
                <!-- Automatically populated dropdown list of all not-deleted stock items -->
                <label for="stockItemDescription">SELECT DESCRIPTION</label>
                <!-- populate() function is called, when stock item is clicked on (selected) -->
                <select name="stockItemDescription" id="stockItemDescription" onclick="populate()" required>
                    <option value="">Select a stock item</option>
                    <?php
                    include '../../../db.inc.php';

                    // Prepare sql SELECT statement for stock items
                    $sql = "SELECT stockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, quantityInStock, supplierName 
                        FROM stock 
                        JOIN supplier ON stock.supplierID = supplier.supplierID 
                        WHERE stock.isDeleted = 0
                        ORDER BY description ASC";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    // Save supplier ID
                    global $supplierID;

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['stockID'].'" data-details="'.$details.'">'.$row['description'].'</option>';
                            //$supplierID = $row['supplierID'];
                        }
                    } else {
                        // Display error message
                        echo '<option value="">Failed to load stock items</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- View/Amend button -->
            <input type="button" value="AMEND" id="amendViewButton" onclick="toggleLock()">

            <!-- Form field for Stock ID -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="stockID">STOCK ID</label>
                <input type="number" id="stockID" name="stockID" pattern="[0-9]+" required disabled>
            </div>

            <!-- Form field for description -->
            <div class="form_line">
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <!-- Form field for cost price -->
            <div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="0.01" step=".01" required disabled>
            </div>

            <!-- Form field for retail price -->
            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="0.01" step=".01" required disabled>
            </div>

            <!-- Form field for reorder level -->
            <div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" min="0" required disabled>
            </div>

            <!-- Form field for reorder quantity -->
            <div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" min="1" required disabled>
            </div>

            <!-- Form field for quantity in stock -->
            <div class="form_line">
                <label for="quantityInStock">QUANTITY IN STOCK</label>
                <input type="number" id="quantityInStock" name="quantityInStock" min="0" required disabled>
            </div>

            <!-- First supplier name form field, that is displayed when in View mode -->
            <div class="supplierDiv1" id="supplierDiv1">
                <div class="form_line">
                    <label for="supplierName">SUPPLIER NAME</label>
                    <input type="text" id="supplierName" name="supplierName" pattern="[0-9A-Za-z., ]+" onclick="changeSelect()" required disabled>
                </div>
            </div>

            <!-- Second supplier name form field, that is displayed when in Amend mode -->
            <div class="supplierDiv2" style="display: none;" id="supplierDiv2">
                <div class="form_line">
                    <label for="supplierName">SUPPLIER NAME</label>
                    <!-- Automatically populated with suppliers dropdown -->
                    <select name="supplierName" id="supplierName" required>
                        <option id="preselectedSupplier" value="">Select a supplier</option>
                        <?php
                        include '../../../db.inc.php';

                        // Prepare sql SELECT statement for fetching suppliers
                        $sql = "SELECT supplierID, supplierName FROM supplier ORDER BY supplierName ASC";
                        if (!empty($con)) {
                            // Execute query
                            $result = mysqli_query($con, $sql);
                        }

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Does not preselect, can use just echo from else
                                if ($row['supplierID'] == $supplierID) {
                                    // Populate dropdown with selected supplier
                                    echo '<option value="'.$row['supplierID'].'" selected>'.$row['supplierName'].'</option>';
                                } else {
                                    echo '<option value="'.$row['supplierID'].'">'.$row['supplierName'].'</option>';
                                }
                            }
                        } else {
                            // Display error message
                            echo '<option value="">Failed to load suppliers</option>';
                        }

                        mysqli_close($con);
                        ?>
                    </select>
                </div>
            </div>

            <!-- Save button -->
            <div class="form_line">
                <span></span>
                <input type="submit" value="SAVE" name="submit"/>
            </div>

            <!-- The purpose of the okButton is to basically reload the page without resubmitting the form. This is achieved by sending a specific query parameter when the "OK" button is clicked, which the PHP script checks for at the beginning of the page load to reset the session and message, which make it possible for further successful amending -->
            <div class="form_line">
                <div class="amended" id="amended">
                    <br><br><br>
                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                        <!-- OK button to reset the message -->
                        <div class="okButton"><a href="amendViewStockItem.php?action=resetMessage" class="okText">OK</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- Link to external JS -->
        <script src="amendViewStockItem.js"></script>
    </body>
</html>