<?php include("../../config/config.php"); ?>
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

    <div>
        <?php include("../../includes/sideNav.php") ?>
    </div>

    <div class="main">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle form submission
            $reviewerName = $_POST['reviewerName'];
            $reviewText = $_POST['reviewText'];
            $rating = $_POST['rating'];
            $productID = $_POST['productID'];
            $reviewDate = date("Y-m-d");

            $sql = "INSERT INTO review (reviewerName, reviewText, rating, productID, reviewDate) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdis", $reviewerName, $reviewText, $rating, $productID, $reviewDate);

            if (mysqli_stmt_execute($stmt)) {
                echo "<br><p>New review has been submitted successfully.</p>";
            } else {
                echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            // Display the form
        ?>
        <h2 style="text-align:center;">Review Form</h2>
        <div class="rowform">
            <form action="" method="POST">
                <label for="reviewerName">Reviewer Name:</label><br>
                <input type="text" id="reviewerName" name="reviewerName" required><br><br>

                <label for="reviewText">Review Text:</label><br>
                <textarea id="reviewText" name="reviewText" rows="5" cols="50" required></textarea><br><br>

                <label for="rating">Rating:</label><br>
                <input type="number" id="rating" name="rating" min="1" max="5" step="1" required><br><br>

                <label for="productID">Product ID:</label><br>
                <select name="productID" id="productID" required>
                    <option value="">Select Product</option>
                    <?php
                    $productSql = "SELECT productID, productName FROM product";
                    $productResult = mysqli_query($conn, $productSql);
                    while ($productRow = mysqli_fetch_assoc($productResult)) {
                        echo "<option value='" . $productRow['productID'] . "'>" . htmlspecialchars($productRow['productName']) . "</option>";
                    }
                    ?>
                </select><br><br>

                <button type="submit">Submit</button>
            </form>
        </div>
        <?php
        }
        mysqli_close($conn);
        ?>
    </div>

    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>