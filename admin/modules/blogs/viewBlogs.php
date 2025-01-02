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
            <p>hello, admin</p>
        </div>
    </div>

    <?php include("../../includes/sideNav.php"); ?>

    <div class="main">
        <h2 style="text-align: center;">Blog List</h2>

        <div class="rowform">
            <?php
            // Check for delete request
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
                $blogID = intval($_GET['id']);
                $sql_delete = "DELETE FROM blog WHERE blogID = ?";
                $stmt = mysqli_prepare($conn, $sql_delete);
                mysqli_stmt_bind_param($stmt, "i", $blogID);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Blog ID $blogID deleted successfully.</p>";
                } else {
                    echo "<p>Error deleting blog: " . mysqli_error($conn) . "</p>";
                }

                mysqli_stmt_close($stmt);
            }

            $sql_blog = "SELECT b.blogID, b.blogEntry, b.blogImg, b.createdBy, b.updatedDate 
            FROM blog b 
            ORDER BY b.blogID ASC";

            $result = mysqli_query($conn, $sql_blog);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";               
                echo "<th>Blog ID</th>";

                echo "<th>Blog Entry</th>";
                echo "<th>Blog Image</th>";
                echo "<th>created by</th>";
                echo "<th>Time</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create table rows based on output data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";                    
                    echo "<td>" . htmlspecialchars($row["blogID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["blogEntry"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["blogImg"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["createdBy"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["updatedDate"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editBlogs.php?id=" . urlencode($row["blogID"]) . "'>Edit</a> | ";
                    echo "<a href='?action=delete&id=" . urlencode($row["blogID"]) . "' onclick='return confirm(\"Are you sure you want to delete this blog?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
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