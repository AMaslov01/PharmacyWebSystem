<?php
include '../../../db.inc.php'; // Including the database configuration file

// Constructing the SQL query to insert data into the 'student' table
$sql = "Insert into Stock (description, costPrice, retailPrice, reorderLevel, reorderQuantity, supplierStockCode, quantityInStock) VALUES ('$_POST[description]','$_POST[costPrice]','$_POST[retailPrice]','$_POST[reorderLevel]','$_POST[reorderQuantity]','$_POST[supplierStockCode]','$_POST[quantityInStock]')";

// Executing the SQL query
if (!empty($con)) {
    if(!mysqli_query($con, $sql))
    {
        die ("An Error in the SQL Query: " . mysqli_error($con) ); // Displaying error message if query execution fails
    }
}

echo "<br>A record has been added for " . $_POST['stockID'] . "."; // Success message

mysqli_close($con); // Closing the database connection