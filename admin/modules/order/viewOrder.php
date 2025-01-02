<?php
include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
</head>

<body>
    <div class="topNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/admin/"><img src="http://localhost/ppms/img/icon.png" alt="logo"
                    class="logo"></a>
        </div>
        <div>
            <p>Hello, admin</p>
        </div>
    </div>

    <?php include("../../includes/sideNav.php"); ?>

    <div class="main">
        <h2 style="text-align: center;">Order List</h2>

        <div class="rowform">
            <?php
            // Check for delete request
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
                $orderID = intval($_GET['id']);
                $sql_delete = "DELETE FROM orders WHERE orderID = ?";
                $stmt = mysqli_prepare($conn, $sql_delete);
                mysqli_stmt_bind_param($stmt, "i", $orderID);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Order ID $orderID deleted successfully.</p>";
                } else {
                    echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
                }

                mysqli_stmt_close($stmt);
            }

            // Fetch and display order list
            $sql_order = "SELECT orderID, userID, orderAmt, orderDate, status FROM orders ORDER BY orderID ASC";
            $result = mysqli_query($conn, $sql_order);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Order ID</th>";
                echo "<th>User ID</th>";
                echo "<th>Order Amount</th>";
                echo "<th>Order Date</th>";
                echo "<th>Status</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create table rows based on output data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["orderID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["orderAmt"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["orderDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editOrder.php?id=" . urlencode($row["orderID"]) . "'>Edit</a> | ";
                    echo "<a href='?action=delete&id=" . urlencode($row["orderID"]) . "' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No orders found.</p>";
            }

            mysqli_free_result($result);
            ?>
        </div>
    </div>

    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>