<?php
/***
 * Author: Evan Deal
 * Date: today's date
 * Description: this script displays shopping cart content.
 * @var object $conn
 */


$page_title = "Shopping Cart";
require_once('includes/header.php');
require_once('includes/database.php');

if (!isset($_SESSION['cart']) || !$_SESSION['cart']) {
    echo "Your shopping cart is empty.<br><br>";
    include('includes/footer.php');
    exit();
}

//proceed since the cart is not empty
$cart = $_SESSION['cart'];

?>
    <h2> My Shopping Cart</h2>
    <!--  display shopping cart content -->
    <div class="productlist">
        <div class="row header">
            <div class="col1">Product</div>
            <div class="col2">Price</div>
            <div class="col3">Quantity</div>
            <div class="col4">Subtotal</div>
        </div>

        <?php
        //select statement
        $sql = "SELECT product_id, product, price FROM products WHERE 0 ";

        foreach (array_keys($cart) as $product_id) {
            $sql .= " OR product_id=$product_id ";
        }
        //exectue the query
        $query = $conn->query($sql);

        while ($row = $query->fetch_assoc()) {
            $product_id = $row['product_id'];
            $product = $row['product'];
            $price = $row['price'];
            $qty = $cart[$product_id];
            $subtotal = $qty * $price;
            ?>
            <div class="row">
                <div class="col1"><a href="productdetails.php?id=<?= $product_id ?>"><?= $product ?></a></div>
                <div class="col2">$<?= $price ?></div>
                <div class="col3"><?= $qty ?></div>
                <div class="col4">$<?php printf("%.2f", $subtotal); ?></div>
                <!-- lmao this div is temporary style -->
                <div style="width: 40px"></div>
                <input type="button" value="Edit Product" onclick="window.location.href=
                        'editcartproduct.php?id=<?= $product_id ?>'">
                <input type="button" value="Remove Product" onclick="window.location.href=
                        'deletecartproduct.php?id=<?= $product_id ?>'">
            </div>
        <?php } ?>
    </div>

    <br><hr>
    <div class="bookstore-button" style="text-align: center;">
        <input style="width: 110px;" type="button" value="Checkout" onclick="window.location.href = 'checkout.php'"/>
        <input style="width: 110px;" type="button" onclick="window.location.href='products.php'" value="Keep Exploring">
    </div>

    <!-- page footer for copyright information -->
<?php
include('includes/footer.php');