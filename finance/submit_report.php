<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare update statement
    $update_sql = "UPDATE report SET price = ?, total_price = ?, status = CASE WHEN price != 0 AND total_price != 0 THEN 1 ELSE 0 END WHERE requesteditem_id = ?";
    $stmt = $conn->prepare($update_sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters outside the loop
        $stmt->bind_param("dds", $price, $total_price, $requesteditem_id);

        // Loop through each submitted item
        foreach ($_POST['price'] as $requesteditem_id => $price) {
            // Check if the requested item ID exists in the POST data
            if (isset($_POST['total_price'][$requesteditem_id])) {
                // Escape and assign values
                $price = mysqli_real_escape_string($conn, $price);
                $total_price = mysqli_real_escape_string($conn, $_POST['total_price'][$requesteditem_id]);
                $requesteditem_id = mysqli_real_escape_string($conn, $requesteditem_id);

                // Execute the statement
                if (!$stmt->execute()) {
                    echo "Error updating record: " . $stmt->error;
                }
            }
        }
        // Close the statement
        $stmt->close();
        // Close the database connection
        $conn->close();
        // Display success message styled with CSS
        echo '<div class="success-message">Report submitted successfully</div>';
    }
} else {
    echo "No data submitted";
}
?>
