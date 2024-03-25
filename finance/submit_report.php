<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare update statement
    $update_sql = "UPDATE report SET price = ?, total_price = ?, status = 0 WHERE requesteditem_id = ?";
    $stmt = $conn->prepare($update_sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
    } else {
        // Loop through each submitted item
        foreach ($_POST['price'] as $requesteditem_id => $price) {
            // Check if the requested item ID exists in the POST data
            if (isset($_POST['total_price'][$requesteditem_id])) {
                // Escape and bind parameters
                $price = mysqli_real_escape_string($conn, $price);
                $total_price = mysqli_real_escape_string($conn, $_POST['total_price'][$requesteditem_id]);
                
                // Bind parameters
                $stmt->bind_param("dds", $price, $total_price, $requesteditem_id);

                // Execute the statement
                if (!$stmt->execute()) {
                    echo "Error updating record: " . $stmt->error;
                }
            }
        }
        echo "Report submitted successfully";
    }
    // Close the statement
    $stmt->close();
} else {
    echo "No data submitted";
}

$conn->close();
?>
