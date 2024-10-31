<?php
/**
 * Author: Group Project
 * Date: 15/05/2023
 * File: productdetails.php
 *  Description: This script displays details of a particular book.
 *
 * @var object $conn
 * @var string $tblProducts
 */
$page_title = "Colts Products";
require_once ('includes/header.php');
require_once ('includes/database.php');

/*$a = $_GET['id'];
echo gettype($a);
quit();*/

if(!filter_has_var(INPUT_GET, "id")) {
    $error = "Your request cannot be processed since there was a problem with the product id";
    $conn ->close();
    header("Location: error.php?m=$error");
    exit;
}

//retrieve product id
$id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);
//$id = INPUT_GET['id'];
//echo gettype($id);
//select statement
$sql = "SELECT * FROM $tblProducts, $tblTypes WHERE product_id = $id AND type=type_id";

//echo "$sql";
//die();

//execute the query
$query = $conn->query($sql);
//echo $query;
//die();

//handle errors
if(!$query) {
    $error = "Selection failed: " .$conn->error;
    $conn->close();
    header("Location: error.php?m=$error");
    exit;
}
//die();

$row = $query->fetch_assoc();
if(!$row) {
    $error = "Product not found.";
    $conn->close();
    header("Location: error.php?m=$error");
    exit;

}
?>

    <h2>Product Details</h2>
    <div class="productlist">
        <div class="row header">
            <!-- display product attributes  -->
            <div class="col1">Name:</div>
            <div class="col2">Brand:</div>
            <div class="col3">Price:</div>
            <div class="col4">Type:</div>
            <div class="col5">
                <?php //special feature*******************************************************************************************************************
                // Check if the user is logged in
                if (isset($_SESSION['login']) AND isset($_SESSION['name']) AND
                    isset($_SESSION['role'])) {
                    // Retrieve the user role. This could come from a session variable, a database query, etc.
                    $userRole = $_SESSION['role']; //find users role
                    // Check if the user has the desired role
                    if ($userRole == '1') {
                        // Content for admin users
                        echo "<div>Purchase Price:</div>";
                    } else {
                        // Content for other roles or a message
                        echo "<div>This content is only for admin users.</div>";
                    }
                } else {
                    // User is not logged in
                    echo "<div>Please log in to view this content.</div>";
                }
                //special feature*******************************************************************************************************************
                ?>

            </div>
        </div>
        <div class="row">
            <!-- display product details -->
            <div class="col1"><?= $row['product'] ?></div>
            <div class="col2"><?= $row['brand'] ?></div>
            <div class="col3">$<?= $row['price'] ?></div>
            <div class="col4"><?= $row['category'] ?></div>
            <?php //special feature*******************************************************************************************************************
            // Check if the user is logged in
            if (isset($_SESSION['login']) AND isset($_SESSION['name']) AND
                isset($_SESSION['role'])) {
                // Retrieve the user role. This could come from a session variable, a database query, etc.
                $userRole = $_SESSION['role']; //find users role
                // Check if the user has the desired role
                if ($userRole == '1') {
                    // Content for admin users
                    // Check if 'purchase_price' is set in $row
                    if (isset($row['purchase_price'])) {
                        // Echo the HTML code with the purchase price
                        echo "<div class=\"col5\">$" . htmlspecialchars($row['purchase_price']) . "</div>";
                    } else {
                        echo "<div>Price not available.</div>";
                    }
                } else {
                    // Content for other roles or a message
                    echo "<div>This content is for admin users.</div>";
                }
            } else {
                // User is not logged in
                echo "<div>Please log in to view this content.</div>";
            }
            //special feature*******************************************************************************************************************
            ?>
        </div>
        <div>
            <a href="addtocart.php?product_id=<?= $id ?>">
                <img src="www/img/addtocart_button.jpg" width="150" height="50"/>
            </a>
        </div>
    </div>

<?php
$confirm = "";
if(isset($_GET['m'])) {
    if($_GET['m'] == "insert") {
        $confirm = "You have successfully added the into the database.";
    } else if($_GET['m'] === "update") {
        $confirm = "You have successfully updated the product details.";
    }
}
?>
    <br><br><hr><br>
    <div class="productlist-button" style="text-align: center;">
        <div style="color: red; display: inline-block"><?= $confirm ?></div>
        <br>
        <input style="width: 75px;" type="button" onclick="window.location.href='editproductOG.php?id=<?= $id ?>'" value="Edit">
        <input style="width: 75px;" type="button" onclick="window.location.href='deleteproduct.php?id=<?= $id ?>'" value="Delete">
        <input style="width: 75px;" type="button" onclick="window.location.href='products.php'" value="Cancel">
    </div>
    <br>

<?php
require_once ('includes/footer.php');