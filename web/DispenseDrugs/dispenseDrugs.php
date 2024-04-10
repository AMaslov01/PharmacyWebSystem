<?php   // The idea is to use session variable to prevent users from resubmitting the form over and over again on page reload.
        // This is achieved by setting a session variable on form submission and the checking if it is set.
    session_start(); // Start the session
    include '../db.inc.php';

    // Check if the reset action is requested
    if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
        unset($_SESSION['form_submitted']);
        // Redirect to the same page without the query parameter to avoid accidental resets on refresh
        header('Location: dispenseDrugs.php');
        exit;
    }

    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        // Fetch the highest current StockID
        $sql = "SELECT MAX(prescriptionID) AS MaxPrescriptionID FROM prescription";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxPrescriptionID = $row['MaxPrescriptionID'];

        // Increment the StockID by 1 for the new record
        $newPrescriptionID = $maxPrescriptionID + 1;

        $doctorID = $_POST[''];
        $customerID = $_POST[''];
        $prescribingDoctor = $_POST[''];
        $dateOfPrescription = $_POST[''];

        // $sql = "INSERT INTO Stock (StockID, description, costPrice, retailPrice, reorderLevel, reorderQuantity, supplierID, supplierStockCode, quantityInStock) VALUES ('$newStockID', '$description', '$costPrice', '$retailPrice', '$reorderLevel', '$reorderQuantity', '$supplierID', '$supplierStockCode', 0)";

        if (mysqli_query($con, $sql)) {
            $message = "A NEW STOCK ITEM HAS BEEN ADDED. ID: $newStockID";
        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $stockID = mysqli_insert_id($con);

        $_SESSION['form_submitted'] = true; // Set a session variable to indicate form submission
    } elseif (isset($_SESSION['form_submitted'])) {
        $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
    }

    // Clear the form submission flag when displaying the form again
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        unset($_SESSION['form_submitted']);
        $message = '';
    }

    mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="dispenseDrugs.css">
        <title>Dispense Drugs</title>
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

            <div class="logout">
                <a href="../logIn.html"><img src="../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <form method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <label for="customerDescription">CUSTOMER</label>
                <select name="customerDescription" id="customerDescription" onclick="populate()" required>
                    <option value="">Select a customer</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    $sql = "SELECT customerID, customerSurname, customerName, address, dateOfBirth
                        FROM customer 
                        WHERE customer.isDeleted = 0
                        ORDER BY customerName";
                    if (!empty($con)) {
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
                        echo '<option value="">Failed to load customers</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="customerName">FIRST NAME</label>
                <input type="text" id="customerName" name="customerName" required disabled>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="customerSurname">LAST NAME</label>
                <input type="text" id="customerSurname" name="customerSurname" required disabled>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="address">ADDRESS</label>
                <input type="text" id="address" name="address" required disabled>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="dateOfBirth">DATE OF BIRTH</label>
                <input type="date" id="dateOfBirth" name="dateOfBirth" required disabled>
            </div>

            <br>
            <br>

            <div class="form_line" style="margin-top: 30px;">
                <label for="prescribingDoctor">PRESCRIBING DOCTOR</label>
                <select name="prescribingDoctor" id="prescribingDoctor" required>
                    <option value="">Select a doctor</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    $sql = "SELECT doctorID, doctorSurname, doctorFirstname
                        FROM doctor 
                        WHERE doctor.isDeleted = 0
                        ORDER BY doctorSurname";
                    if (!empty($con)) {
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
                        echo '<option value="">Failed to load doctors</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="dateOfPrescription">DATE OF PRESCRIPTION</label>
                <input type="date" name="dateOfPrescription" id="dateOfPrescription" required value="<?php echo date('Y-m-d'); ?>">
            </div>

            <br>
            <br>

            <div class="form_line" style="margin-top: 30px;">
                <label for="drugBrandName">DRUG BRAND NAME</label>
                <select name="drugBrandName" id="drugBrandName" required>
                    <option value="">Select a drug</option>
                    <?php
                    include '../db.inc.php'; // Adjust the path as necessary
                    date_default_timezone_set("UTC"); // Setting default timezone to UTC

                    $sql = "SELECT drugID, brandName
                        FROM drug 
                        WHERE drug.isDeleted = 0
                        ORDER BY brandName";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['drugID'].'" data-details="'.$details.'">'.$row['brandName'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Failed to load drugs</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="sizeOfDosage">SIZE OF DOSAGE</label>
                <input type="number" id="sizeOfDosage" name="sizeOfDosage" min="0.01" step=".01" required>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="frequencyOfDosage">FREQUENCY OF DOSAGE</label>
                <input type="text" id="frequencyOfDosage" name="frequencyOfDosage" required>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="lengthOfDosage">LENGTH OF DOSAGE</label>
                <input type="text" id="lengthOfDosage" name="lengthOfDosage" required>
            </div>

            <div class="form_line" style="margin-top: 30px;">
                <label for="instructions">INSTRUCTIONS</label>
                <input type="text" id="instructions" name="instructions" required>
            </div>

            <div class="form_line">
                <span></span>
                <input type="submit" value="SAVE" name="submit"/>
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

        <script src="dispenseDrugs.js"></script>
    </body>
</html>