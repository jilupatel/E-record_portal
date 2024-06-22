<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];
    $prices = $_POST['prices'];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gamelogin";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Calculate total price and profit
    $total = 0;
    $profit = 0;
    for ($i = 0; $i < count($items); $i++) {
        $total += $quantities[$i] * $prices[$i];
        
        // Retrieve the price from the additem table
        $item = $items[$i];
        $getItemPriceQuery = "SELECT price FROM additem WHERE item = '$item'";
        $result = $conn->query($getItemPriceQuery);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $itemPrice = $row['price'];
            $profit += ($prices[$i] - $itemPrice) * $quantities[$i];
        } else {
            // Handle if the item price is not found
            // For example, you might set a default value or skip this item
        }
    }

    // Insert data into the cash table
    $sql = "INSERT INTO cash (name, total_price, profit) VALUES ('$name', '$total', '$profit')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to another page with item details
        $redirectUrl = "cashMove.php?name=" . urlencode($name) . "&total=" . urlencode($total) . "&profit=" . urlencode($profit);
        for ($i = 0; $i < count($items); $i++) {
            $redirectUrl .= "&item" . ($i + 1) . "=" . urlencode($items[$i]) . "&quantity" . ($i + 1) . "=" . urlencode($quantities[$i]) . "&price" . ($i + 1) . "=" . urlencode($prices[$i]);
        }
        header("Location: $redirectUrl");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Form submission method not allowed.";
}
?>
