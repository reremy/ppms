<?php
// Start session and include the database configuration
session_start();
include("../../../config/config.php");

// Fetch blogs from the database
$sql_blog = "SELECT * FROM blog ORDER BY updatedDate DESC";
$result = mysqli_query($conn, $sql_blog);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blogs</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <style>
    body {
        font-family: 'Raleway', sans-serif;
    }

    .blog-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin: 20px;
    }

    .blog-card {
        width: 300px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .blog-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .blog-card h3 {
        font-size: 1.2em;
        margin: 10px;
        color: #333;
    }

    .blog-card p {
        font-size: 0.9em;
        color: #666;
        margin: 0 10px 10px;
    }

    .blog-card a {
        display: block;
        margin: 10px;
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }

    .blog-card a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="userTopNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/user/index.php"><img src="http://localhost/ppms/img/logo.png" alt="logo"
                    class="logo"></a>
        </div>

        <div class="userNav">
            <!-- Include user navigation -->
            <?php include("../../includes/userNav.php"); ?>
        </div>
    </div>

    <div>
        <!-- "Hi, username", cart icon, profile icon, sign out icon -->
        <p>hello, username</p>


        <a href="http://localhost/ppms/user/modules/cart/cart_action.php"><i class="fa fa-shopping-cart"></i></a>

        <a href="http://localhost/ppms/user/modules/profile/profile.php"><i class="fa fa-user"></i></a>

        <a href="http://localhost/ppms/signout/logout.php"><i class="fa fa-sign-out"></i></a>
    </div>

    <main>
        <h2 style="text-align: center;">Blogs</h2>
        <div class="blog-container">
            <?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="blog-card">';
        
        // Display blog image if available; otherwise, show default image
        if (!empty($row['blogImg'])) {
            echo '<img src="http://localhost/ppms/admin/modules/blogs/' . $row["blogImg"] . '" alt="' . $row["blogEntry"] . '">';
        } else {
            echo '<img src="http://localhost/ppms/img/default_blog.png" alt="Default Blog Image">';
        }
        
        // Display blog title and author
        echo '<h3>' . htmlspecialchars($row["blogEntry"]) . '</h3>';
        if (!empty($row["updatedDate"]) && strtotime($row["updatedDate"])) {
            $formattedDate = date("F j, Y", strtotime($row["updatedDate"]));
        } else {
            $formattedDate = "Unknown Date";
        }
        echo '<p><small>By ' . htmlspecialchars($row["createdBy"]) . ' on ' . $formattedDate . '</small></p>';
        
        echo '</div>';
    }
} else {
    echo '<p style="text-align: center;">No blogs available at the moment.</p>';
}
?>

        </div>
    </main>

    <footer class="footer">
        <p>Copyright &copy; 2024 FCI</p>
    </footer>

</body>

</html>