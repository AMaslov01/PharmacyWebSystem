<!--
    Delete Doctor
    Deleting Doctor
    C00290945 Artemiy Maslov 02.2024
-->
<?php
session_start(); // Start the session
include '../../../db.inc.php'; // Include the database configuration file

// Check if the reset action is requested
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    unset($_SESSION['form_submitted']); // Unset the session variable
    // Redirect to the same page without the query parameter to avoid accidental resets on refresh
    header('Location: deleteDoctor.php');
    exit; // Terminate script execution
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Retrieve message from session or set empty string

// Check if the form is submitted via POST and form submission session variable is not set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Construct SQL query to mark doctor as deleted based on provided doctor ID
    $sql = "UPDATE Doctor SET isDeleted = '1' WHERE doctorID = '{$_POST['doctorDescription']}'";

    // Execute SQL query
    if (mysqli_query($con, $sql)) {
        // Check if any rows were affected by the query
        if (mysqli_affected_rows($con) > 0) {
            $message = "RECORD DELETED SUCCESSFULLY. ID: ".$_POST['doctorDescription']; // Set success message
        } else {
            $message = "NO CHANGES WERE MADE TO THE RECORD. ID: ".$_POST['doctorDescription']; // Set message indicating no changes
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

mysqli_close($con); // Close database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="deleteDoctor.css">
    <title>Delete Doctor</title>
</head>
<body>

<div class="header">
    <div class="logo">
        <a href="../../../menu.html"><img src="../../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a> <!-- Logo -->
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
        Drug
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
        <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a> <!-- Logout button -->
    </div>
</div>

<form method="post" onsubmit="return validateForm()">
    <div class="form_line">
        <label for="doctorDescription">SELECT DOCTOR</label>
        <select name="doctorDescription" id="doctorDescription" onclick="populate()" required>
            <option value="">Select a doctor</option>
            <?php
            include '../../../db.inc.php'; // Include the database configuration file

            // Fetch doctors from the database
            $sql = "SELECT doctorID, doctorSurname, doctorFirstname, surgeryAddress,
                        surgeryEircode, surgeryTelephoneNumber,
                        mobileTelephoneNumber, homeAddress, 
                        homeEircode, homeTelephoneNumber FROM Doctor 
                        WHERE Doctor.isDeleted = 0
                        ORDER BY doctorSurname ASC";
            if (!empty($con)) {
                $result = mysqli_query($con, $sql);
            }

            // Populate select options with doctor details
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Combine all relevant details with a delimiter (comma)
                    $details = implode(',', $row);
                    echo '<option value="'.$row['doctorID'].'" data-details="'.$details.'">'.$row['doctorSurname'].'</option>'; // Output option tag with doctor details
                }
            } else {
                echo '<option value="">Failed to load doctors</option>'; // Output failed to load doctors message
            }

            mysqli_close($con); // Close database connection
            ?>
        </select>
    </div>


    <div class="form_line">
        <label for="doctorID">DOCTOR ID</label>
        <input type="text" id="doctorID" name="doctorID" required disabled>
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
        <input type="text" id="surgeryAddress" name="surgeryAddress" pattern="[0-9A-Za-z\s]+" required disabled>
    </div>

    <div class="form_line">
        <label for="surgeryEircode">SURGERY EIRCODE</label>
        <input type="text" id="surgeryEircode" name="surgeryEircode" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
    </div>

    <div class="form_line">
        <label for="surgeryTelephoneNumber">SURGERY TELEPHONE NUMBER</label>
        <input type="text" id="surgeryTelephoneNumber" name="surgeryTelephoneNumber" pattern="[0-9\s+\-]+" required disabled>
    </div>

    <div class="form_line">
        <label for="mobileTelephoneNumber">MOBILE TELEPHONE NUMBER</label>
        <input type="text" id="mobileTelephoneNumber" name="mobileTelephoneNumber" pattern="[0-9\s+\-]+" required disabled>
    </div>

    <div class="form_line">
        <label for="homeAddress">HOME ADDRESS</label>
        <input type="text" id="homeAddress" name="homeAddress" pattern="[0-9A-Za-z\s]+" required disabled>
    </div>

    <div class="form_line">
        <label for="homeEircode">HOME EIRCODE</label>
        <input type="text" id="homeEircode" name="homeEircode" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
    </div>

    <div class="form_line">
        <label for="homeTelephoneNumber">HOME TELEPHONE NUMBER</label>
        <input type="text" id="homeTelephoneNumber" name="homeTelephoneNumber" pattern="[0-9\s+\-]+" required disabled>
    </div>

    <div class="form_line">
        <span></span>
        <input type="submit" value="DELETE" id="deleteButton"/>
    </div>

    <!-- Display message after form submission -->
    <div class="form_line">
        <div class="deleted" id="deleted">
            <br><br><br>
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p> <!-- Display message -->
                                               <!-- OK button to reset the message -->
                <div class="okButton"><a href="deleteDoctor.php?action=resetMessage" class="okText">OK</a></div>
            <?php endif; ?>
        </div>
    </div>
</form>

<script src="deleteDoctor.js"></script>
</body>
</html>

