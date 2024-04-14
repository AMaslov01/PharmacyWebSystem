<!--
// Author			: Nebojsa Kukic
// Date				: 23/02/2024
// Purpose			: Add a Drug to the Customer Table.
//					: This is the html and php	
-->

<?php
session_start(); // Start the session
include '../../../db.inc.php';

// Check if the reset action is requested
if (isset($_GET['action']) && $_GET['action'] == 'resetMessage') {
    unset($_SESSION['form_submitted']);
    // Redirect to the same page without the query parameter to avoid accidental resets on refresh
    header('Location: amendViewDrug.php');
    exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
    // Prepare the UPDATE SQL statement
    $sql = "UPDATE drug SET 
            supplierID = '{$_POST['supplierID']}',  
            brandName = '{$_POST['brandName']}', 
            genericName = '{$_POST['genericName']}', 
            drugForm = '{$_POST['drugForm']}', 
            drugStrength = '{$_POST['drugStrength']}', 
            usageInstructions = '{$_POST['usageInstructions']}',
            sideEffects = '{$_POST['sideEffects']}',
			costPrice = '{$_POST['costPrice']}',  
            retailPrice = '{$_POST['retailPrice']}', 
            quantityInStock = '{$_POST['quantityInStock']}', 
            reorderLevel = '{$_POST['reorderLevel']}', 
            reorderQuantity = '{$_POST['reorderQuantity']}'
            WHERE drugID = '{$_POST['drugDescription']}'";

    // Create query and set the message
    if (mysqli_query($con, $sql)) {
        if (mysqli_affected_rows($con) > 0) {
            $message = "RECORD UPDATED SUCCESSFULLY. ID: ".$_POST['drugDescription'];
        } else {
            $message = "NO CHANGES WERE MADE TO THE RECORD. ID: ".$_POST['drugDescription'];
        }
    } else {
        $message = "An Error in the SQL Query: " . mysqli_error($con);
    }

    // Set a session variable to indicate form submission
    $_SESSION['form_submitted'] = true;
} elseif (isset($_SESSION['form_submitted'])) {
    $message = "YOU HAVE ALREADY SUBMITTED THE FORM"; // Message to show if the form was already submitted
}

// If reached the page, without posting the form
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    unset($_SESSION['form_submitted']);
    $message = '';
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Link to external css -->
        <link rel="stylesheet" href="amendViewDrug.css">
		
        <title>View/Amend Stock Item</title>
    </head>
    <body>
        <!-- Static header of the page -->
        <div class="header">
            <!-- Logo in the top left corner -->
            <div class="logo">
                <a href="../../../menu.html"><img src="../../../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>
	
            <!-- Menu button that displays the menu links -->
            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <!-- Name of the current page -->
            <div class="page_name">
                <p class="page">VIEW/AMEND DRUG ITEM</p>
            </div>

            <!-- Links to other pages that show up with the click on Menu button -->
            <div class="links" id="links">
                <div class="link" style="top: 5px; left: 0;">
                    <a style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
                </div>

                <div class="link" style="top: 50px; left: 0;">
                    <a href="../../../DispenseDrugs/dispenseDrugs.php" style="margin: 0; color: white; font-size: 30px;">DISPENSE DRUGS</a>
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
                    <a style="margin: 0; color: white; font-size: 30px;">REPORTS MENU</a>
                </div>
            </div>

            <!-- Logout logo and button -->
            <div class="logout">
                <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <!-- The form, that calls validateForm() function when submitted -->
        <form method="post" onsubmit="return validateForm()">
            <div class="form_line">
                <!-- Automatically populated dropdown list of all not-deleted stock items -->
                <label for="drugDescription">SELECT DESCRIPTION</label>
                <!-- populate() function is called, when stock item is clicked on (selected) -->
                <select name="drugDescription" id="drugDescription" onchange="populate()" required>
                    <option value="">Select a Drug</option>
                    <?php
                    include '../../../db.inc.php';

                    // Prepare sql SELECT statement for stock items
                    $sql = "SELECT drugID, supplierID, brandName, genericName, drugForm, drugStrength, usageInstructions, sideEffects, costPrice, retailPrice, quantityInStock, reorderLevel, reorderQuantity
                        FROM drug 
                        ";
                    if (!empty($con)) {
                        $result = mysqli_query($con, $sql);
                    }

                    // Save supplier ID
                    //global $supplierID;

                    // data-details is used to store all the details of each stock item as a single string within the HTML <option> elements, while $details is a PHP variable used to construct this string. JavaScript then retrieves this string from the selected <option> element and splits it to populate the form fields with the appropriate details.

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Combine all relevant details with a delimiter (comma)
                            $details = implode(',', $row);
                            echo '<option value="'.$row['drugID'].'" data-details="'.$details.'">'.$row['brandName'].'</option>';
                            //$supplierID = $row['supplierID'];
                        }
                    } else {
                        // Display error message
                        echo '<option value="">Failed to load drug items</option>';
                    }

                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <!-- View/Amend button -->
            <input type="button" value="AMEND" id="amendViewButton" onclick="toggleLock()">

            <!-- Form field for drugID --  cannot amend-->
            <div class="form_line" style="margin-top: 30px;">
                <label for="drugID">DRUG ID</label>
                <input type="number" id="drugID" name="drugID" pattern="[0-9]+" required disabled>
            </div>


			<!-- Form field for supplierID -->
			<!-- First supplier name form field, that is displayed when in View mode -->
			<div class="supplierDiv1" id="supplierDiv1">
				<div class="form_line">
					<label for="supplierID">SUPPLIER NAME</label>
					<input type="text" id="supplierID" name="supplierID" pattern="[0-9A-Za-z., ]+" onclick="changeSelect()" required disabled>
				</div>
			</div>

			<!-- Second supplier name form field, that is displayed when in Amend mode -->
			<div class="supplierDiv2" style="display: none;" id="supplierDiv2">
				<div class="form_line">
					<label for="supplierID">SUPPLIER NAME</label>
					<!-- Automatically populated with suppliers dropdown -->
					<select name="supplierID" id="supplierID" required>
						<option id="preselectedSupplier" value="">Select a supplier</option>
						<?php
						include '../../../db.inc.php';

						// Prepare sql SELECT statement for fetching suppliers
						$sql = "SELECT supplierID, supplierName FROM supplier ORDER BY supplierName ASC";
						if (!empty($con)) {
							// Execute query
							$result = mysqli_query($con, $sql);
						}

						if ($result) {
							while ($row = mysqli_fetch_assoc($result)) {
								// Does not preselect, can use just echo from else
								if ($row['supplierID'] == $supplierID) {
									// Populate dropdown with selected supplier
									echo '<option value="'.$row['supplierID'].'" selected>'.$row['supplierName'].'</option>';
								} else {
									echo '<option value="'.$row['supplierID'].'">'.$row['supplierName'].'</option>';
								}
							}
						} else {
							// Display error message
							echo '<option value="">Failed to load suppliers</option>';
						}

						mysqli_close($con);
						?>
					</select>
				</div>
			</div>



            <!-- Form field for brand name -->
            <div class="form_line">
                <label for="brandName">BRAND NAME</label>
                <input type="text" id="brandName" name="brandName"" required disabled>
            </div>

            <!-- Form field for generic name -->
            <div class="form_line">
                <label for="genericName">GENERIC NAME</label>
                <input type="text" id="genericName" name="genericName"" required disabled>
            </div>

            <!-- Form field for drug form -->
            <div class="form_line">
                <label for="drugForm">DRUG FORM</label>
                <input type="text" id="drugForm" name="drugForm" required disabled>
            </div>

            <!-- Form field for drug strength -->
            <div class="form_line">
                <label for="drugStrength">DRUG STRENGTH</label>
                <input type="text" id="drugStrength" name="drugStrength" required disabled>
            </div>

            <!-- Form field for usage instructions -->
            <div class="form_line">
                <label for="usageInstructions">USAGE INSTRUCTIONS</label>
                <input type="text" id="usageInstructions" name="usageInstructions" required disabled>
            </div>

			<!-- Form field for side effects-->
            <div class="form_line">
                <label for="sideEffects">SIDE EFFECTS</label>
                <input type="text" id="sideEffects" name="sideEffects" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			<!-- Form field for cost price -->
            <div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			<!-- Form field for retail price -->
            <div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			<!-- Form field for quantity in stock -->
            <div class="form_line">
                <label for="quantityInStock">QUANTITY IN STOCK</label>
                <input type="number" id="quantityInStock" name="quantityInStock" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			<!-- Form field for reorder level -->
            <div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			<!-- Form field for reorder quantity-->
            <div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" pattern="[0-9A-Za-z., ]+" required disabled>
            </div>
			
     

            <!-- Save button -->
            <div class="form_line">
                <span></span>
                <input type="submit" value="SAVE" name="submit"/>
            </div>

            <!-- The purpose of the okButton is to basically reload the page without resubmitting the form. This is achieved by sending a specific query parameter when the "OK" button is clicked, which the PHP script checks for at the beginning of the page load to reset the session and message, which make it possible for further successful amending -->
            <div class="form_line">
                <div class="amended" id="amended">
                    <br><br><br>
                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                        <!-- OK button to reset the message -->
                        <div class="okButton"><a href="amendViewDrug.php?action=resetMessage" class="okText">OK</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- Link to external JS -->
		<script src="amendViewDrug.js"></script>
       
    </body>
</html>