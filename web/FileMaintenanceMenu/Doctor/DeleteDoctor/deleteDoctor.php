<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="deleteDoctor.css">
    <title>Delete Doctor</title>
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
        <p class="page">DELETE DOCTOR</p>
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
            <a style="margin: 0; color: white; font-size: 30px;" href="/PharmacyWebSystem/web/ReportsMenu/reportsMenu.html">REPORTS MENU</a>
        </div>
    </div>

    <div class="logout">
        <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
    </div>
</div>

<form action="deletedDoctor.php" method="post" onsubmit="return validateForm()">
    <div class="form_line">
        <label for="doctorDescription">SELECT DOCTOR</label>
        <select name="doctorDescription" id="doctorDescription" onclick="populate()" required>
            <option value="">Select a doctor</option>
            <?php
            include '../../../db.inc.php'; // Adjust the path as necessary

            $sql = "SELECT doctorID, doctorSurname, doctorFirstname, surgeryAddress,
                        surgeryEircode, surgeryTelephoneNumber,
                        mobileTelephoneNumber, homeAddress, 
                        homeEircode, homeTelephoneNumber FROM Doctor 
                        WHERE Doctor.isDeleted = 0
                        ORDER BY doctorSurname ASC";
            if (!empty($con)) {
                $result = mysqli_query($con, $sql);
            }

            // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Combine all relevant details with a delimiter (comma)
                    $details = implode(',', $row);
                    echo '<option value="'.$row['doctorID'].'" data-details="'.$details.'">'.$row['doctorSurname'].'</option>';
                }
            } else {
                echo '<option value="">Failed to load doctors</option>';
            }

            mysqli_close($con);
            ?>
        </select>
    </div>

    <div class="form_line">
        <label for="surname">SURNAME</label>
        <input type="text" id="surname" name="surname" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="firstName">FIRST NAME</label>
        <input type="text" id="firstName" name="firstName" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="surgeryAddress">SURGERY ADDRESS</label>
        <input type="text" id="surgeryAddress" name="surgeryAddress" pattern="[0-9A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="surgeryEircode">SURGERY EIRCODE</label>
        <input type="text" id="surgeryEircode" name="surgeryEircode" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
    </div>

    <div class="form_line">
        <label for="surgeryTelephoneNumber">SURGERY TELEPHONE NUMBER</label>
        <input type="text" id="surgeryTelephoneNumber" name="surgeryTelephoneNumber" pattern="^[\d\s()-]+$" required disabled>
    </div>

    <div class="form_line">
        <label for="mobileTelephoneNumber">MOBILE TELEPHONE NUMBER</label>
        <input type="text" id="mobileTelephoneNumber" name="mobileTelephoneNumber" pattern="^[\d\s()-]+$" required disabled>
    </div>

    <div class="form_line">
        <label for="homeAddress">HOME ADDRESS</label>
        <input type="text" id="homeAddress" name="homeAddress" pattern="[0-9A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="homeEircode">HOME EIRCODE</label>
        <input type="text" id="homeEircode" name="homeEircode" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
    </div>

    <div class="form_line">
        <label for="homeTelephoneNumber">HOME TELEPHONE NUMBER</label>
        <input type="text" id="homeTelephoneNumber" name="homeTelephoneNumber" pattern="^[\d\s()-]+$" required disabled>
    </div>

    <div class="form_line">
        <span></span>
        <input type="submit" value="DELETE" id="deleteButton"/>
    </div>
</form>

<script src="deleteDoctor.js"></script>
</body>
</html>
