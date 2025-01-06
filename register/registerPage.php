<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ppms");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $conn->real_escape_string($_POST['username']);
    $userEmail = $conn->real_escape_string($_POST['userEmail']);
    $userPwd = $conn->real_escape_string($_POST['userPwd']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Password matching validation
    if ($userPwd !== $confirmPassword) {
        echo "<p style='color: red;'>Passwords do not match. Please try again.</p>";
    } else {
        // Check if the email already exists
        $checkEmail = "SELECT * FROM user WHERE userEmail = '$userEmail'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo "<p style='color: red;'>This email is already registered. Please use a different email.</p>";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($userPwd, PASSWORD_DEFAULT);

            // Insert data into the database
            $sql = "INSERT INTO user (userName, userEmail, userPwd) VALUES ('$userName', '$userEmail', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='color: green;'>Registration successful!</p>";
                echo "<a href='http://localhost/ppms/login/loginPage.php'>Go to Login Page</a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>

    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br>

        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" name="userEmail" required><br>

        <label for="userPwd">Password</label>
        <input type="password" id="userPwd" name="userPwd" required><br>

        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br>

        <button type="submit">Register</button>
        <button type="reset">Reset</button>
    </form>
</body>

</html>