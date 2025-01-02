<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'ppms');  // Update with actual credentials

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Query to check if user exists with the provided email
    $sql = "SELECT userID, userName, userPwd, userRoles FROM user WHERE userEmail = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            if (password_verify($userPassword, $row['userPwd'])) {
                // Start session and store user data
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['userName'] = $row['userName'];
                $_SESSION['userRoles'] = $row['userRoles'];
                
                // Redirect to dashboard based on user role
                if ($row['userRoles'] == 1) {
                    // Redirect to admin dashboard
                    header("Location: http://localhost/ppms/admin/index.php");
                } else {
                    // Redirect to user dashboard
                    header("Location: http://localhost/ppms/user/index.php");
                }
                exit();
            } else {
                echo "<p>Invalid email or password.</p>";
            }
        } else {
            echo "<p>User not found.</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Failed to prepare SQL query.</p>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/ppms/welcome.css">

    <title>Login</title>
</head>

<body>
    <h1>Login</h1>

    <form action="" method="POST">
        <label for="userEmail">Email:</label>
        <input type="email" id="userEmail" name="userEmail" required>
        <br>

        <label for="userPassword">Password:</label>
        <input type="password" id="userPassword" name="userPassword" required>
        <br>

        <button type="submit">Login</button>
        <button type="reset">Reset</button>
    </form>
</body>

</html>