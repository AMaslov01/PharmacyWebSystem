<?php
    session_start(); // Start the session
    include '../../../db.inc.php';

    // Check if the reset action is requested
    if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
        unset($_SESSION['form_submitted']);
        // Redirect to the same page without the query parameter to avoid accidental resets on refresh
        header('Location: deleteStockItem.php');
        exit;
    }

    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        $sql = "UPDATE stock SET isDeleted = '1' WHERE stockID = '{$_POST['stockItemDescription']}'";

        if (mysqli_query($con, $sql)) {
            if (mysqli_affected_rows($con) > 0) {
                $message = "RECORD DELETED SUCCESSFULLY. ID: ".$_POST['stockItemDescription'];
            } else {
                $message = "NO CHANGES WERE MADE TO THE RECORD. ID: ".$_POST['stockItemDescription'];
            }
        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
    } elseif (isset($_SESSION['form_submitted'])) {
        $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        unset($_SESSION['form_submitted']);
        $message = '';
    }

    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="deleteStockItem.css">
        <title>Delete Stock Item</title>
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
                <p class="page">DELETE STOCK ITEM</p>
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
                <label for="stockItemDescription">SELECT STOCK ITEM</label>
                <select name="stockItemDescription" id="stockItemDescription" onclick="populate()" required>
                    <option value="">Select a stock item</option>
                    <?php
                    include '../../../db.inc.php'; // Adjust the path as necessary

                    $sql = "SELECT stock.stockID, description, quantityInStock, costPrice, supplierName
                        FROM stock 
                        JOIN supplier ON stock.supplierID = supplier.supplierID 
                        WHERE stock.isDeleted = 0
                        ORDER BY description ASC";

                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Query the order_to_stock table for each stock item
                            $stockID = $row['stockID'];
                            $orderSql = "SELECT COUNT(*) AS orderCount FROM order_to_stock WHERE stockID = '{$stockID}'";
                            $orderResult = mysqli_query($con, $orderSql);
                            $orderRow = mysqli_fetch_assoc($orderResult);
                            $orderCount = $orderRow['orderCount'];

                            // Append the orderCount to the row details
                            $row['orderCount'] = $orderCount;

                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['stockID'].'" data-details="'.$details.'">'.$row['description'].'</option>';
                        }
                    } else {
                        echo '<option value="">Failed to load stock items</option>';
                    }

                    mysqli_close($con);
                    ?>

                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="stockID">STOCK ID</label>
                <input type="number" id="stockID" name="stockID" pattern="[0-9]+" required disabled>
            </div>

            <div class="form_line">
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
                <label for="quantityInStock">QUANTITY IN STOCK</label>
                <input type="number" id="quantityInStock" name="quantityInStock" min="0" required disabled>
            </div>

            <div class="form_line">
            <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="0.01" step=".01" required disabled>
            </div>

            <div class="form_line">
                <label for="supplierName">SUPPLIER NAME</label>
                <input type="text" id="supplierName" name="supplierName" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
                <span></span>
                <input type="submit" value="DELETE" id="deleteButton"/>
            </div>

            <!-- The purpose of the okButton is to basically reload the page without resubmitting the form. This is achieved by sending a specific query parameter when the "OK" button is clicked, which the PHP script checks for at the beginning of the page load to reset the session and message, which make it possible for further successful amending -->
            <div class="form_line">
                <div class="deleted" id="deleted">
                    <br><br><br>
                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                        <!-- OK button to reset the message -->
                        <div class="okButton"><a href="deleteStockItem.php?action=resetMessage" class="okText">OK</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <script src="deleteStockItem.js"></script>
    </body>
</html>