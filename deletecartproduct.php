<?php
/**
 * Author: Thomas Reedy
 * Date: 11/29/2023
 * File: deleteproduct.php
 * Description:
 */

$page_title = "Confirm Product Deletion";
require_once('includes/header.php');
require_once('includes/database.php');


//if product id cannot retrieved, terminate the script.
if (!filter_has_var(INPUT_GET, 'id')) {
    $error = "There was a problem retrieving product id.";
    header("Location: error.php?m=$error");
    die();
}

//sets up cart info
$cart = $_SESSION['cart'];

//retrieve product id from a query string variable.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//select statement
$sql = "SELECT * FROM $tblProducts, $tblTypes WHERE product_id = $id AND type=type_id";

//echo "$sql";
//die();

//connect to query
$query = $conn -> query($sql);

//Handle errors
if (!$query) {
    $error = "Selection failed: " . $conn->error;
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

$row = $query->fetch_assoc();
if (!$row) {
    $error = "Product not found";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

$product_id = $row['product_id'];
$product = $row['product'];
$price = $row['price'];
$qty = $cart[$product_id];
$subtotal = $qty * $price;

?>

    <h2>Item Details</h2>
    <form action="removecartproduct.php" method="post">
        <div class="productlist">
            <div class="row header">
                <!-- display product attributes  -->
                <div class="col1">Product:</div>
                <div class="col2">Description:</div>
                <div class="col3">Price:</div>
                <div class="col4">Product Type:</div>
            </div>
            <div class="row">
                <!-- display product details -->
                <div class="col1"><?= $row['product'] ?></div>
                <div class="col2"><?= $row['product_description'] ?></div>
                <div class="col3"><?= $row['price'] ?></div>
                <div class="col4"><?= $row['category'] ?></div>
            </div>
        </div>

        <!-- Make sure to change the class here -->
        <br><hr>
        <div class="productlist-button" style="text-align: center;">
            <input type="hidden" name="id" value="<?php echo $product_id ?>" />
            <input style="width: 75px;" type="submit" value="Delete">
            <input style="width: 75px;" type="button" value="Cancel"
                   onclick="window.location.href = 'showcart.php?id=<?= $id ?>'">
            <div style="color: red; display: inline-block;">Are you sure you want to delete the product?</div>
        </div>
    </form>

<?php
require_once('includes/footer.php');


