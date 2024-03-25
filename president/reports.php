<?php 
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
    $system = $conn->query("SELECT * FROM requesteditem limit 1")->fetch_array();
    foreach($system as $k => $v){
        $_SESSION['system'][$k] = $v;
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Request</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        th {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>&nbsp; ID</th>
                    <th>Name</th>
                    <th>&nbsp; Quantity</th>
                    <th>&nbsp; Price</th>
                    <th>&nbsp; Total Price</th>
                    <th>&nbsp; Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Replace these variables with your actual database connection details
                    include("db_connect.php");

                    // Example query to fetch reports from the database
                    $sql = "SELECT requesteditem_id, requesteditem_name, requesteditem_quantity, price, total_price, id FROM report where status = 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['requesteditem_name']}</td>";
                            echo "<td>{$row['requesteditem_quantity']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td>{$row['total_price']}</td>";
                            echo "<td>
                                    <form method='post'>
                                        <input type='hidden' name='item_id' value='{$row['id']}'>
                                        <button type='submit' name='approve'>Approve Auction</button>
                                        <button type='submit' name='cancel'>Cancel Auction</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No reports available now.</td></tr>";
                    }

                    // Check if the approve button is clicked
                    if (isset($_POST['approve'])) {
                        // Perform approval action here (e.g., update database, send notification)
                        $item_id = $_POST['item_id'];
                        $conn->query("UPDATE report SET auctionstatus = 1 WHERE id = $item_id");
                        echo "<script>alert('Successfully approved auction!');</script>";
                    }

                    // Check if the cancel button is clicked
                    if (isset($_POST['cancel'])) {
                        // Perform cancellation action here (e.g., update database, send notification)
                        $item_id = $_POST['item_id'];
                        $conn->query("UPDATE report SET auctionstatus = 0 WHERE id = $item_id");
                        echo "<script>alert('Auction cancelled!');</script>";
                    }
                    
                    // Close connection
                    $conn->close();
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>
