<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
</head>
<body>
    <h2>Item Details</h2>
    <p>Name: <?php echo $_GET['name']; ?></p>
    
    <?php
    for ($i = 1; isset($_GET['item' . $i]); $i++) {
        echo "<p>Item $i: {$_GET['item' . $i]}</p>";
        echo "<p>Quantity $i: {$_GET['quantity' . $i]}</p>";
        echo "<p>Price $i: {$_GET['price' . $i]}</p>";
    }
    ?>
    <h3>Total Amount: <?php echo $_GET['total']; ?></h3>
    
</body>
</html>
