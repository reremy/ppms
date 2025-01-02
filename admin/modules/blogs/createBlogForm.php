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
            $blogEntry = $_POST['blogEntry'];
            $createdBy = $_POST['createdBy'];
            $updatedDate = $_POST['updatedDate'];

            $target_dir = "../../../uploads/";
            $target_path = "uploads/";
            $target_file = $target_dir . basename($_FILES["blogImg"]["name"]);
            $target_fileDB = $target_path . basename($_FILES["blogImg"]["name"]);
            $upload_ok = 1;

            $check = getimagesize($_FILES["blogImg"]["tmp_name"]);
            if ($check !== false) {
                $upload_ok = 1;
            } else {
                echo "File is not an image.";
                $upload_ok = 0;
            }

            if ($upload_ok && move_uploaded_file($_FILES["blogImg"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO blog (blogEntry, blogImg, createdBy, updatedDate) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "siss", $blogEntry,  $target_fileDB, $createdBy, $updatedDate);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<br><p>New blog has been created successfully.</p>";
                } else {
                    echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error in uploading your file.";
            }
        } else {
            // Display the form
        ?>
        <h2 style="text-align:center;">Blog Form</h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="blogEntry">blog entry:</label><br>
                <input type="text" id="blogEntry" name="blogEntry" required><br><br>

                <label for="craetedBy">Created By:</label><br>
                <input type="number" id="createdBy" name="createdBy" required><br><br>

                <label for="udpatedDAte">Date:</label><br>
                <input type="date" id="updatedDate" name="updatedDate" required><br><br>

                <!-- <label for="categoryID">Product Category:</label><br>
                <select name="categoryID" id="categoryID" required>
                    <option value="">Select Category</option>
                    <option value="1">Books</option>
                    <option value="2">Coffee</option>
                    <option value="3">Food</option>
                    <option value="4">Desserts</option>
                    <option value="5">Magazine</option>
                </select><br><br> -->

                <label for="blogImg">Blog Image:</label><br>
                <input type="file" id="blogImg" name="blogImg" accept="image/*" required><br><br>

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