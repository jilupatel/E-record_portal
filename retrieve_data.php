<?php
$servername = "localhost";
$username = "root";
$password = ""; // Set your actual MySQL password here
$dbname = "gamelogin";

// Establish connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the name is provided via POST
if(isset($_POST['name'])) {
    $name = $_POST['name'];

    // Prepare and execute SQL query
    $sql = "SELECT * FROM customer WHERE name LIKE '%$name%'";
    $result = mysqli_query($conn, $sql);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($rows); // Output the data as JSON
    } else {
        echo "No results found";
    }
} else {
    echo "Name not provided";
}

// Close connection
mysqli_close($conn);
?>
