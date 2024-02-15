<html>
    <head>
        <link rel="stylesheet" href="addStockItem.css">
    </head>
    <body>

        <?php
            include '../../../db.inc.php'; // Including the database configuration file

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
            $quantityInStock = $_POST['quantityInStock'];

            $sql = "INSERT INTO Stock (StockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, supplierID, supplierStockCode, quantityInStock) VALUES ('$newStockID', '$description', '$costPrice', '$retailPrice', '$reorderLevel', '$reorderQuantity', '$supplierID', '$supplierStockCode', '$quantityInStock')";

            if (!mysqli_query($con, $sql)) {
                die("An Error in the SQL Query: " . mysqli_error($con)); // Displaying error message if query execution fails
            }

            $stockID = mysqli_insert_id($con);

            mysqli_close($con);
        ?>

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

        <div class="added">
            <p style="margin-bottom: 40px;" >A NEW STOCK ITEM HAS BEEN ADDED</p>
            <p style="margin-top: 0; margin-bottom: 200px;" >ID: <?php echo $newStockID ?></p>
            <a class="goback" href="addStockItem.php">GO BACK</a>
        </div>

        <script src="addStockItem.js"></script>
    </body>
</html>


