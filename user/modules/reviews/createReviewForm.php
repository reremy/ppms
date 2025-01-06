<?php
session_start();
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $conn->real_escape_string($_POST['productID']);
    $reviewText = $conn->real_escape_string($_POST['reviewText']);
    $rating = (int)$_POST['rating'];
    $reviewBy = $_SESSION['userID']; // Assuming you store user ID in session

    // Validate productID
    $sql_check_product = "SELECT productID FROM product WHERE productID = '$productID'";
    $product_result = $conn->query($sql_check_product);

    if ($product_result->num_rows === 0) {
        echo "<p style='color: red;'>Invalid Product ID.</p>";
    } elseif ($rating < 1 || $rating > 5) {
        echo "<p style='color: red;'>Rating must be between 1 and 5.</p>";
    } elseif (empty($reviewText)) {
        echo "<p style='color: red;'>Review text cannot be empty.</p>";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO review (productID, reviewText, rating, reviewBy, reviewDate) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssii", $productID, $reviewText, $rating, $reviewBy);

        if ($stmt->execute()) {
            header("Location: reviews.php?success=1");
            exit();
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Review</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <style>
    body {
        font-family: 'Raleway', sans-serif;
        margin: 0;
        padding: 0;
    }

    .review-form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .review-form-container h2 {
        text-align: center;
    }

    .review-form-container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: bold;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    </style>



</head>

<body>
    <div class="userTopNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/user/index.php"><img src="http://localhost/ppms/user/img/logo.png" alt="logo"
                    class="logo"></a>
        </div>

        <div class="userNav">
            <!-- Include user navigation -->
            <?php include("../../includes/userNav.php"); ?>
        </div>

        <div>
            <!-- "Hi, username", cart icon, profile icon, sign out icon -->
            <p>hello, username</p>

            <a href="http://localhost/ppms/user/modules/cart/cart_action.php"><i class="fa fa-shopping-cart"></i></a>

            <a href="http://localhost/ppms/user/modules/profile/profile.php"><i class="fa fa-user"></i></a>

            <a href="http://localhost/ppms/singout/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>
    </div>

    <div class="review-form-container">
        <h2>Create a Review</h2>
        <form method="POST" action="">
            <label for="productID">Product ID:</label>
            <input type="text" id="productID" name="productID" required>

            <label for="reviewText">Review:</label>
            <textarea id="reviewText" name="reviewText" rows="4" required></textarea>

            <label for="rating">Rating (1 to 5):</label>
            <select id="rating" name="rating" required>
                <option value="1">1 - Very Poor</option>
                <option value="2">2 - Poor</option>
                <option value="3">3 - Average</option>
                <option value="4">4 - Good</option>
                <option value="5">5 - Excellent</option>
            </select>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>

</html>