<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["name"];
    $items = $_POST["item"];
    $quantities = $_POST["quantity"];
    $prices = $_POST["price"];

    // Calculate total price
    $totalPrice = 0;
    for ($i = 0; $i < count($items); $i++) {
        $totalPrice += $quantities[$i] * $prices[$i];
    }
    
    // Connect to the database
    $servername = "localhost";
    $dbUsername = "root";
    $password = ""; // Set your actual MySQL password here
    $dbname = "gamelogin";

    $conn = mysqli_connect($servername, $dbUsername, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the username exists in the customer table
    $checkUsernameQuery = "SELECT * FROM customer WHERE name = '$username'";
    $result = mysqli_query($conn, $checkUsernameQuery);
    if (mysqli_num_rows($result) == 0) {
        // If the username doesn't exist, prompt the user to register first
        echo "Username '$username' not found. Please register first.";
        echo '<br><a href="customer.html">Register Here</a>';
        exit();
    }

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        $total = 0;
        // Update quantities in the additem table
        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];
            $quantity = $quantities[$i];
            $total += $quantities[$i] * $prices[$i]; // Update total price here

            // Fetch available quantity and price from the database
            $getItemQuery = "SELECT quantity, price FROM additem WHERE item = '$item'";
            $result = mysqli_query($conn, $getItemQuery);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $availableQuantity = $row["quantity"];
                $itemPrice = $row["price"];

                // Calculate profit for the item
                $profit = ($prices[$i] - $itemPrice) * $quantity;

                // Update quantity in the additem table
                $updatedQuantity = $availableQuantity - $quantity;
                $updateQuantityQuery = "UPDATE additem SET quantity = '$updatedQuantity' WHERE item = '$item'";
                if (!mysqli_query($conn, $updateQuantityQuery)) {
                    throw new Exception("Error updating quantity for item: $item");
                }

                // Update profit in the customer table
                $updateProfitQuery = "UPDATE customer SET profit = profit + '$profit' WHERE name = '$username'";
                if (!mysqli_query($conn, $updateProfitQuery)) {
                    throw new Exception("Error updating profit for customer: $username");
                }
            } else {
                throw new Exception("Item not found: $item");
            }
        }

        // Get the previous total price from the database
        $getPreviousTotalPriceQuery = "SELECT total_price FROM customer WHERE name = '$username'";
        $previousTotalPriceResult = mysqli_query($conn, $getPreviousTotalPriceQuery);
        $row = mysqli_fetch_assoc($previousTotalPriceResult);
        $previousTotalPrice = $row["total_price"];

        // Calculate the new total price by adding the current total price to the previous total price
        $totalPriceWithPrevious = $totalPrice + $previousTotalPrice;

        // Submit total price to the database
        $updateTotalPriceQuery = "UPDATE customer SET total_price = '$totalPriceWithPrevious' WHERE name = '$username'";
        if (!mysqli_query($conn, $updateTotalPriceQuery)) {
            throw new Exception("Error updating total price for customer: $username");
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Redirect to credit.php with necessary parameters
        $itemsSerialized = urlencode(serialize($items));
        $quantitiesSerialized = urlencode(serialize($quantities));
        $pricesSerialized = urlencode(serialize($prices));
        header("Location: credit.php?username=$username&totalPrice=$totalPrice&previousTotalPrice=$previousTotalPrice&items=$itemsSerialized&quantities=$quantitiesSerialized&prices=$pricesSerialized");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
