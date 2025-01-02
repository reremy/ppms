<?php
//include db config
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);

    // Another example to retrieve the existing product data using prepared statement
    $sql = "SELECT * FROM product WHERE productID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['productName'];
        $productPrice = $row['productPrice'];
        $productQty = $row['productQty'];
        $productImg = $row['productImg'];
    } else {
        echo "Product not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Product Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $productQty = $_POST['productQty'];
    $productPrice = $_POST['productPrice'];

    $uploadDir = '../../../uploads/';
    $productImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['productImg']) && $_FILES['productImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['productImg']['tmp_name'];
        $fileName = basename($_FILES['productImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT productImg FROM product WHERE productID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $productID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);

            if ($product && $product['productImg'] && file_exists($uploadDir . $product['productImg'])) {
                unlink($uploadDir . $product['productImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $productImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $productImg = "uploads/" . $image;
        echo $productImg;
        $sql = "UPDATE product SET productName = ?, productPrice = ?, productQty = ?, productImg = ? WHERE productID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdisi", $productName, $productPrice, $productQty, $productImg, $productID);
    } else {
        $sql = "UPDATE product SET productName = ?, productPrice = ?, productQty = ? WHERE productID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdii", $productName, $productPrice, $productQty, $productID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: viewProduct.php");
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
        <h2 style="text-align: center;">Edit Product ID : <?= $productID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="productID"
                    value="<?= isset($productID) ? htmlspecialchars($productID) : 'NONE'; ?>">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($productName) ?>"
                    required><br><br>
                <label for="productPrice">Product Price:</label>
                <input type="text" id="productPrice" name="productPrice" value="<?= htmlspecialchars($productPrice) ?>"
                    required><br><br>
                <label for="productQty">Product Quantity:</label>
                <input type="text" id="productQty" name="productQty" value="<?= htmlspecialchars($productQty) ?>"
                    required><br><br>
                <label for="prod_image">Product Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($productImg) ?>"
                    style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="productImg" name="productImg" accept="image/*"><br><br>
                <button type="submit">Update</button>

            </form>
        </div>
    </div>
    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>