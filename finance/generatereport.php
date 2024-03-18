<?php

include("db_connect.php");

$clear_sql = "TRUNCATE TABLE report";
if ($conn->query($clear_sql) === TRUE) {
    $insert_sql = "INSERT INTO report (requesteditem_name, requesteditem_type, requesteditem_description, requesteditem_measurment, requesteditem_quantity, requesteditem_id)
            SELECT name, type, description, measurment, quantity, id FROM requesteditem WHERE status = 1";

    if ($conn->query($insert_sql) === TRUE) {
        echo "Generated report<br>";
        
        $select_sql = "SELECT * FROM report";
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {
            echo "<form action='submit_report.php' method='post'>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Measurment</th>
                            <th>Quantity</th>
                            <th>ID</th>
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
                        <td><input type='text' name='price[]' value='" . $row["price"] . "'></td>
                        <td><input type='text' name='total_price[]' value='" . $row["total_price"] . "'></td>
                      </tr>";
            }
            echo "</table>
                  <input type='submit' value='Submit Report'>
                  </form>";
        } else {
            echo "0 results";
        }
    } else {
        if ($conn->errno == 1062) { // Duplicate entry error number
            echo "Error: Duplicate entry found. Please handle duplicates appropriately.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error clearing report table: " . $conn->error;
}

$conn->close();
?>