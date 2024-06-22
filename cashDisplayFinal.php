<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cdn5.vectorstock.com/i/1000x1000/30/49/organic-green-leaf-natural-logo-vector-20093049.jpg">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid gray;
            padding: 8px;
        }

        th {
            background-color: lightgray;
            font-size: 17px;
            text-align: center;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
            padding-bottom: 20px;       
            font-family: 'Times New Roman', Times, serif; 
        }
    </style>
</head>
<body>
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

// Fetch records from the cash table
$sql = "SELECT name, total_price, profit FROM cash";
$result = mysqli_query($conn, $sql);

// Check if any rows are returned
if (mysqli_num_rows($result) > 0) {
    // Output the data as a table with border
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Total Price</th><th>Profit</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["total_price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["profit"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found";
}

// Close connection
mysqli_close($conn);
?>

</body>
</html>