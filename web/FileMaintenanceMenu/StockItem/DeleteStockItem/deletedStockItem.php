<html>
    <head>
        <link rel="stylesheet" href="deleteStockItem.css">
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
                <p class="page">DELETED STOCK ITEM</p>
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

        <div class="deleted">
            <p style="margin-bottom: 40px;">
                <?php
                include '../../../db.inc.php'; // Adjust the path as necessary

                $sql = "UPDATE stock SET isDeleted = '1' WHERE stockID = '{$_POST['stockItemDescription']}'";

                if(mysqli_query($con, $sql)) {
                    echo "STOCK ID: ".$_POST['stockItemDescription']."<br>RECORD DELETED SUCCESSFULLY";
                } else {
                    die("An Error in the SQL Query: " . mysqli_error($con));
                }

                mysqli_close($con);
                ?>
            </p>
            <a class="goback" href="deleteStockItem.php">GO BACK</a>

        </div>

        <script src="deleteStockItem.js"></script>
    </body>
</html>