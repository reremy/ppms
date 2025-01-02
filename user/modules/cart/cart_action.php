<?php
session_start();
include("../../../config/config.php");

if (!empty($_GET["action"])) {
	switch ($_GET["action"]) {
		case "add":
			if (!empty($_POST["quantity"])) {
				$productID = $_GET["id"];

				$sql = "SELECT * FROM product WHERE productID = '$productID'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				$pid = "pid" . $row["productID"];

				$itemArray = array(
					$pid => array('name' => $row["productName"], 'img' => $row["productImg"], 'prodID' => $row["productID"], 'quantity' => $_POST["quantity"], 'price' => $row["productPrice"])
				);

				if (!empty($_SESSION["cart_item"])) {
					if (in_array($pid, array_keys($_SESSION["cart_item"]))) {
						foreach ($_SESSION["cart_item"] as $k => $v) {
							if ($pid == $k) {
								if (empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			break;
		case "remove":
			if (!empty($_SESSION["cart_item"])) {
				foreach ($_SESSION["cart_item"] as $k => $v) {
					if ("pid" . $_GET["prodID"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if (empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
				}
			}
			break;
		case "empty":
			unset($_SESSION["cart_item"]);
			break;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Product Portfolio Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

            <a href="http://localhost/ppms/signout/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>
        <div class="container">
            <div class="section">
                <?php
			if (isset($_SESSION["cart_item"])) {
				$total_quantity = 0;
				$total_price = 0;
			?>
                <table cellpadding="10" cellspacing="1" id="blogtable" width="100%"
                    style="margin: 0 10px 0 10px;max-width: 900px;">
                    <tbody>
                        <tr>
                            <th style="background-color: #e0e0e0;text-align: center;">Product</th>
                            <th style="background-color: #e0e0e0;text-align: center;">Product ID</th>
                            <th style="background-color: #e0e0e0;text-align: center;">Quantity</th>
                            <th style="background-color: #e0e0e0;text-align: center;">Unit Price (RM)</th>
                            <th style="background-color: #e0e0e0;text-align: center;">Price (RM)</th>
                            <th style="background-color: #e0e0e0;text-align: center;">Actions</th>
                        </tr>

                        <?php
						foreach ($_SESSION["cart_item"] as $item) {
							$item_price = $item["quantity"] * $item["price"];
						?>
                        <tr>
                            <td style="text-align:left;"><?php echo $item["name"]; ?></td>
                            <td style="text-align:center;"><?php echo $item["prodID"]; ?></td>
                            <td style="text-align:center;"><?php echo $item["quantity"]; ?></td>
                            <td style="text-align:center;"><?php echo $item["price"]; ?></td>
                            <td style="text-align:center;"><?php echo number_format($item_price, 2); ?></td>
                            <td style="text-align:center;"><a
                                    href="cart_action.php?action=remove&prodID=<?php echo $item["prodID"]; ?>"><i
                                        class="fa fa-times-circle"></i> Remove</a></td>
                        </tr>
                        <?php
							$total_quantity += $item["quantity"];
							$total_price += ($item["price"] * $item["quantity"]);
						}
						?>

                        <tr>
                            <td colspan="2" align="right"><b>Total:</b></td>
                            <td style="text-align:center;"><?php echo $total_quantity; ?></td>
                            <td style="text-align:center;" colspan="2">
                                <strong><?php echo "RM " . number_format($total_price, 2); ?></strong>
                            </td>
                            <form method="post" action="checkout.php?price=<?php echo $total_price; ?>">
                                <input type="hidden" name="tot_price" value="<?php echo $total_price; ?>">
                                <td style="text-align:center;"><button type="submit">Checkout</button></td>
                            </form>
                        </tr>
                    </tbody>
                </table>

                <p style="margin: 15px;"><a href="cart_action.php?action=empty"><i class="fa fa-trash"
                            style="font-size:24px"></i> Empty Cart</a></p>
                <p style="margin: 15px;"><a href="http://localhost/ppms/user/index.php"><i class="fa fa-cart"
                            style="font-size:24px"></i>
                        Continue
                        Shopping</a></p>
                <?php
			} else {
			?>
                <p style="margin: 15px;">Your Cart is Empty</p>
                <?php
			}
			?>
            </div>
        </div>
        <p></p>
        <footer class="footer">
            <p><small><i>Copyright &copy; 2024 FCI</i></small></p>
        </footer>


</body>

</html>