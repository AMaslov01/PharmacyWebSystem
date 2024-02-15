<html>
    <head>
        <link rel="stylesheet" href="amendViewStockItem.css">
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

        <div class="amended">
            <p style="margin-bottom: 40px;">
                <?php
                //echo "<pre>";
                //print_r($_POST);
                //echo "</pre>";

                include '../../../db.inc.php'; // Adjust the path as necessary

                $sql = "UPDATE stock SET 
                    description = '{$_POST['description']}',  
                    costPrice = '{$_POST['costPrice']}', 
                    retailPrice = '{$_POST['retailPrice']}', 
                    reorderLevel = '{$_POST['reorderLevel']}', 
                    reorderQuantity = '{$_POST['reorderQuantity']}', 
                    quantityInStock = '{$_POST['quantityInStock']}' 
                    WHERE stockID = '{$_POST['stockItemDescription']}'";

                if (!mysqli_query($con, $sql)) {
                    die("An Error in the SQL Query: " . mysqli_error($con)); // Displaying error message if query execution fails
                } else {
                    if(mysqli_affected_rows($con) != 0){
                        echo $_POST['description']." RECORD UPDATED SUCCESSFULLY<br>";
                        echo "STOCK ID: ".$_POST['stockItemDescription'];
                    } else {
                        echo "NO RECORDS WERE CHANGED";
                    }
                }
                $stockID = mysqli_insert_id($con);
                mysqli_close($con);
                ?>
            </p>
            <a class="goback" href="amendViewStockItem.php">GO BACK</a>

        </div>

        <script src="amendViewStockItem.js"></script>
    </body>
</html>