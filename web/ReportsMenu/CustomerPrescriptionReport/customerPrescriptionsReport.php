
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

<form method="post" name="selectDetails" onsubmit="checkDates()">

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
        <input type="date" id="endDatesDescription" name="endDatesDescription" style="display: none;" required >
    </div>
    <div class="form_line">
        <input type="reset" value="CLEAR" name="reset"/>
        <input type="submit" value="SEARCH" name="submit"/>
    </div>
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

        $message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Retrieve message from session or set empty string

        // Check if the form is submitted via POST and form submission session variable is not set
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
            // Construct SQL query to mark doctor as deleted based on provided doctor ID
            date_default_timezone_set("UTC");
            $date1 = date("Y-m-d", strtotime($_POST['startDatesDescription']));
            $date2 = date("Y-m-d", strtotime($_POST['endDatesDescription']));
            $sql = "SELECT dateOfPrescription, prescriptionID, doctorSurname FROM Prescription JOIN
            Doctor ON Doctor.doctorID = Prescription.doctorID JOIN Customer
            ON Customer.customerID = Prescription.customerID
            WHERE Prescription.customerID = '{$_POST['customerDescription']}' AND
            dateOfPrescription BETWEEN '$date1' AND '$date2'";

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

            $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
        } elseif (isset($_SESSION['form_submitted'])) {
            $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
        }

        // Clear form submission session variable if request method is not POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            unset($_SESSION['form_submitted']);
            $message = ''; // Clear message
        }
        function produceReport($con, $sql) {
            // Execute SQL query
            $result = mysqli_query($con, $sql);
            echo "
                <input type='hidden' name='choice'>
                <input type='button' id='dateButton' value='Date Of Prescription Order' onclick='dateOrder()'>
                <input type='button' id='doctorButton' value='Doctor Surname Order' onclick='surnameOrder()'>
                 <br><br>";
            // Output table headers
            echo "<table>
            <tr><th>Date Of Prescription  </th><th> Prescription ID </th><th> Doctor Name </th></tr>";
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
              </tr>";
            }
            // Close table
            echo "</table>";
        }

        mysqli_close($con);
        ?>

    <?php
    include '../../db.inc.php';
    if(!empty($message)){
        echo "<p>$message</p>";}
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    produceReport($con, $sql);}
    mysqli_close($con);?>
</form>




<script src="customerPrescriptionsReport.js"></script>
</body>
</html>