<!--
    Customer Prescription Report
    Adding Customer Prescription Report
    C00290945 Artemiy Maslov 03.2024
-->
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
            <a href="../../FileMaintenanceMenu/fileMaintenanceMenu.html" style="margin: 0; color: white; font-size: 30px;">FILE MAINTENANCE MENU</a>
        </div>

        <div class="link" style="top: 50px; left: 820px">
            <a style="margin: 0; color: white; font-size: 30px;" href="../reportsMenu.html">REPORTS MENU</a>
        </div>
    </div>

    <div class="logout">
        <a href="/PharmacyWebSystem/web/logIn.html"><img src="/PharmacyWebSystem/web/Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
    </div>
</div>

<form method="post" name="reportForm" id="reportForm" onsubmit="return checkDates()">

    <div class="form_line">
        <label for="customerDescription">SELECT CUSTOMER</label>
        <select name="customerDescription" id="customerDescription" onchange="enableDiv()" >
            <option value="default">Select a customer</option>
           <?php
           include '../../db.inc.php';
            $sql = "SELECT `customerID`, `customerSurname`, `customerName`, `address`, `eircode`, `dateOfBirth`, `telephoneNumber` FROM Customer 
                        WHERE Customer.isDeleted = 0
                        ORDER BY customerSurname ASC";

            if (!empty($con)) {
                $result = mysqli_query($con, $sql);
            }
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Combine all relevant details with a delimiter (comma)
                    $details = implode(',', $row);
                    echo '<option value="'.$row['customerID'].'" data-details="'.$details.'">'.$row['customerSurname'].'</option>';
                }
            } else {
                echo '<option value="">Failed to load customers</option>';
            }



            ?>
        </select>
    </div>
    <div class="form_line"  >
        <label for="startDatesDescription" style="display: none;" id="startDatesLabel">SELECT STARTING DATE</label>
        <input type="date" id="startDatesDescription" name="startDatesDescription" style="display: none;" required >
    </div>
    <div class="form_line"  >
        <label for="endDatesDescription" style="display: none;" id="endDatesLabel">SELECT ENDING DATE</label>
        <input type="date" id="endDatesDescription" name="endDatesDescription" style="display: none;"  required>
    </div>
    <div class="form_line">
        <input type="reset" value="CLEAR" name="reset">
        <input type="submit" value="SEARCH" name="submit">
    </div>

    <input type='hidden' name='choice' id="choice" value ="date">
        <?php

        session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        include '../../db.inc.php';

        // Check if the reset action is requested
        if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
            unset($_SESSION['form_submitted']); // Unset the session variable
            // Redirect to the same page without the query parameter to avoid accidental resets on refresh
            header('Location: customerPrescriptionsReport.php');
            exit; // Terminate script execution
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['customerDescription'] != "default") {
            session_destroy();
            session_start();
            // Construct SQL query to mark doctor as deleted based on provided doctor ID
            date_default_timezone_set("UTC");
            $_SESSION['date1'] = date("Y-m-d", strtotime($_POST['startDatesDescription']));
            $date1 = $_SESSION['date1'];

            $_SESSION['date2'] = date("Y-m-d", strtotime($_POST['endDatesDescription']));
            $date2 = $_SESSION['date2'];
            $_SESSION['customerID'] = $_POST['customerDescription'];
            $customerID = $_SESSION['customerID'];
            $_SESSION['sql1'] = "SELECT dateOfPrescription, prescriptionID, doctorSurname, totalCost FROM Prescription JOIN
            Doctor ON Doctor.doctorID = Prescription.doctorID JOIN Customer
            ON Customer.customerID = Prescription.customerID
            WHERE Prescription.customerID = '$customerID' AND
            dateOfPrescription BETWEEN '$date1' AND '$date2' ORDER BY dateOfPrescription";

            $_SESSION['sql2'] = "SELECT dateOfPrescription, prescriptionID, doctorSurname, totalCost FROM Prescription JOIN
            Doctor ON Doctor.doctorID = Prescription.doctorID JOIN Customer
            ON Customer.customerID = Prescription.customerID
            WHERE Prescription.customerID = '$customerID' AND
            dateOfPrescription BETWEEN '$date1' AND '$date2' ORDER BY doctorSurname";

            $_SESSION['sql3'] = "SELECT dateOfPrescription, prescriptionID, doctorSurname, totalCost FROM Prescription JOIN
            Doctor ON Doctor.doctorID = Prescription.doctorID JOIN Customer
            ON Customer.customerID = Prescription.customerID
            WHERE Prescription.customerID = '$customerID' AND
            dateOfPrescription BETWEEN '$date1' AND '$date2' ORDER BY totalCost";

            $_SESSION['sql'] = "SELECT dateOfPrescription, prescriptionID, doctorSurname, totalCost FROM Prescription JOIN
            Doctor ON Doctor.doctorID = Prescription.doctorID JOIN Customer
            ON Customer.customerID = Prescription.customerID
            WHERE Prescription.customerID = '$customerID' AND
            dateOfPrescription BETWEEN '$date1' AND '$date2' ORDER BY dateOfPrescription";
        }
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Retrieve message from session or set empty string

        // Check if the form is submitted via POST and form submission session variable is not set
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {

            $sql = $_SESSION['sql'];
            if (mysqli_query($con, $sql)) {
                // Check if any rows were affected by the query
                if (mysqli_affected_rows($con) > 0) {
                    $message = "DETAILS FOR PROVIDED CREDENTIALS:";

                } else {
                    $message = "NO ENTRIES FOUND FOR PROVIDED CREDENTIALS"; // Set message indicating no changes
                }
            } else {
                $message = "An Error in the SQL Query: " . mysqli_error($con); // Set error message
            }
            $_SESSION['message'] = $message;

            $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
        }

        //Function to produce a report based on the provided SQL query
        function produceReport($con, $sql) {
            // Execute SQL query
            $result = mysqli_query($con, $sql);
            if (mysqli_affected_rows($con) == 0){
                $message = "NO ENTRIES FOUND FOR PROVIDED CREDENTIALS";
            }
            echo "<input type='number' id='searchById' placeholder='Search by ID'>
                   <button onclick='search()' id='searchButton'>SEARCH</button><br>";
            echo "
                <input type='button' id='dateButton' class='disabled_button' value='Date Of Prescription Order' onclick='dateOrder()' >
                <input type='button' id='doctorButton' value='Doctor Surname Order' onclick='surnameOrder()' >
                <input type='button' id='costButton' value='Cost Order' onclick='costOrder()'>
                 <br><br>";
            // Output table headers
            echo "<table>
            <tr><th>Date Of Prescription  </th><th> Prescription ID </th><th> Doctor Name </th><th> Total Cost </th></tr>";
            // Loop through query results and output table rows
            while ($row = mysqli_fetch_array($result)) {
                // Format date of birth as desired
                $date = date_create($row['dateOfPrescription']);
                $formattedDate = date_format($date, "d/m/Y");
                // Output table row with person details
                echo "<tr>
                <td>".$formattedDate."</td>
				<td>".$row['prescriptionID']."</td>
				<td>".$row['doctorSurname']."</td>
				<td>".$row['totalCost']."</td>
				<td><button value='".$row['prescriptionID']."' id='".$row['prescriptionID']."' onclick='openButton(this)'>OPEN</button></td>
              </tr>";
            }
            // Close table
            echo "</table>";
        }

        //Function to produce a prescription report based on the provided SQL query
        function producePrescriptionReport($con, $sql) {
            // Execute SQL query
            $result = mysqli_query($con, $sql);
            // Output table headers
            echo "<table>
            <tr><th>Brand Name</th><th>Size of Dosage</th><th>Quantity</th><th>Frequency of Dosage</th><th>Length of Dosage</th><th>Doctor's Instructions</th></tr>";
            // Loop through query results and output table rows

            while ($row = mysqli_fetch_array($result)) {
                // Output table row with person details
                echo "<tr>
				<td>".$row['drugName']."</td>
				<td>".$row['sizeOfDosage']."</td>
				<td>".$row['quantityOfDosage']."</td>
				<td>".$row['frequencyOfDosage']."</td>
				<td>".$row['lengthOfDosage']."</td>
				<td>".$row['instructions']."</td>
              </tr>";

            }
            // Close table
            echo "</table>";
            echo"<br><br>";
            echo"<button onclick='navigateBack()' id='back'>OK</button>";

        }

        mysqli_close($con);
        ?>

        <?php
        include '../../db.inc.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['form_submitted'])){
            $choice = $_POST['choice'];
            if(!empty($message) && $choice != 'nothing'){
                echo "<p>$message</p>";
            }

            if($choice == 'date' || $choice == 'default'){
              //  echo "<p>first if</p>";
                $sql1 = $_SESSION['sql1'];
                produceReport($con, $sql1);?>
                <script>
                    // Disable date button if DOB order is chosen
                    document.getElementById("dateButton").disabled = true;
                    document.getElementById("doctorButton").disabled = false;
                    document.getElementById("costButton").disabled = false;
                    document.getElementById("dateButton").style.background = "#727272";
                    document.getElementById("doctorButton").style.background = "rgb(0, 146, 69)";
                    document.getElementById("costButton").style.background = "rgb(0, 146, 69)";
                </script>
            <?php
            }
            elseif($choice == 'Surname'){
               // echo "<p>second if</p>";
                $sql2 = $_SESSION['sql2'];
                produceReport($con, $sql2);
            ?>
            <script>
                // Disable date button if DOB order is chosen
                document.getElementById("dateButton").disabled = false;
                document.getElementById("doctorButton").disabled = true;
                document.getElementById("costButton").disabled = false;
                document.getElementById("doctorButton").style.background = "#727272";
                document.getElementById("costButton").style.background = "rgb(0, 146, 69)";
                document.getElementById("dateButton").style.background = "rgb(0, 146, 69)";
            </script>
            <?php
            }
            elseif($choice == 'Cost'){
                $sql3 = $_SESSION['sql3'];
                produceReport($con, $sql3);
            ?>
                <script>
                    // Disable date button if DOB order is chosen
                    document.getElementById("dateButton").disabled = false;
                    document.getElementById("doctorButton").disabled = false;
                    document.getElementById("costButton").disabled = true;
                    document.getElementById("doctorButton").style.background = "rgb(0, 146, 69)";
                    document.getElementById("costButton").style.background = "#727272";
                    document.getElementById("dateButton").style.background = "rgb(0, 146, 69)";
                </script>
                <?php
            }
            else if($choice == 'nothing'){
                echo"<script>console.log('nothing');</script>";
            }
            else{
                $prescriptionSql = "SELECT drugName, sizeOfDosage, quantityOfDosage, frequencyOfDosage, lengthOfDosage, instructions FROM Drug_to_Prescription
                WHERE prescriptionID = '$choice'";
                producePrescriptionReport($con, $prescriptionSql);
            }
        }
        mysqli_close($con);
        ?>
</form>

<script src="customerPrescriptionsReport.js"></script>
</body>
</html>