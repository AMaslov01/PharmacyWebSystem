<?php   // The idea is to use session variable to prevent users from resubmitting the form over and over again on page reload.
        // This is achieved by setting a session variable on form submission and the checking if it is set.
    session_start(); // Start the session
    include '../../../db.inc.php';
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        // Fetch the highest current StockID
        $sql = "SELECT MAX(StockID) AS MaxStockID FROM Stock";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxStockID = $row['MaxStockID'];

        // Increment the StockID by 1 for the new record
        $newStockID = $maxStockID + 1;

        $supplierID = $_POST['supplierName'];
        $description = $_POST['description'];
        $costPrice = $_POST['costPrice'];
        $retailPrice = $_POST['retailPrice'];
        $reorderLevel = $_POST['reorderLevel'];
        $reorderQuantity = $_POST['reorderQuantity'];
        $supplierStockCode = $_POST['supplierStockCode'];

        $sql = "INSERT INTO Stock (StockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, supplierID, supplierStockCode, quantityInStock) VALUES ('$newStockID', '$description', '$costPrice', '$retailPrice', '$reorderLevel', '$reorderQuantity', '$supplierID', '$supplierStockCode', 0)";

        if (mysqli_query($con, $sql)) {
            $message = "A NEW STOCK ITEM HAS BEEN ADDED. ID: $maxStockID";
        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $stockID = mysqli_insert_id($con);

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
        <link rel="stylesheet" href="addStockItem.css">
        <title>Add Stock Item</title>
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
                <p class="page">ADD STOCK ITEM FORM</p>
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
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="0.01" step=".01" required>
            </div>

            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="0.01" step=".01" required>
            </div>

            <div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" min="0" required>
            </div>

            <div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" min="1" required>
            </div>

            <div class="form_line">
                <label for="supplierName">SUPPLIER NAME</label>
                <select name="supplierName" id="supplierName" required>
                    <option value="">Select a supplier</option>

                    <?php
                    include '../../../db.inc.php';

                    $sql = "SELECT supplierID, supplierName FROM supplier ORDER BY supplierName ASC";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row['supplierID'].'">'.$row['supplierName'].'</option>';
                        }
                    } else {
                        echo '<option value="">Failed to load suppliers</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form_line">
                <label for="supplierStockCode">SUPPLIER STOCK CODE</label>
                <input type="text" id="supplierStockCode" name="supplierStockCode" pattern="[0-9A-Za-z]+" required>
            </div>

            <div class="form_line">
                <input type="reset" value="CLEAR" name="reset"/>
                <input type="submit" value="ADD" name="submit"/>
            </div>

            <div class="form_line">
                <div class="added" id="added">
                    <br><br><br>
                    <label><?php if (!empty($message)) echo "<p>$message</p>"; ?></label>
                </div>
            </div>

        </form>

        <script src="addStockItem.js"></script>
    </body>
</html>