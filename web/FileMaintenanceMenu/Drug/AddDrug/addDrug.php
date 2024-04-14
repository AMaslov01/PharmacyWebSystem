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
        header('Location: addDrug.php');
        exit;
    }

    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['form_submitted'])) {
        // Fetch the highest current DrugID
        $sql = "SELECT MAX(drugID) AS MaxDrugID FROM drug";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxDrugID = $row['MaxDrugID'];

        // Increment the drugID by 1 for the new record
        $newDrugID = $maxDrugID + 1;

		// These are the values which will be submitted into the DB, making vars
        $supplierID = $_POST['supplierID'];
        $brandName = $_POST['brandName'];
        $genericName = $_POST['genericName'];
        $drugForm = $_POST['drugForm'];
        $drugStrength = $_POST['drugStrength'];
        $usageInstructions = $_POST['usageInstructions'];
        $sideEffects = $_POST['sideEffects'];
		$costPrice = $_POST['costPrice'];
        $retailPrice = $_POST['retailPrice'];
        $reorderLevel = $_POST['reorderLevel'];
		$reorderQuantity = $_POST['reorderQuantity'];
		
		
		// Inserting the vars into the drug table
        $sql = "INSERT INTO drug (drugID, supplierID, brandName, genericName, drugForm, drugStrength, usageInstructions, sideEffects, costPrice, retailPrice, reorderLevel, reorderQuantity) VALUES ('$newDrugID', '$supplierID', '$brandName', '$genericName', '$drugForm', '$drugStrength', '$usageInstructions', '$sideEffects', '$costPrice', '$retailPrice', '$reorderLevel', '$reorderQuantity')";

        if (mysqli_query($con, $sql)) {
            $message = "A NEW DRUG ITEM HAS BEEN ADDED - ID: $newDrugID";

        } else {
            $message = "An Error in the SQL Query: " . mysqli_error($con);
        }

        $drugID = mysqli_insert_id($con);

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
        <link rel="stylesheet" href="addDrug.css">
        <title>Add Drug Item</title>
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
                <p class="page">ADD DRUG ITEM FORM</p>
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
                    <a style="margin: 0; color: white; font-size: 30px;">REPORTS MENU</a>
                </div>
            </div>

            <div class="logout">
                <a href="../../../logIn.html"><img src="../../../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
        </div>

        <form method="post" id="formID" onsubmit="return validateForm()">

            <div class="form_line">
                <label for="brandName">BRAND NAME</label>
                <input type="text" id="brandName" name="brandName" pattern="[A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="genericName">GENERIC NAME</label>
                <input type="text" id="genericName" name="genericName" pattern="[A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="drugForm">DRUG FORM</label>
                <input type="text" id="drugForm" name="drugForm" pattern="[A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="drugStrength">DRUG STRENGTH</label>
                <input type="text" id="drugStrength" name="drugStrength" pattern="[A-Za-z., ]+" required>
            </div>

            <div class="form_line">
                <label for="usageInstructions">USAGE INSTRUCTIONS</label>
                <input type="text" id="usageInstructions" name="usageInstructions" pattern="[A-Za-z., ]+" required>
            </div>
			
			
            <div class="form_line">
                <label for="sideEffects">SIDE EFFECTS</label>
                <input type="text" id="sideEffects" name="sideEffects" pattern="[A-Za-z ]+" required>
            </div>

			<div class="form_line">
                <label for="costPrice">COST PRICE</label>
                <input type="number" id="costPrice" name="costPrice" min="0.01" step=".01" required>
            </div>

			<div class="form_line">
                <label for="retailPrice">RETAIL PRICE</label>
                <input type="number" id="retailPrice" name="retailPrice" min="0.01" step=".01" required>
            </div>

			<div class="form_line">
                <label for="reorderLevel">REORDER LEVEL</label>
                <input type="number" id="reorderLevel" name="reorderLevel" min="1" required>
            </div>

			<div class="form_line">
            <label for="supplierID">Supplier Name:</label>
            	<select name="supplierID" id="supplierID" required>
                <option value="">Select a Supplier</option>
                <?php
				include '../../../db.inc.php';
                // Query to fetch all suppliers
				// If the supplier is deleted, then don't display them.
                $sql = "SELECT supplierID, supplierName FROM supplier WHERE isDeleted = 0 ORDER BY supplierName ASC";
                $result = mysqli_query($con, $sql);
                
                // Check if the query was successful and returned rows
                if($result && mysqli_num_rows($result) > 0){
                    // Loop through each supplier and create an option element
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<option value="'.htmlspecialchars($row['supplierID']).'">'.htmlspecialchars($row['supplierName']).'</option>';
                    }
                } else { // in case the suppliers table is empty...
                    // Inform the user that no suppliers are available
                    echo '<option value="">No suppliers available</option>';
					
                }
                ?>
            	</select>
        	</div>

			<div class="form_line">
                <label for="reorderQuantity">REORDER QUANTITY</label>
                <input type="number" id="reorderQuantity" name="reorderQuantity" min="1" required>
            </div>

            <div class="form_line">
                <input type="reset" value="CLEAR" name="reset"/>
                <input type="submit" value="ADD" name="submit"/>
            </div>

            <div class="form_line">
                <div>
                    <br><br><br>
					
                    <label><?php if (!empty($message)) : ?>
                            <p><?php echo $message; ?></p>
                            <!-- OK button to reset the message -->
                            <div class="okButton"><a href="addDrug.php?action=resetMessage" class="okText">OK</a></div>
                        <?php endif; ?>
                    </label>
                </div>
            </div>

			
						
        </form>

        <script src="addDrug.js"></script>
    </body>
</html>