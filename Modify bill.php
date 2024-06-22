<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["name"];
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    
    // Calculate total price
    $totalPrice = $quantity * $price;

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
    $sql = "SELECT * FROM customer WHERE name = '$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // User exists, process billing data
        $row = mysqli_fetch_assoc($result);
        // Retrieve user's ID, address, and phone number
        $customerId = $row['id'];
        $customerAddress = $row['address'];
        $customerNumber = $row['number'];

        // Process billing data or redirect to a payment gateway
        // Here you can update your billing records in the database or process payment
        
        // For demonstration, let's just echo the details
        echo "User ID: $customerId<br>";
        echo "Address: $customerAddress<br>";
        echo "Phone Number: $customerNumber<br>";
        echo "Item: $item<br>";
        echo "Quantity: $quantity<br>";
        echo "Price: $price<br>";
        echo "Total Price: $totalPrice<br>";

    } else {
        // User does not exist, redirect to customer registration
        header("Location: customer.html");
        exit(); // Ensure script execution stops after redirection
    }

    mysqli_close($conn);
}
?>
