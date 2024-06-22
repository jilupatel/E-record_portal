<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Set your actual MySQL password here
    $dbname = "gamelogin";

    try {
        $conn = mysqli_connect("localhost", "root", "", "gamelogin");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $fname = $_POST['name'];
        $fnumber = $_POST['number'];
        $faddress = $_POST['address'];

        $data = "INSERT INTO customer (name, number, address) VALUES ('$fname', '$fnumber', '$faddress')";
        $check = mysqli_query($conn, $data);
        // $check = $conn->query($data);

        if ($check) {
            echo "Data transferred successfully";
        } else {
            echo "Failed";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
