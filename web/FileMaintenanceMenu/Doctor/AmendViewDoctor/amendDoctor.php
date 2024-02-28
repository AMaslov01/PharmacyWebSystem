<html>
<head>
    <link rel="stylesheet" href="amendViewDoctor.css">
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
        <p class="page">AMENDED DOCTOR</p>
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

<div class="amended">
    <p style="margin-bottom: 40px;">
        <?php
        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";

        include '../../../db.inc.php'; // Adjust the path as necessary

        $sql = "UPDATE Doctor SET   
                    doctorSurname = '{$_POST['surname']}',
                    doctorFirtsname = '{$_POST['firstName']}',
                    surgeryAddress = '{$_POST['surgeryAddress']}',
                    surgeryEircode = '{$_POST['surgeryEircode']}',
                    surgeryTelephoneNumber = '{$_POST['surgeryTelephoneNumber']}',
                    mobileTelephoneNumber = '{$_POST['mobileTelephoneNumber']}',
                    homeAddress = '{$_POST['homeAddress']}',
                    homeEircode = '{$_POST['homeEircode']}',
                    homeTelephoneNumber = '{$_POST['homeTelephoneNumber']}', 
                    WHERE doctorID = '{$_POST['doctorDescription']}'";

        if (!mysqli_query($con, $sql)) {
            die("An Error in the SQL Query: " . mysqli_error($con)); // Displaying error message if query execution fails
        } else {
            if(mysqli_affected_rows($con) != 0){
                echo $_POST['doctorSurname']." RECORD UPDATED SUCCESSFULLY<br>";
                echo "DOCTOR ID: ".$_POST['surname'];
            } else {
                echo "NO RECORDS WERE CHANGED";
            }
        }

        mysqli_close($con);
        ?>
    </p>
    <a class="goback" href="amendViewDoctor.php">GO BACK</a>

</div>

<script src="amendViewDoctor.js"></script>
</body>
</html>
