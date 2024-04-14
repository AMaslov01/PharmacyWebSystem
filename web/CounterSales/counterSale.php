<?php
// Start session to store user data across different pages
session_start();
// Include the database connection settings
include '../db.inc.php';

// Initialize the shopping cart session array if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add item to cart
    if (isset($_POST['addItem'])) {
        // Retrieve item details from the form submission
        $itemID = $_POST['itemID'];
        $quantity = $_POST['quantity'];
        $time = $_POST['time']; // Assuming time is also to be stored

        // Fetch price and description of the item from the database
        $sql = "SELECT retailPrice, description FROM stock WHERE stockID = '$itemID'";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            // Add item details to the session cart array
            $_SESSION['cart'][] = [
                'description' => $row['description'],
                'quantity' => $quantity,
                'price' => $row['retailPrice'],
                'total' => $row['retailPrice'] * $quantity,
                'time' => $time
            ];
            $_SESSION['message'] = "Item added successfully!";
        } else {
            $_SESSION['message'] = "Failed to retrieve item.";
        }
    } elseif (isset($_POST['finalizeSale'])) {
        // Process final sale
        $totalCost = 0;
        // Loop through cart items to calculate total cost and update stock
        foreach ($_SESSION['cart'] as $item) {
            $totalCost += $item['total'];
            $description = $item['description'];
            $quantity = $item['quantity'];

            // Update stock quantities in the database
            $sql = "UPDATE stock SET quantityInStock = quantityInStock - '$quantity' WHERE description = '$description'";
            mysqli_query($con, $sql);
        }

        // Insert sale details into Counter Sales Table
        $sql = "INSERT INTO countersale (dateOfSale, totalPrice, timeOfSale) VALUES (NOW(), '$totalCost', '$time')";
        mysqli_query($con, $sql);

        // Clear the cart after finalizing the sale
        unset($_SESSION['cart']);
        $_SESSION['message'] = "Sale finalized successfully! Total Price: " . $totalCost;
        header('Location: counterSale.php');
        exit;
    }
}

// Retrieve items for the dropdown menu
$sql = "SELECT stockID, description FROM stock WHERE quantityInStock > 0";
$items = mysqli_query($con, $sql);

// Close database connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Sales</title>
    <link rel="stylesheet" href="counterSale.css"> <!-- Link to external CSS file -->
</head>
<body>
    <!-- Page header section -->
    <div class="header">
    <div class="logo">
                <a href="../menu.html"><img src="../Resources/logo6.png" width="110px" height="110px" alt="logo"></a>
            </div>

            <div class="menu_button" id="menu_button">
                <p class="menu">MENU</p>
            </div>

            <div class="page_name">
                <p class="page">COUNTER SALE</p>
            </div>

            <div class="links" id="links">
                <div class="link" style="top: 5px; left: 0;">
                    <a href="../CounterSales/counterSale.html" style="margin: 0; color: white; font-size: 30px;">COUNTER SALES</a>
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
                    <a href="fileMaintenanceMenu.html" style="margin: 0; color: white; font-size: 30px;">FILE MAINTENANCE MENU</a>
                </div>

                <div class="link" style="top: 50px; left: 820px">
                    <a style="margin: 0; color: white; font-size: 30px;" href="../ReportsMenu/reportsMenu.html">REPORTS MENU</a>
                </div>
            </div>

            <div class="logout">
                <a href="../logIn.html"><img src="../Resources/logout3.png" width="160px" height="160px" alt="logo"></a>
            </div>
    </div>

    <!-- Sale form -->
    <form method="post" action="counterSale.php">
        <!-- Select item dropdown -->
        <div class="form_line">
            <label for="itemID">Select Item:</label>
            <select name="itemID" required>
                <option value="">Select An Item</option>
                <?php
                // Populate dropdown with items from the database
                while ($row = mysqli_fetch_assoc($items)) {
                    echo "<option value=\"{$row['stockID']}\">{$row['description']}</option>";
                }
                ?>
            </select>
        </div>
        <!-- Input for quantity -->
        <div class="form_line">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" min="1" required>
        </div>
        <!-- Input for sale time -->
        <div class="form_line">
            <label for="time">Time Of Sale:</label>
            <input type="text" name="time" required>
        </div>
        <!-- Button to add item to the sale -->
        <div class="form_line">
            <button type="submit" name="addItem" id="addsale">Add Item</button>
            <!-- Button to finalize the sale -->
            <button type="submit" name="finalizeSale" id="finalizeSale" style="margin-left: 10px;">Finalize Sale</button>
            <input type="reset" value="CLEAR" id="clear"/>
        </div>
    </form>

    <!-- Display messages or results -->
    <div class="form_line">
        <div class="amended" id="amended">
            <?php if (isset($_SESSION['message'])) : ?>
                <p><?php echo $_SESSION['message']; ?></p>
                <!-- Reset message -->
                <div class="okButton"><a href="counterSale.php?action=resetMessage" class="okText">OK</a></div>
            <?php
                unset($_SESSION['message']);
            endif; ?>
        </div>
    </div>
</body>
</html>
