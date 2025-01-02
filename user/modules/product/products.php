<?php
// Include DB config
session_start();


if (isset($_GET['cat']) && ($_GET['cat'] != '0')) {
    $categoryID = $_GET['cat'];
    $sql_product = "SELECT * FROM product WHERE categoryID = $categoryID";
} else {
    $sql_product = "SELECT * FROM product";
}

$result = mysqli_query($conn, $sql_product);
$rowcount = mysqli_num_rows($result);
?>

<div class="product-container">
    <?php
    if ($rowcount > 0) { 
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="http://localhost/ppms/' . $row["productImg"] . '" alt="' . $row["productName"] . '">';
            echo '<h3>' . $row["productName"] . '</h3>';
            echo '<p> Product ID : ' . $row["productID"] . '</p>';
            echo '<p> RM ' . $row["productPrice"] . '</p>';
            echo '<form method="post" action="modules/cart/cart_action.php?action=add&id=' . $row['productID'] . '">
            <input type="number" name="quantity" value="1" min="1" max="999"/>
            <button type="submit"><i class="fa fa-shopping-cart" style="font-size:20px"></i></button>
            </form>';
            echo '<br></div>';
        }
    } else {
        echo "No products found.";
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</div>