<?php
include("db_connect.php");

// Clear existing data from the report table
$clear_sql = "TRUNCATE TABLE report";
if ($conn->query($clear_sql) === TRUE) {
    // Insert data into the report table
    $insert_sql = "INSERT INTO report (requesteditem_name, requesteditem_type, requesteditem_description, requesteditem_measurment, requesteditem_quantity, requesteditem_id)
                    SELECT name, type, description, measurment, quantity, id FROM requesteditem WHERE status = 1";

    if ($conn->query($insert_sql) === TRUE) {
        echo "Generated report<br>";

        // Fetch data from the report table
        $select_sql = "SELECT * FROM report WHERE status = 0"; // Select only rows with status = 0
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {
            echo "<form action='submit_report.php' method='post'>
                    <table>
                        <tr>
                            
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["requesteditem_name"] . "</td>
                        <td>" . $row["requesteditem_type"] . "</td>
                        <td>" . $row["requesteditem_description"] . "</td>
                        <td>" . $row["requesteditem_measurment"] . "</td>
                        <td>" . $row["requesteditem_quantity"] . "</td>
                        <td>" . $row["requesteditem_id"] . "</td>
                        <td><input type='number' name='price[" . $row["requesteditem_id"] . "]' value='" . ($row["price"] ?? '') . "'></td>
                        <td><input type='number' name='total_price[" . $row["requesteditem_id"] . "]' value='" . ($row["total_price"] ?? '') . "'></td>
                      </tr>";
            }
            echo "</table>
                  <input type='submit' value='Submit Report'>
                  </form>";

            // Process submitted prices and total prices
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($_POST['price'] as $requesteditem_id => $price) {
                    $price = floatval($price);
                    $total_price = floatval($_POST['total_price'][$requesteditem_id]);
                    $update_sql = "UPDATE report SET price = $price, total_price = $total_price WHERE requesteditem_id = $requesteditem_id";
                    if ($conn->query($update_sql) !== TRUE) {
                        echo "Error updating record: " . $conn->error;
                    }
                }
            }
        } else {
            echo "0 results";
        }
    } else {
        echo "Error inserting data into report table: " . $conn->error;
    }
} else {
    echo "Error clearing report table: " . $conn->error;
}

$conn->close();
?>
