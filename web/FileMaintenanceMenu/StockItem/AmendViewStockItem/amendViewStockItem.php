<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="amendViewStockItem.css">
        <title>View/Amend Stock Item</title>
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
                <p class="page">VIEW/AMEND STOCK ITEM</p>
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

        <form action="amendStockItem.php" method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <label for="stockItemDescription">SELECT STOCK ITEM</label>
                <select name="stockItemDescription" id="stockItemDescription" onclick="populate()" required>
                    <option value="">Select a stock item</option>
                    <?php
                    include '../../../db.inc.php'; // Adjust the path as necessary

                    $sql = "SELECT stockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, quantityInStock, supplierName 
                        FROM stock 
                        JOIN supplier ON stock.supplierID = supplier.supplierID 
                        WHERE stock.isDeleted = 0
                        ORDER BY description ASC";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
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

            <input type="button" value="AMEND" id="amendViewButton" onclick="toggleLock()">

            <div class="form_line" style="margin-top: 30px;">
                <label for="stockID">STOCK ID</label>
                <input type="number" id="stockID" name="stockID" pattern="[0-9]+" required disabled>
            </div>

            <div class="form_line">
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
            <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="1" required disabled>
            </div>

            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="1" required disabled>
            </div>

            <div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" min="0" required disabled>
            </div>

            <div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" min="1" required disabled>
            </div>

            <div class="form_line">
                <label for="quantityInStock">QUANTITY IN STOCK</label>
                <input type="number" id="quantityInStock" name="quantityInStock" min="0" required disabled>
            </div>

            <div class="form_line">
                <label for="supplierName">SUPPLIER NAME</label>
                <input type="text" id="supplierName" name="supplierName" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
                <input type="reset" value="CLEAR" name="reset"/>
                <input type="submit" value="SAVE" name="submit"/>
            </div>
        </form>

        <script src="amendViewStockItem.js"></script>
    </body>
</html>