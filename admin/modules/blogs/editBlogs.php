<?php
//include db config
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $blogID = intval($_GET['id']);

    $sql = "SELECT * FROM blog WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $blogEntry = $row['blogEntry'];
        $blogImg = $row['blogImg'];
        $createdBy = $row['createdBy'];
        $updatedDate = $row['updatedDate'];
    } else {
        echo "Blog not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Blog Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogEntry = $row['blogEntry'];
    $createdBy = $row['createdBy'];
    $updatedDate = $row['updatedDate'];

    $uploadDir = '../../../uploads/';
    $blogImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['blogImg']) && $_FILES['BlogImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['blogImg']['tmp_name'];
        $fileName = basename($_FILES['blogImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT blogImg FROM blog WHERE blogID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $blogID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $blog = mysqli_fetch_assoc($result);

            if ($blog && $blog['blogImg'] && file_exists($uploadDir . $blog['blogImg'])) {
                unlink($uploadDir . $blog['blogImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $blogImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $blogImg = "uploads/" . $image;
        echo $blogImg;
        $sql = "UPDATE blog SET blogEntry = ?, blogImg = ?, createdBy = ?, updatedDate = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssidi", $blogEntry, $blogImg, $createdBy, $updatedDate, $blogID);
    } else {
        $sql = "UPDATE blog SET blogEntry = ?, blogImg = ?, createdBy = ?, updatedDate = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssidi", $blogEntry, $blogImg, $createdBy, $updatedDate, $blogID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Blog updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: viewBlogs.php");
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

    <?php include("../../includes/sideNav.php") ?>

    <div class="main">
        <h2 style="text-align: center;">Edit Blog ID : <?= $blogID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blogID" value="<?= isset($blogID) ? htmlspecialchars($blogID) : 'NONE'; ?>">
                <label for="blogEntry">Blog Entry:</label>
                <input type="text" id="blogEntry" name="blogEntry" value="<?= htmlspecialchars($blogEntry) ?>"
                    required><br><br>
                <label for="createdBy">created by:</label>
                <input type="text" id="createdBy" name="createdBy" value="<?= htmlspecialchars($createdBy) ?>"
                    required><br><br>
                <label for="updatedDate">updated date:</label>
                <input type="date" id="updatedDate" name="updatedDate" value="<?= htmlspecialchars($updatedDate) ?>"
                    required><br><br>
                <label for="blog_image">Blog Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($blogImg) ?>"
                    style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="productImg" name="productImg" accept="image/*"><br><br>
                <button type="submit">Update</button>

            </form>
        </div>
    </div>
    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>