<?php
// Start session
session_start();
include("../../../config/config.php");

// Include database connection

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../../../user/login/loginPage.php");
    exit();
}

// Get the logged-in user's ID
$userID = $_SESSION['userID'];

// Fetch user information from the database
$sql = "SELECT userName, userEmail, userRoles FROM user WHERE userID = $userID";
$result = mysqli_query($conn, $sql);

// Check if the query succeeded and the user exists
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $userName = htmlspecialchars($user['userName']);
    $userEmail = htmlspecialchars($user['userEmail']);
    $userRole = $user['userRoles'] == 1 ? "System Admin" : "Normal User";
} else {
    echo "Error: User not found.";
    exit();
}

// Close the database connection
mysqli_free_result($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

</head>

<body>
    <div class="userTopNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/user/index.php"><img src="http://localhost/ppms/img/logo.png" alt="logo"
                    class="logo"></a>
        </div>

        <div class="userNav">
            <!-- user navigation:home|blogs|reviews -->
            <?php include("../../includes/userNav.php"); ?>
        </div>

        <div>
            <!-- "Hi, username", cart icon, profile icon, sign out icon -->
            <p>hello, username</p>

            <a href="http://localhost/ppms/user/modules/cart/cart_action.php"><i class="fa fa-shopping-cart"></i></a>

            <a href="http://localhost/ppms/user/modules/profile/profile.php"><i class="fa fa-user"></i></a>

            <a href="http://localhost/ppms/singout/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

        <div>
            <h2>Profile Details</h2>
            <p><strong>Username:</strong> <?php echo $userName; ?></p>
            <p><strong>Email:</strong> <?php echo $userEmail; ?></p>
            <p><strong>Role:</strong> <?php echo $userRole; ?></p>
            <a href="../../../user/signout.php">Sign Out</a>
        </div>
    </div>
</body>

</html>