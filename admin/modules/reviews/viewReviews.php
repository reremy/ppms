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
        <h2 style="text-align: center;">Review List</h2>

        <div class="rowform">
            <?php
            // Check for delete request
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
                $reviewID = intval($_GET['id']);
                $sql_delete = "DELETE FROM review WHERE reviewID = ?";
                $stmt = mysqli_prepare($conn, $sql_delete);
                mysqli_stmt_bind_param($stmt, "i", $reviewID);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Review ID $reviewID deleted successfully.</p>";
                } else {
                    echo "<p>Error deleting record: " . mysqli_error($conn) . "</p>";
                }

                mysqli_stmt_close($stmt);
            }

            // Fetch and display review list
            $sql_review = "SELECT r.reviewID, r.reviewText, r.rating, r.reviewDate, 
                           r.productID, p.productName, r.reviewBy, r.reservationID 
                           FROM review r 
                           JOIN product p ON r.productID = p.productID 
                           ORDER BY r.reviewID ASC";

            $result = mysqli_query($conn, $sql_review);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Review ID</th>";
                echo "<th>Product Name</th>";
                echo "<th>Rating</th>";
                echo "<th>Review Text</th>";
                echo "<th>Review Date</th>";
                echo "<th>Review By</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create table rows based on output data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["reviewID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["productName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reviewText"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reviewDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reviewBy"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editReviews.php?id=" . urlencode($row["reviewID"]) . "'>Edit</a> | ";
                    echo "<a href='?action=delete&id=" . urlencode($row["reviewID"]) . "' onclick='return confirm(\"Are you sure you want to delete this review?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No reviews found.</p>";
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