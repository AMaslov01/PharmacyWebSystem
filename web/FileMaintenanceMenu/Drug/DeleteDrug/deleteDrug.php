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
    header('Location: deleteDrug.php');
    exit; // Terminate script execution
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Retrieve message from session or set empty string

// Check if the form is submitted via POST and form submission session variable is not set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Construct SQL query to mark doctor as deleted based on provided doctor ID
    $sql = "UPDATE drug SET isDeleted = '1' WHERE drugID = '{$_POST['drugDescription']}'";

    // Execute SQL query
    if (mysqli_query($con, $sql)) {
        // Check if any rows were affected by the query
        if (mysqli_affected_rows($con) > 0) {
            $message = "RECORD DELETED SUCCESSFULLY. ID: ".$_POST['drugDescription']; // Set success message
        } else {
            $message = "NO CHANGES WERE MADE TO THE RECORD. ID: ".$_POST['drugDescription']; // Set message indicating no changes
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
    <link rel="stylesheet" href="deleteDrug.css">
    <title>Delete Drug</title>
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
        <p class="page">DELETE DRUG</p>
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
        <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a> <!-- Logout button -->
    </div>
</div>

<form method="post" onsubmit="return validateForm()">
    <div class="form_line">
        <label for="drugDescription">SELECT DRUG</label>
        <select name="drugDescription" id="drugDescription" onchange="populate()" required>
            <option value="">Select a drug</option>
            <?php
            include '../../../db.inc.php'; // Include the database configuration file

            // Fetch drugs from the database
            // Fetch drugs from the database
			$sql = "SELECT drugID, brandName, genericName, drugForm, drugStrength, supplierID FROM Drug WHERE isDeleted = 0 ORDER BY brandName ASC";
			if ($con) {
				$result = mysqli_query($con, $sql);
				if ($result) {
					while ($row = mysqli_fetch_assoc($result)) {
						$details = implode(',', array(
							htmlspecialchars($row['brandName']),
							htmlspecialchars($row['genericName']),
							htmlspecialchars($row['drugForm']),
							htmlspecialchars($row['drugStrength']),
							htmlspecialchars($row['supplierID'])
						));
						echo '<option value="' . htmlspecialchars($row['drugID']) . '" data-details="' . $details . '">' . htmlspecialchars($row['drugID']) . '</option>';
					}
				} else {
					echo '<option value="">Failed to load drugs</option>';
				}
				mysqli_close($con);
			}
			
		?>
        </select>
    </div>


    <div class="form_line">
        <label for="brandName">BRAND NAME</label>
        <input type="text" id="brandName" name="brandName" required disabled>
    </div>
    <div class="form_line">
        <label for="genericName">GENERIC NAME</label>
        <input type="text" id="genericName" name="genericName" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="drugForm">DRUG FORM</label>
        <input type="text" id="drugForm" name="drugForm" pattern="[A-Za-z]+" required disabled>
    </div>

    <div class="form_line">
        <label for="drugStrength">DRUG STRENGTH</label>
        <input type="text" id="drugStrength" name="drugStrength" pattern="[0-9A-Za-z\s]+" required disabled>
    </div>

    <div class="form_line">
        <label for="supplierID">SUPPLIERS NAME</label>
        <input type="text" id="supplierID" name="supplierID" pattern="^[A-Za-z\d]{3}\s?[A-Za-z\d]{4}$" required disabled>
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
                <div class="okButton"><a href="deleteDrug.php?action=resetMessage" class="okText">OK</a></div>
            <?php endif; ?>
        </div>
    </div>
</form>

<script src="deleteDrug.js"></script>
</body>
</html>

