<?php
session_start();
include '../../../db.inc.php'; // db location

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assign the POST data to variables
    $supplierID = $_POST['supplierID'];
    $paymentAmount = $_POST['paymentAmount'];

    // Begin a transaction
    mysqli_begin_transaction($con);

    try {
        // Fetch the current amount owed by the supplier
        $sql = "SELECT amountOwed FROM supplier WHERE supplierID = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $supplierID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $currentAmountOwed = $row['amountOwed'];

        // Calculate the new amount owed, ensuring it does not go below zero
        $newAmountOwed = max($currentAmountOwed - $paymentAmount, 0);

        // Update the supplier's amountOwed in the database
        $updateSql = "UPDATE supplier SET amountOwed = ? WHERE supplierID = ?";
        $updateStmt = mysqli_prepare($con, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "di", $newAmountOwed, $supplierID);
        mysqli_stmt_execute($updateStmt);

        // If we reach this point without errors, commit the transaction
        mysqli_commit($con);

        $_SESSION['message'] = "Payment processed successfully. New amount owed: $newAmountOwed";
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        mysqli_rollback($con);
        $_SESSION['message'] = "An error occurred: " . $e->getMessage();
    }

    // Redirect to the payment page with a message
    header('Location: paymentToSuppliers.php');
    exit();
}
?>
