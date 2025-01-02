<?php
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);

    // Fetch current user data
    $sql_user = "SELECT userID, userName, userEmail, userRoles FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $userName = $row['userName'];
        $userEmail = $row['userEmail'];
        $userRoles = $row['userRoles'];
    } else {
        echo "<p>User not found!</p>";
        exit;
    }
    
    mysqli_stmt_close($stmt);

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userName = $_POST['userName'];
        $userEmail = $_POST['userEmail'];
        $userRoles = $_POST['userRoles'];

        // Update the user details
        $sql_update = "UPDATE user SET userName = ?, userEmail = ?, userRoles = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssii", $userName, $userEmail, $userRoles, $userID);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>User updated successfully.</p>";
        } else {
            echo "<p>Error updating user: " . mysqli_error($conn) . "</p>";
        }

        mysqli_stmt_close($stmt);
    }
} else {
    echo "<p>No user ID provided.</p>";
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
            <p>Hello, admin</p>
        </div>
    </div>

    <?php include("../../includes/sideNav.php"); ?>

    <div class="main">
        <h2 style="text-align: center;">Edit User</h2>

        <div class="rowform">
            <form action="" method="POST">
                <label for="userName">User Name:</label><br>
                <input type="text" id="userName" name="userName" value="<?php echo htmlspecialchars($userName); ?>"
                    required><br><br>

                <label for="userEmail">User Email:</label><br>
                <input type="email" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>"
                    required><br><br>

                <label for="userRoles">User Role:</label><br>
                <select name="userRoles" id="userRoles" required>
                    <option value="1" <?php if ($userRoles == 1) echo 'selected'; ?>>Admin</option>
                    <option value="2" <?php if ($userRoles == 2) echo 'selected'; ?>>User</option>
                </select><br><br>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>