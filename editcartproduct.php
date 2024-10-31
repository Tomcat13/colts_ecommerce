<?php
/**
 * Author: Group
 * Date: 12/05/2023
 * File:
 *  Description: This script displays details of a particular book in a form.
 */
$page_title = "Edit Product Details";
require_once ('includes/header.php');
require_once('includes/database.php');

/*if(!is_admin()) {
    $error = "This features is permitted for admins only";
    header("Location: error.php?m=$error");
}*/


//if book id cannot retrieved, terminate the script.
if (!filter_has_var(INPUT_GET, "id")) {
    $error = "Your request cannot be processed since there was a problem retrieving product id.";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

//sets up cart info
$cart = $_SESSION['cart'];

//retrieve book id from a query string variable.
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//MySQL SELECT statement
$sql = "SELECT * FROM $tblProducts WHERE product_id=$id";


//execute the query
$query = @$conn->query($sql);

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
    <h2>Product Details</h2>
    <form action="updatecartproduct.php" method="post">
        <div class="productlist">
            <div class="row header">
                <!-- display product attributes  -->
                <div class="col1">Product:</div>
                <div class="col2">Price:</div>
                <div class="col3">Quantity:</div>
                <div class="col4">Date:</div>
            </div>

            <div class="row">
                <!-- display book details -->
                <div class="col1"><?php echo $row['product'] ?></div>
                <div class="col2"><?php echo $row['price'] ?></div>
                <div class="col3"><input name="quantity" type="number" step="1" value="<?= $qty ?>" required></div>
                <div class="col4"><?php echo $row['date_id'] ?></div>
            </div>
        </div>

        <br><hr>
        <div class="productlist-button" style="text-align: center;">
            <input type="hidden" name="id" value="<?php echo $product_id ?>" />
            <input style="width: 75px;" type="submit" value=" Update " />
            <input style="width: 75px;" type="button" value="Cancel" onclick="window.location.href='showcart.php?id=<?= $id ?>'" />
        </div>
    </form>
<?php
//$_SESSION = [];
// close the connection.
$conn->close();
require_once 'includes/footer.php';