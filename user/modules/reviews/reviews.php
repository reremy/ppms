<?php
// Start session and include the database configuration
session_start();
include("../../../config/config.php");

// Fetch reviews from the database
$sql_reviews = "
    SELECT r.reviewID, r.reviewText, r.rating, r.reviewDate, r.reviewBy, p.productName 
    FROM review r 
    INNER JOIN product p ON r.productID = p.productID 
    ORDER BY r.reviewDate DESC";
$result = mysqli_query($conn, $sql_reviews);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reviews</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <style>
    body {
        font-family: 'Raleway', sans-serif;
    }

    .review-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin: 20px;
    }

    .review-card {
        width: 300px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .review-card h3 {
        font-size: 1.2em;
        margin: 10px;
        color: #333;
    }

    .review-card p {
        font-size: 0.9em;
        color: #666;
        margin: 0 10px 10px;
    }

    .review-card small {
        font-size: 0.8em;
        color: #999;
        display: block;
        margin: 5px 10px;
    }

    .review-card .rating {
        color: #FFD700;
        font-weight: bold;
        margin: 5px 10px;
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



    <main>
        <h2 style="text-align: center;">Reviews</h2>

        <div>
            <a href="http://localhost/ppms/user/modules/reviews/createReviewForm.php">Make Review</a>
        </div>

        <div class="review-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $reviewDate = strtotime($row["reviewDate"]);
                    $isNew = (time() - $reviewDate <= 604800); // 7 days
                    $cardClass = $isNew ? "review-card new-review" : "review-card";

                    echo "<div class='$cardClass'>";
                    echo '<h3>' . htmlspecialchars($row["productName"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($row["reviewText"]) . '</p>';
                    echo '<div class="rating">Rating: ' . str_repeat('⭐', $row["rating"]) . '</div>';
                    echo '<small>Reviewed by User ' . htmlspecialchars($row["reviewBy"]) . ' on ' . date("F j, Y, g:i a", strtotime($row["reviewDate"])) . '</small>';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align: center;">No reviews yet. <a href="createReviewForm.php">Be the first to leave a review!</a></p>';
            }

            // Free the result and close the connection
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
        </div>
    </main>

    <footer class="footer">
        <p>Copyright &copy; 2024 FCI</p>
    </footer>

</body>

</html>