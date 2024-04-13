<!--
    Dispense Drugs
    Dispensing drugs and creating a new prescription
    C00290930 Evgenii Salnikov 04.2024
-->

<?php   // The idea is to use session variable to prevent users from resubmitting the form over and over again on page reload
        // This is achieved by setting a session variable on form submission and the checking if it is set
// Start the session to maintain a state between page loads and to handle form resubmission issues
session_start();
// Include the database connection file
include '../db.inc.php';

// Check if a specific action to reset the session variable is requested via URL parameters
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    // Unset the session variable to allow new submissions
    unset($_SESSION['form_submitted']);
    // Redirect to the same page without the query parameter to avoid accidental resets on refresh
    header('Location: dispenseDrugs.php');
    exit;
}

// Initialize or get the current state of the message to be displayed to the user
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

// Check if the form was submitted via POST and if it hasn't been marked as already submitted in the session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Decode the JSON encoded drug data from the form submission
    $drugs = json_decode($_POST['drugsData'], true);

    // Check if the decoded drugs data is an array (valid and non-empty)
    if (is_array($drugs)) {
        // Begin a database transaction to ensure all queries are executed successfully before committing
        mysqli_begin_transaction($con);

        try {
            // Fetch the highest current PrescriptionID to determine the next ID for the new prescription
            $sql = "SELECT MAX(prescriptionID) AS maxPrescriptionID FROM prescription";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            // Calculate the next ID.
            $newPrescriptionID = $row['maxPrescriptionID'] + 1;

            // Retrieve form data for customer, doctor, and prescription date
            $customerID = $_POST['customerID'];
            $doctorID = $_POST['doctorID'];
            $dateOfPrescription = $_POST['dateOfPrescription'];

            // Get the full name of the prescribing doctor from the database
            $doctorNameSQL = "SELECT CONCAT(doctorFirstname, ' ', doctorSurname) AS full_name FROM doctor WHERE doctorID = '$doctorID'";
            $doctorResult = mysqli_query($con, $doctorNameSQL);
            $doctorRow = mysqli_fetch_assoc($doctorResult);
            $doctorName = $doctorRow['full_name'];

            // Calculate the total cost of all drugs to be added to the prescription
            $totalCost = array_sum(array_column($drugs, 'cost'));

            // Prepare and execute the SQL statement to insert a new prescription record
            $prescriptionSQL = "INSERT INTO prescription (prescriptionID, doctorID, customerID, prescribingDoctor, dateOfPrescription, totalCost) VALUES (?,?,?,?,?,?)";
            $stmt = mysqli_prepare($con, $prescriptionSQL);
            mysqli_stmt_bind_param($stmt, "iiissd", $newPrescriptionID, $doctorID, $customerID, $doctorName, $dateOfPrescription, $totalCost);
            mysqli_stmt_execute($stmt);
            // Close the statement to free resources (optional)
            mysqli_stmt_close($stmt);

            // Loop through each drug entry to insert into the drug_to_prescription table
            foreach ($drugs as $drug) {
                if (empty($drug['sizeOfDosage']) || empty($drug['frequencyOfDosage']) || empty($drug['lengthOfDosage'])) {
                    // Check for required dosage information to avoid inserting incomplete data.
                    throw new Exception("DOSAGE INFORMATION CAN NOT BE EMPTY FOR ANY DRUG.");
                }

                // Prepare and execute the SQL statement to insert drug details into the drug_to_prescription table
                $drugToPrescriptionSQL = "INSERT INTO drug_to_prescription (drugID, prescriptionID, drugName, sizeOfDosage, frequencyOfDosage, lengthOfDosage, instructions) VALUES (?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($con, $drugToPrescriptionSQL);
                mysqli_stmt_bind_param($stmt, "iisiiis", $drug['drugID'], $newPrescriptionID, $drug['drugBrandName'], $drug['sizeOfDosage'], $drug['frequencyOfDosage'], $drug['lengthOfDosage'], $drug['instructions']);
                mysqli_stmt_execute($stmt);
                // Close the statement after execution
                mysqli_stmt_close($stmt);
            }

            // Commit all database changes after all inserts are successful
            mysqli_commit($con);
            // Set a success message
            $message = "A NEW PRESCRIPTION HAS BEEN ADDED. ID: $newPrescriptionID";
        } catch (Exception $e) {
            // Rollback the transaction in case of any error and capture the error message
            mysqli_rollback($con);
            $message = "AN ERROR OCCURRED: " . $e->getMessage();
        }
        // Mark the form as submitted to prevent duplicate submissions
        $_SESSION['form_submitted'] = true;
    } else {
        // Set a message if the drug data is invalid
        $message = "Invalid drug data received.";
    }
} elseif (isset($_SESSION['form_submitted'])) {
    // Notify the user if the form was already submitted
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM";
}

// Clear the form submission flag when displaying the form again
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    // Reset the message
    $message = '';
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Link to external css -->
        <link rel="stylesheet" href="dispenseDrugs.css">
        <title>Dispense Drugs</title>
    </head>
    <body>
        <!-- Static header of the page -->
        <div class="header">
            <!-- Logo in the top left corner -->
            <div class="logo">
                <a href="../menu.html"><img src="../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <!-- Menu button that displays the menu links -->
            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <!-- Name of the current page -->
            <div class="page_name">
                <p class="page">DISPENSE DRUGS</p>
            </div>

            <!-- Links to other pages that show up with the click on Menu button -->
            <div class="links" id="links">
                <div class="link" style="top: 5px; left: 0;">
                    <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
                </div>

                <div class="link" style="top: 50px; left: 0;">
                    <a href="dispenseDrugs.php" style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
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

            <!-- Logout logo and button -->
            <div class="logout">
                <a href="../logIn.html"><img src="../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <!-- The form, that calls validateForm() function when submitted -->
        <form method="post" id="drugForm" onsubmit="return validateForm()">
            <!-- Form field for customer selection -->
            <div class="form_line">
                <label for="customerDescription">CUSTOMER</label>
                <select name="customerID" id="customerDescription" onclick="populate()" required>
                    <option value="">Select a customer</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    // Prepare the sql statement
                    $sql = "SELECT customerID, customerSurname, customerName, address, dateOfBirth
                        FROM customer 
                        WHERE customer.isDeleted = 0
                        ORDER BY customerName";
                    if (!empty($con)) {
                        // Execute query
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['customerID'].'" data-details="'.$details.'">'.$row['customerSurname'] . ' ' . $row['customerName'].'</option>';
                        }
                    } else {
                        // Fill the options
                        echo '<option value="">Failed to load customers</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- Form field for customer first name -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="customerName">FIRST NAME</label>
                <input type="text" id="customerName" name="customerName" required disabled>
            </div>

            <!-- Form field for customer last name -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="customerSurname">LAST NAME</label>
                <input type="text" id="customerSurname" name="customerSurname" required disabled>
            </div>

            <!-- Form field for customer address -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="address">ADDRESS</label>
                <input type="text" id="address" name="address" required disabled>
            </div>

            <!-- Form field for customer date of birth -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="dateOfBirth">DATE OF BIRTH</label>
                <input type="date" id="dateOfBirth" name="dateOfBirth" required disabled>
            </div>

            <br>
            <br>

            <!-- Form field for selecting a prescribing doctor -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="prescribingDoctor">PRESCRIBING DOCTOR</label>
                <select name="doctorID" id="prescribingDoctor" required>
                    <option value="">Select a doctor</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    // Prepare the sql statement
                    $sql = "SELECT doctorID, doctorSurname, doctorFirstname
                        FROM doctor 
                        WHERE doctor.isDeleted = 0
                        ORDER BY doctorSurname";
                    if (!empty($con)) {
                        // Execute the statement
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['doctorID'].'" data-details="'.$details.'">'.$row['doctorSurname'] . ' ' . $row['doctorFirstname'].'</option>';
                        }
                    } else {
                        // Print the options
                        echo '<option value="">Failed to load doctors</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- Form field for date of prescription -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="dateOfPrescription">DATE OF PRESCRIPTION</label>
                <input type="date" name="dateOfPrescription" id="dateOfPrescription" required value="<?php echo date('Y-m-d'); ?>">
            </div>

            <br>
            <br>

            <!-- Form field for selecting a drug -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="drugBrandName">DRUG BRAND NAME</label>
                <select name="drugID" id="drugBrandName" onchange="updateDrugPrice()">
                    <option value="">Select a drug</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    // Prepare the sql statement
                    $sql = "SELECT drugID, brandName, retailPrice
                        FROM drug 
                        WHERE drug.isDeleted = 0
                        ORDER BY brandName";
                    if (!empty($con)) {
                        // Execute the query
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', [$row['drugID'], $row['brandName'], $row['retailPrice']]);
                            echo '<option value="' .$row['drugID'].'" data-details="'.$details.'">'.$row['brandName'] . '</option>';
                        }
                    } else {
                        // Print the options
                        echo '<option value="">Failed to load drugs</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- Form field for size of dosage -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="sizeOfDosage">SIZE OF DOSAGE</label>
                <input type="number" id="sizeOfDosage" name="sizeOfDosage" min="0.01" step=".01">
            </div>
            <p style="height: 0;margin-bottom: 0; margin-top: -10px;">TABLETS AT A TIME</p>

            <!-- Form field for frequency of dosage -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="frequencyOfDosage">FREQUENCY OF DOSAGE</label>

                <input type="number" id="frequencyOfDosage" name="frequencyOfDosage">
            </div>
            <p style="height: 0;margin-bottom: 0; margin-top: -10px;">TIMES A DAY</p>

            <!-- Form field for length of dosage -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="lengthOfDosage">LENGTH OF DOSAGE</label>
                <input type="number" id="lengthOfDosage" name="lengthOfDosage">
            </div>
            <p style="height: 0;margin-bottom: 0; margin-top: -10px;">FOR THIS MANY DAYS</p>

            <!-- Form field for instructions -->
            <div class="form_line" style="margin-top: 30px;">
                <label for="instructions">INSTRUCTIONS</label>
                <input type="text" id="instructions" name="instructions">
            </div>

            <!-- Form field for the current prescription price -->
            <div class="form_line" style="margin-top: 60px;">
                <!-- Visible display of the price -->
                <div class="displayPrice" id="displayPrice"></div>
            </div>

            <!-- Form field for displaying the added drugs -->
            <div class="form_line" style="margin-top: 30px;">
                <div id="drugMessages"></div>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <div id="clearMessage"></div>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <!-- Hidden input to store the price (if needed for further processing) -->
                <input type="hidden" id="retailPrice" name="retailPrice">
            </div>

            <!-- Hidden input to store the drug's data before the form is submitted -->
            <input type="hidden" class="drugsData" name="drugsData" id="drugsData" value="">

            <!-- Add Drug Button  Complete Prescription Button -->
            <div class="form_line" style="margin-top: -30px;">
                <button type="button" id="addDrugButton" onclick="addDrug()">ADD DRUG</button>
                <input type="reset" value="CLEAR" id="clear"/>
                <input type="submit" value="COMPLETE PRESCRIPTION" name="completePrescription"/>
            </div>

            <!-- The purpose of the okButton is to basically reload the page without resubmitting the form. This is achieved by sending a specific query parameter when the "OK" button is clicked, which the PHP script checks for at the beginning of the page load to reset the session and message, which make it possible for further successful amending -->
            <div class="form_line">
                <div class="added" id="added">
                    <br><br><br>
                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                        <!-- OK button to reset the message -->
                        <div class="okButton"><a href="dispenseDrugs.php?action=resetMessage" class="okText">OK</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Link to external JS file -->
        <script src="dispenseDrugs.js"></script>
    </body>
</html>