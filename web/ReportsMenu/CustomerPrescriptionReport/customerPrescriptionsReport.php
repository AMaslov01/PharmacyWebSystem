<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="customerPrescriptionsReport.css">
    <title>Customer Prescriptions Report</title>

</head>
<body>

<div class="header">
    <div class="logo">
        <a href="../../menu.html"><img src="/PharmacyWebSystem/web/Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
    </div>

    <div class="menu_button" id="menu_button">
        <p class="menu">MENU</p>
    </div>

    <div class="page_name">
        <p class="page">CUSTOMER PRESCRIPTIONS REPORT</p>
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
            <a style="margin: 0; color: white; font-size: 30px;" href="../reportsMenu.html">REPORTS MENU</a>
        </div>
    </div>

    <div class="logout">
        <a href="/PharmacyWebSystem/web/logIn.html"><img src="/PharmacyWebSystem/web/Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
    </div>
</div>

<form>
    <div class="form_line">
        <label for="customerDescription">SELECT CUSTOMER</label>
        <select name="customerDescription" id="customerDescription" onchange="enableDiv()" >
            <option value="default">Select a customer</option>
           <?php
            $hostname = "localhost:3306";
            //  $username = "healthfirst";
            $username = "root"; // username for local db
            // $password = "bsw81@6M1";
            $password = ""; // password for local db

            $dbname = "PharmacyWebSystem";

            $con = mysqli_connect($hostname, $username, $password, $dbname) or die ("Failed to connect to MySQL: ".mysqli_connect_error());
            $sql = "SELECT doctorID, doctorSurname, doctorFirstname, surgeryAddress,
                        surgeryEircode, surgeryTelephoneNumber,
                        mobileTelephoneNumber, homeAddress, 
                        homeEircode, homeTelephoneNumber FROM Doctor 
                        WHERE Doctor.isDeleted = 0
                        ORDER BY doctorSurname ASC";

            if (!empty($con)) {
                $result = mysqli_query($con, $sql);
            }
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Combine all relevant details with a delimiter (comma)
                    $details = implode(',', $row);
                    echo '<option value="'.$row['doctorID'].'" data-details="'.$details.'">'.$row['doctorSurname'].'</option>';
                }
            } else {
                echo '<option value="">Failed to load customers</option>';
            }
            mysqli_close($con);
            ?>
        </select>
    </div>
    <div class="form_line"  >
        <label for="datesDescription" style="display: none;" id="datesLabel">SELECT DATE</label>
        <select name="datesDescription" id="datesDescription" style="display: none;">
            <option value="">Select a date</option>
        </select>
    </div>



</form>

<script src="customerPrescriptionsReport.js"></script>
</body>
</html>