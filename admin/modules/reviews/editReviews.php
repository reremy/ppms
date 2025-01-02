<?php 
// Include database configuration
include("../../config/config.php");

// Check if review ID is provided
if (isset($_GET['id'])) {
    $reviewID = intval($_GET['id']);

    // Retrieve the existing review data using a prepared statement
    $sql = "SELECT * FROM review WHERE reviewID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $reviewID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $reviewText = $row['reviewText'];
        $rating = $row['rating'];
        $productID = $row['productID'];
        $reservationID = $row['reservationID'];
    } else {
        echo "Review not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Review Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewText = $_POST['reviewText'];
    $rating = intval($_POST['rating']);
    $productID = intval($_POST['productID']);
    $reservationID = intval($_POST['reservationID']);

    $sql = "UPDATE review SET reviewText = ?, rating = ?, productID = ?, reservationID = ? WHERE reviewID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "siiii", $reviewText, $rating, $productID, $reservationID, $reviewID);

    if (mysqli_stmt_execute($stmt)) {
        echo "Review updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect to viewReview.php
    header("Location: viewReviews.php");
    exit;
}
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
        <h2 style="text-align: center;">Edit Review ID : <?= $reviewID ?></h2>
        <div class="rowform">
            <form action="" method="POST">
                <input type="hidden" name="reviewID"
                    value="<?= isset($reviewID) ? htmlspecialchars($reviewID) : 'NONE'; ?>">
                <label for="reviewText">Review Text:</label>
                <textarea id="reviewText" name="reviewText" rows="4" cols="50"
                    required><?= htmlspecialchars($reviewText) ?></textarea><br><br>
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" value="<?= htmlspecialchars($rating) ?>"
                    required><br><br>
                <label for="productID">Product ID:</label>
                <input type="number" id="productID" name="productID" value="<?= htmlspecialchars($productID) ?>"
                    required><br><br>
                <label for="reservationID">Reservation ID:</label>
                <input type="number" id="reservationID" name="reservationID"
                    value="<?= htmlspecialchars($reservationID) ?>" required><br><br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>