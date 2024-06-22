<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamelogin";

$conn = mysqli_connect("localhost", "root", "", "gamelogin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fusername = $_POST['user'];
    $fpassword = $_POST['pass'];

    // Check if the username and password are correct
    $check_query = "SELECT * FROM login WHERE username='$fusername' AND password='$fpassword'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Correct credentials, redirect to homePage.html
        header("Location: homePage.html");
        exit();
    } else {
        // Incorrect credentials, display error message
        echo "Invalid username or password. Please try again.";
    }
}
?>
