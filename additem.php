<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamelogin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$item = $_POST['item'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

// Check if the item already exists in the database
$sql = "SELECT * FROM additem WHERE item = '$item' AND price = '$price'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // If the item already exists, update its quantity
    $updateSql = "UPDATE additem SET quantity = quantity + $quantity WHERE item = '$item' AND price = '$price'";
    if (mysqli_query($conn, $updateSql)) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
} else {
    // If the item doesn't exist, insert a new row
    $insertSql = "INSERT INTO additem (item, price, quantity) VALUES ('$item', '$price', '$quantity')";
    if (mysqli_query($conn, $insertSql)) {
        echo "New item added successfully";
    } else {
        echo "Error adding new item: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
