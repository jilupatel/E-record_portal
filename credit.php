<?php
// Connect to the database
$servername = "localhost";
$dbUsername = "root";
$password = ""; // Set your actual MySQL password here
$dbname = "gamelogin";

$conn = mysqli_connect($servername, $dbUsername, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form data is passed as URL parameters
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['totalPrice'], $_GET['previousTotalPrice'], $_GET['username'], $_GET['items'], $_GET['quantities'], $_GET['prices'])) {
    // Retrieve form data from URL parameters
    $totalPrice = $_GET['totalPrice']; // Retrieve total price from URL parameter
    $previousTotalPrice = $_GET['previousTotalPrice']; // Retrieve previous total price from URL parameter
    $username = $_GET['username']; // Retrieve username from URL parameter
    $items = unserialize(urldecode($_GET['items'])); // Deserialize items array
    $quantities = unserialize(urldecode($_GET['quantities'])); // Deserialize quantities array
    $prices = unserialize(urldecode($_GET['prices'])); // Deserialize prices array

    // Retrieve additional data from the database based on the username
    $sql = "SELECT * FROM customer WHERE name = '$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Display the submitted data including the total price and previous total price
        echo "<h2>Client Bill</h2>";
        echo "<p>Username: $username</p>"; // Display username
        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];
            $quantity = $quantities[$i];
            $price = $prices[$i];
            $itemTotal = $quantity * $price;
            echo "<p>Item: $item | Quantity: $quantity | Price: $price | Item Total: $itemTotal</p>";
        }
        echo "<p>Total Price: $totalPrice</p>";
        echo "<h2>Additional Information</h2>";
        echo "<p>Previous Total Price: $previousTotalPrice</p>";
        $totalPriceWithPrevious = $previousTotalPrice + $totalPrice;
        echo "<p>Total Price with Previous: $totalPriceWithPrevious</p>";
    } else {
        echo "No additional information found for username: $username";
        echo '<br><a href="customer.html">Register Here</a>';
    }
} else {
    // If the form data is not passed via URL parameters, handle the situation accordingly
    echo "Data transfer failed.";
}

// Close the database connection
mysqli_close($conn);
?>
