<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Set your actual MySQL password here
    $dbname = "gamelogin";

    try {
        // Establish a connection
        $conn = mysqli_connect("localhost", "root", "", "gamelogin");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the input values
            $fname = $_POST['name'];

            // Construct the SQL query to delete the record
            $sql = "DELETE FROM customer WHERE name='$fname'";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            // Check if the deletion was successful
            if ($result) {
                echo "Record deleted successfully";
            } else {
                echo "Failed to delete record";
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
