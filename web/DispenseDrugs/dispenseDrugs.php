<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="dispenseDrugs.css">
        <title>Delete Stock Item</title>
    </head>
    <body>

        <div class="header">
            <div class="logo">
                <a href="../menu.html"><img src="../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <div class="page_name">
                <p class="page">DISPENSE DRUGS</p>
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
                    <a href="../FileMaintenanceMenu/fileMaintenanceMenu.html" style="margin: 0; color: white; font-size: 30px;">FILE MAINTENANCE MENU</a>
                </div>

                <div class="link" style="top: 50px; left: 820px">
                    <a style="margin: 0; color: white; font-size: 30px;">REPORTS MENU</a>
                </div>
            </div>

            <div class="logout">
                <a href="../logIn.html"><img src="../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <form action="dispensedDrugs.php" method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <label for="customerDescription">SELECT CUSTOMER</label>
                <select name="customerDescription" id="customerDescription" onclick="populate()" required>
                    <option value="">Select a customer</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary

                    $sql = "SELECT customerID, customerName, address, dateOfBirth 
                        FROM customer 
                        WHERE customer.isDeleted = 0
                        ORDER BY customerName ASC";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['customerID'].'" data-details="'.$details.'">'.$row['customerName'].'</option>';
                        }
                    } else {
                        echo '<option value="">Failed to load stock items</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="customerID">CUSTOMER ID</label>
                <input type="number" id="customerID" name="customerID" pattern="[0-9]+" required disabled>
            </div>

            <div class="form_line">
                <label for="customerName">CUSTOMER NAME</label>
                <input type="text" id="customerName" name="customerName" pattern="[A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
                <label for="address">ADDRESS</label>
                <input type="text" id="address" name="address" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
            <label for="dateOfBirth">DATE OF BIRTH</label>
                <input type="text" id="dateOfBirth" name="dateOfBirth" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>

            <div class="form_line">
                <span></span>
                <input type="submit" value="DELETE" id="deleteButton"/>
            </div>
        </form>

        <script src="dispenseDrugs.js"></script>
    </body>
</html>