<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if price and total_price arrays are set and have the same length
    if (isset($_POST['price']) && isset($_POST['total_price']) && count($_POST['price']) == count($_POST['total_price'])) {
        $prices = $_POST['price'];
        $total_prices = $_POST['total_price'];

        // Update prices in the report table
        $update_sql = "UPDATE report SET price = ?, total_price = ? WHERE requesteditem_id = ?";
        $stmt = $conn->prepare($update_sql);

        // Bind parameters and execute for each item
        foreach ($_POST['price'] as $requesteditem_id => $price) {
            $total_price = $_POST['total_price'][$requesteditem_id];
            $stmt->bind_param("ddi", $price, $total_price, $requesteditem_id);
            $stmt->execute();
        }
       
        $stmt->close();

        echo "Prices updated successfully.";
    } else {
        echo "Error: Price and Total Price arrays are not set or have different lengths.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
