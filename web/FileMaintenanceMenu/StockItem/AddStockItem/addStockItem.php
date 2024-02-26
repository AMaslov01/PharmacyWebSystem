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

        <form action="addedStockItem.php" method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <label for="description">DESCRIPTION</label>
                <input type="text" id="description" name="description" pattern="[0-9A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="1"  required>
            </div>

            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="1" required>
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
                    include '../../../db.inc.php'; // Adjust the path as necessary

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
                <input type="number" id="supplierStockCode" name="supplierStockCode" required>
            </div>

            <div class="form_line">
                <label for="quantityInStock">QUANTITY IN STOCK</label>
                <input type="number" id="quantityInStock" name="quantityInStock" min="0" required>
            </div>

            <div class="form_line">
                <input type="reset" value="CLEAR" name="reset"/>
                <input type="submit" value="ADD" name="submit"/>
            </div>

        </form>


        <script src="addStockItem.js"></script>
    </body>
</html>